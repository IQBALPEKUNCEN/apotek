<?php

namespace app\controllers;

use app\models\Pembelian;
use app\models\PembelianSearch;
use app\models\Obat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use Yii;

class PembelianController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete', 'view', 'laporan', 'laporan-periode', 'laporan-supplier', 'laporan-obat', 'statistik'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['kasir'],
                        'actions' => ['index', 'create', 'view', 'laporan', 'laporan-periode', 'laporan-supplier', 'laporan-obat'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PembelianSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Pembelian();
        $model->tanggal = date('Y-m-d');

        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->load($this->request->post())) {
                    $obatIds = Yii::$app->request->post('obat_id', []);
                    $jumlahs = Yii::$app->request->post('jumlah', []);
                    $hargaBelis = Yii::$app->request->post('harga_beli', []);

                    if (empty($obatIds)) {
                        Yii::$app->session->setFlash('error', 'Detail pembelian tidak boleh kosong!');
                        $transaction->rollBack();
                        return $this->render('create', ['model' => $model]);
                    }

                    if ($model->save()) {
                        foreach ($obatIds as $key => $obatId) {
                            if (!empty($obatId) && !empty($jumlahs[$key]) && isset($hargaBelis[$key])) {
                                $obat = Obat::findOne($obatId);
                                if ($obat) {
                                    $obat->stok += $jumlahs[$key];
                                    if (!$obat->save()) {
                                        throw new \Exception('Gagal update stok obat: ' . $obat->nama_obat);
                                    }
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Pembelian berhasil disimpan!');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        throw new \Exception('Gagal menyimpan pembelian');
                    }
                }

                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Pembelian berhasil diupdate!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Pembelian berhasil dihapus!');
        return $this->redirect(['index']);
    }

    public function actionLaporan()
    {
        $tanggalMulai = Yii::$app->request->get('tanggal_mulai', date('Y-m-01'));
        $tanggalSelesai = Yii::$app->request->get('tanggal_selesai', date('Y-m-d'));
        $supplierId = Yii::$app->request->get('supplier_id', '');
        $exportPdf = Yii::$app->request->get('export', false);

        $query = Pembelian::find()->with(['supplier']);

        if ($tanggalMulai && $tanggalSelesai) {
            $query->andWhere(['between', 'tanggal', $tanggalMulai, $tanggalSelesai]);
        }

        if ($supplierId) {
            $query->andWhere(['supplier_id' => $supplierId]);
        }

        $query->orderBy(['tanggal' => SORT_DESC, 'id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $exportPdf ? 0 : 20],
        ]);

        $totalPembelian = $query->sum('total') ?? 0;
        $jumlahPembelian = $query->count();
        $rataRataPembelian = $jumlahPembelian > 0 ? $totalPembelian / $jumlahPembelian : 0;

        if ($exportPdf == 'pdf') {
            return $this->renderPartial('laporan-pdf', compact(
                'dataProvider',
                'tanggalMulai',
                'tanggalSelesai',
                'supplierId',
                'totalPembelian',
                'jumlahPembelian',
                'rataRataPembelian'
            ));
        }

        return $this->render('laporan', compact(
            'dataProvider',
            'tanggalMulai',
            'tanggalSelesai',
            'supplierId',
            'totalPembelian',
            'jumlahPembelian',
            'rataRataPembelian'
        ));
    }

    public function actionLaporanPeriode()
    {
        $periode = Yii::$app->request->get('periode', 'bulanan');
        $tahun = Yii::$app->request->get('tahun', date('Y'));
        $bulan = Yii::$app->request->get('bulan', date('m'));
        $tanggal = Yii::$app->request->get('tanggal', date('Y-m-d'));

        $data = [];

        switch ($periode) {
            case 'harian':
                $sql = "SELECT DATE_FORMAT(tanggal, '%H:00') as periode, COUNT(*) as jumlah, SUM(total) as total 
                        FROM pembelian WHERE tanggal = :tanggal GROUP BY DATE_FORMAT(tanggal, '%H:00')";
                $data = Yii::$app->db->createCommand($sql)->bindValue(':tanggal', $tanggal)->queryAll();
                break;

            case 'bulanan':
                $sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m-%d') as periode, COUNT(*) as jumlah, SUM(total) as total
                        FROM pembelian WHERE YEAR(tanggal)=:tahun AND MONTH(tanggal)=:bulan GROUP BY DATE_FORMAT(tanggal, '%Y-%m-%d')";
                $data = Yii::$app->db->createCommand($sql)->bindValue(':tahun', $tahun)->bindValue(':bulan', $bulan)->queryAll();
                break;

            case 'tahunan':
                $sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') as periode, COUNT(*) as jumlah, SUM(total) as total
                        FROM pembelian WHERE YEAR(tanggal)=:tahun GROUP BY DATE_FORMAT(tanggal, '%Y-%m')";
                $data = Yii::$app->db->createCommand($sql)->bindValue(':tahun', $tahun)->queryAll();
                break;
        }

        $totalKeseluruhan = array_sum(array_column($data, 'total'));
        $jumlahPembelian = array_sum(array_column($data, 'jumlah'));

        return $this->render('laporan-periode', compact(
            'data',
            'periode',
            'tahun',
            'bulan',
            'tanggal',
            'totalKeseluruhan',
            'jumlahPembelian'
        ));
    }

    public function actionLaporanSupplier()
    {
        $tanggalMulai = Yii::$app->request->get('tanggal_mulai', date('Y-m-01'));
        $tanggalSelesai = Yii::$app->request->get('tanggal_selesai', date('Y-m-t'));
        $supplierId = Yii::$app->request->get('supplier_id', null);

        // ✅ Pastikan pakai supplier_id sesuai tabel
        $query = (new \yii\db\Query())
            ->select([
                'supplier.nama_supplier AS supplier',
                'COUNT(pembelian.id) AS jumlah',
                'SUM(pembelian.total) AS total'
            ])
            ->from('pembelian')
            ->innerJoin('supplier', 'supplier.id = pembelian.supplier_id')
            ->where(['between', 'tanggal', $tanggalMulai, $tanggalSelesai])
            ->groupBy('supplier.id');

        if ($supplierId) {
            $query->andWhere(['supplier.id' => $supplierId]);
        }

        $data = $query->all();

        $totalPembelian = 0;
        $jumlahPembelian = 0;

        foreach ($data as $row) {
            $totalPembelian += $row['total'];
            $jumlahPembelian += $row['jumlah'];
        }

        return $this->render('laporan-supplier', [
            'data' => $data,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'supplierId' => $supplierId,
            'totalPembelian' => $totalPembelian,
            'jumlahPembelian' => $jumlahPembelian,
        ]);
    }

    public function actionLaporanObat()
    {
        $tanggalMulai = Yii::$app->request->get('tanggal_mulai', date('Y-m-01'));
        $tanggalSelesai = Yii::$app->request->get('tanggal_selesai', date('Y-m-d'));
        $supplierId = Yii::$app->request->get('supplier_id', '');

        $query = Pembelian::find()->andWhere(['between', 'tanggal', $tanggalMulai, $tanggalSelesai]);

        if ($supplierId) {
            $query->andWhere(['supplier_id' => $supplierId]);
        }

        $pembelianList = $query->all();

        $dataObat = [];

        return $this->render('laporan-obat', [
            'data' => $dataObat,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'supplierId' => $supplierId,
        ]);
    }

    public function actionStatistik()
    {
        $pembelianHariIni = Pembelian::find()->where(['tanggal' => date('Y-m-d')])->sum('total') ?? 0;

        $pembelianBulanIni = Yii::$app->db->createCommand(
            "SELECT SUM(total) FROM pembelian WHERE YEAR(tanggal)=:tahun AND MONTH(tanggal)=:bulan"
        )->bindValue(':tahun', date('Y'))->bindValue(':bulan', date('m'))->queryScalar() ?? 0;

        $pembelianTahunIni = Yii::$app->db->createCommand(
            "SELECT SUM(total) FROM pembelian WHERE YEAR(tanggal)=:tahun"
        )->bindValue(':tahun', date('Y'))->queryScalar() ?? 0;

        $totalSemuaPembelian = Pembelian::find()->sum('total') ?? 0;

        $topSupplier = Yii::$app->db->createCommand("
            SELECT s.nama_supplier, SUM(p.total) as total
            FROM pembelian p JOIN supplier s ON p.supplier_id = s.id
            WHERE YEAR(p.tanggal) = YEAR(CURDATE()) AND MONTH(p.tanggal) = MONTH(CURDATE())
            GROUP BY s.id, s.nama_supplier
            ORDER BY total DESC
            LIMIT 5
        ")->queryAll();

        $grafikBulanan = Yii::$app->db->createCommand("
            SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(total) as total
            FROM pembelian WHERE YEAR(tanggal)=:tahun GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
        ")->bindValue(':tahun', date('Y'))->queryAll();

        return $this->render('statistik', compact(
            'pembelianHariIni',
            'pembelianBulanIni',
            'pembelianTahunIni',
            'totalSemuaPembelian',
            'topSupplier',
            'grafikBulanan'
        ));
    }

    protected function findModel($id)
    {
        if (($model = Pembelian::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
