<?php

namespace app\controllers;

use app\models\Obat;
use app\models\ObatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

/**
 * ObatController implements the CRUD actions for Obat model.
 */
class ObatController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Obat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ObatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Statistik untuk dashboard
        $totalObat = Obat::find()->count();
        $stokRendah = Obat::find()->where(['<', 'stok', 10])->count();
        $stokHabis = Obat::find()->where(['stok' => 0])->count();

        // Obat yang akan expired dalam 30 hari
        $expiredSoon = Obat::find()
            ->where(['<=', 'expired_date', date('Y-m-d', strtotime('+30 days'))])
            ->andWhere(['>=', 'expired_date', date('Y-m-d')])
            ->count();

        // Obat yang sudah expired
        $expired = Obat::find()
            ->where(['<', 'expired_date', date('Y-m-d')])
            ->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalObat' => $totalObat,
            'stokRendah' => $stokRendah,
            'stokHabis' => $stokHabis,
            'expiredSoon' => $expiredSoon,
            'expired' => $expired,
        ]);
    }

    /**
     * Displays a single Obat model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Obat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Obat();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validasi kode obat unik
                if (Obat::find()->where(['kode_obat' => $model->kode_obat])->exists()) {
                    Yii::$app->session->setFlash('error', 'Kode obat sudah digunakan. Gunakan kode yang berbeda.');
                    return $this->render('create', ['model' => $model]);
                }

                // Validasi harga jual > harga beli
                if ($model->harga_jual <= $model->harga_beli) {
                    Yii::$app->session->setFlash('error', 'Harga jual harus lebih besar dari harga beli.');
                    return $this->render('create', ['model' => $model]);
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data obat "' . $model->nama_obat . '" berhasil ditambahkan.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
            // Generate kode obat otomatis
            $model->kode_obat = $this->generateKodeObat();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Obat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldKodeObat = $model->kode_obat;

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Validasi kode obat unik (jika diubah)
            if ($model->kode_obat !== $oldKodeObat) {
                if (Obat::find()->where(['kode_obat' => $model->kode_obat])->exists()) {
                    Yii::$app->session->setFlash('error', 'Kode obat sudah digunakan. Gunakan kode yang berbeda.');
                    return $this->render('update', ['model' => $model]);
                }
            }

            // Validasi harga jual > harga beli
            if ($model->harga_jual <= $model->harga_beli) {
                Yii::$app->session->setFlash('error', 'Harga jual harus lebih besar dari harga beli.');
                return $this->render('update', ['model' => $model]);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data obat "' . $model->nama_obat . '" berhasil diupdate.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Obat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $namaObat = $model->nama_obat;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Data obat "' . $namaObat . '" berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data obat.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Export data obat ke CSV (Alternative to Excel)
     * @return Response
     */
    public function actionExport()
    {
        $searchModel = new ObatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false; // Get all data

        $models = $dataProvider->getModels();

        // Set headers for CSV download
        $filename = 'Data_Obat_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Add UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Write header row
        fputcsv($output, [
            'No',
            'Kode Obat',
            'Nama Obat',
            'Kategori',
            'Stok',
            'Harga Beli',
            'Harga Jual',
            'Margin',
            'Margin %',
            'Nilai Stok',
            'Tanggal Expired',
            'Status'
        ]);

        // Write data rows
        $no = 1;
        foreach ($models as $model) {
            $margin = $model->harga_jual - $model->harga_beli;
            $marginPercent = $model->harga_beli > 0 ? round(($margin / $model->harga_beli) * 100, 2) : 0;
            $nilaiStok = $model->stok * $model->harga_beli;

            // Status
            $status = 'Normal';
            if ($model->stok == 0) {
                $status = 'HABIS';
            } elseif ($model->stok < 10) {
                $status = 'Stok Rendah';
            }

            // Check expired
            if (!empty($model->expired_date)) {
                $expiredDate = new \DateTime($model->expired_date);
                $now = new \DateTime();
                if ($expiredDate < $now) {
                    $status .= ' / KADALUARSA';
                } elseif ($expiredDate < $now->modify('+30 days')) {
                    $status .= ' / Akan Expired';
                }
            }

            fputcsv($output, [
                $no,
                $model->kode_obat,
                $model->nama_obat,
                $model->kategori,
                $model->stok,
                'Rp ' . number_format($model->harga_beli, 0, ',', '.'),
                'Rp ' . number_format($model->harga_jual, 0, ',', '.'),
                'Rp ' . number_format($margin, 0, ',', '.'),
                $marginPercent . '%',
                'Rp ' . number_format($nilaiStok, 0, ',', '.'),
                $model->expired_date ? Yii::$app->formatter->asDate($model->expired_date, 'php:d/m/Y') : '-',
                $status
            ]);

            $no++;
        }

        fclose($output);
        exit;
    }

    /**
     * Laporan stok rendah
     * @return string
     */
    public function actionStokRendah()
    {
        $models = Obat::find()
            ->where(['<', 'stok', 10])
            ->orderBy(['stok' => SORT_ASC])
            ->all();

        return $this->render('stok-rendah', [
            'models' => $models,
        ]);
    }

    /**
     * Laporan obat expired
     * @return string
     */
    public function actionExpired()
    {
        // Obat yang sudah expired
        $expired = Obat::find()
            ->where(['<', 'expired_date', date('Y-m-d')])
            ->orderBy(['expired_date' => SORT_ASC])
            ->all();

        // Obat yang akan expired dalam 30 hari
        $willExpired = Obat::find()
            ->where(['between', 'expired_date', date('Y-m-d'), date('Y-m-d', strtotime('+30 days'))])
            ->orderBy(['expired_date' => SORT_ASC])
            ->all();

        return $this->render('expired', [
            'expired' => $expired,
            'willExpired' => $willExpired,
        ]);
    }

    /**
     * AJAX: Check kode obat availability
     * @return Response
     */
    public function actionCheckKode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $kode = Yii::$app->request->post('kode');
        $id = Yii::$app->request->post('id', null);

        $query = Obat::find()->where(['kode_obat' => $kode]);

        if ($id) {
            $query->andWhere(['!=', 'id', $id]);
        }

        $exists = $query->exists();

        return [
            'available' => !$exists,
            'message' => $exists ? 'Kode obat sudah digunakan' : 'Kode obat tersedia'
        ];
    }

    /**
     * Generate kode obat otomatis
     * @return string
     */
    private function generateKodeObat()
    {
        $prefix = 'OBT';
        $lastObat = Obat::find()
            ->where(['like', 'kode_obat', $prefix])
            ->orderBy(['kode_obat' => SORT_DESC])
            ->one();

        if ($lastObat) {
            $lastNumber = (int) substr($lastObat->kode_obat, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Finds the Obat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Obat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Obat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang Anda cari tidak ditemukan.');
    }
}
