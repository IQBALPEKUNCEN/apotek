<?php

namespace app\controllers;

use app\models\Transaksi;
use app\models\TransaksiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\db\Expression;
use Yii;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete', 'view', 'laporan', 'laporan-periode', 'laporan-obat', 'export-excel'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // admin bisa semua
                    ],
                    [
                        'allow' => true,
                        'roles' => ['kasir'], // kasir terbatas
                        'actions' => ['index', 'create', 'view', 'laporan', 'laporan-periode', 'laporan-obat', 'export-excel'],
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

    /**
     * Lists all Transaksi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransaksiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaksi model.
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
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Transaksi();
        $model->tanggal = date('Y-m-d');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Transaksi berhasil diupdate!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transaksi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Transaksi berhasil dihapus!');

        return $this->redirect(['index']);
    }

    /**
     * Laporan Transaksi
     * Menampilkan laporan transaksi berdasarkan filter tanggal
     * @return string
     */
    public function actionLaporan()
    {
        // Buat model untuk form filter
        $model = new \yii\base\DynamicModel(['tanggal_awal', 'tanggal_akhir']);
        $model->addRule(['tanggal_awal', 'tanggal_akhir'], 'safe');

        // Load data dari request
        $model->load(Yii::$app->request->get());

        // Set default value jika kosong
        $tanggalMulai = $model->tanggal_awal ?: date('Y-m-01'); // Default awal bulan
        $tanggalSelesai = $model->tanggal_akhir ?: date('Y-m-d'); // Default hari ini
        $exportPdf = Yii::$app->request->get('export', false);

        // Query untuk laporan
        $query = Transaksi::find();

        // Filter berdasarkan tanggal
        if ($tanggalMulai && $tanggalSelesai) {
            $query->andWhere(['between', 'tanggal', $tanggalMulai, $tanggalSelesai]);
        } elseif ($tanggalMulai) {
            $query->andWhere(['>=', 'tanggal', $tanggalMulai]);
        } elseif ($tanggalSelesai) {
            $query->andWhere(['<=', 'tanggal', $tanggalSelesai]);
        }

        // Urutkan berdasarkan tanggal terbaru
        $query->orderBy(['tanggal' => SORT_DESC, 'id' => SORT_DESC]);

        // Buat data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $exportPdf ? 0 : 20, // Jika export, tampilkan semua
            ],
        ]);

        // Hitung total transaksi
        $totalTransaksi = $query->sum('total_harga') ?? 0;
        $jumlahTransaksi = $query->count();

        // Hitung rata-rata transaksi
        $rataRataTransaksi = $jumlahTransaksi > 0 ? $totalTransaksi / $jumlahTransaksi : 0;

        // Jika export PDF
        if ($exportPdf == 'pdf') {
            return $this->renderPartial('laporan-pdf', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'tanggalMulai' => $tanggalMulai,
                'tanggalSelesai' => $tanggalSelesai,
                'totalTransaksi' => $totalTransaksi,
                'jumlahTransaksi' => $jumlahTransaksi,
                'rataRataTransaksi' => $rataRataTransaksi,
            ]);
        }

        // Tampilkan halaman laporan
        return $this->render('laporan', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalTransaksi' => $totalTransaksi,
            'jumlahTransaksi' => $jumlahTransaksi,
            'rataRataTransaksi' => $rataRataTransaksi,
        ]);
    }

    /**
     * Laporan per Periode (Harian, Bulanan, Tahunan)
     * @return string
     */
    public function actionLaporanPeriode()
    {
        // Buat model untuk form filter
        $model = new \yii\base\DynamicModel(['periode', 'tahun', 'bulan', 'tanggal']);
        $model->addRule(['periode', 'tahun', 'bulan', 'tanggal'], 'safe');

        // Load data dari request
        $model->load(Yii::$app->request->get());

        $periode = $model->periode ?: 'bulanan'; // harian, bulanan, tahunan
        $tahun = $model->tahun ?: date('Y');
        $bulan = $model->bulan ?: date('m');
        $tanggal = $model->tanggal ?: date('Y-m-d');

        // Query berdasarkan periode
        $data = [];

        switch ($periode) {
            case 'harian':
                // Laporan harian (per jam)
                $sql = "
                    SELECT 
                        DATE_FORMAT(tanggal, '%H:00') as periode,
                        COUNT(*) as jumlah,
                        SUM(total_harga) as total
                    FROM transaksi
                    WHERE tanggal = :tanggal
                    GROUP BY DATE_FORMAT(tanggal, '%H:00')
                    ORDER BY periode ASC
                ";
                $data = Yii::$app->db->createCommand($sql)
                    ->bindValue(':tanggal', $tanggal)
                    ->queryAll();
                break;

            case 'bulanan':
                // Laporan bulanan (per hari dalam bulan)
                $sql = "
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m-%d') as periode,
                        COUNT(*) as jumlah,
                        SUM(total_harga) as total
                    FROM transaksi
                    WHERE YEAR(tanggal) = :tahun AND MONTH(tanggal) = :bulan
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m-%d')
                    ORDER BY periode ASC
                ";
                $data = Yii::$app->db->createCommand($sql)
                    ->bindValue(':tahun', $tahun)
                    ->bindValue(':bulan', $bulan)
                    ->queryAll();
                break;

            case 'tahunan':
                // Laporan tahunan (per bulan)
                $sql = "
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m') as periode,
                        COUNT(*) as jumlah,
                        SUM(total_harga) as total
                    FROM transaksi
                    WHERE YEAR(tanggal) = :tahun
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
                    ORDER BY periode ASC
                ";
                $data = Yii::$app->db->createCommand($sql)
                    ->bindValue(':tahun', $tahun)
                    ->queryAll();
                break;
        }

        // Hitung total keseluruhan
        $totalKeseluruhan = array_sum(array_column($data, 'total'));
        $jumlahTransaksi = array_sum(array_column($data, 'jumlah'));

        // Buat data provider dari array
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('laporan-periode', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'data' => $data,
            'periode' => $periode,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'tanggal' => $tanggal,
            'totalKeseluruhan' => $totalKeseluruhan,
            'jumlahTransaksi' => $jumlahTransaksi,
        ]);
    }

    /**
     * Laporan Transaksi per Obat
     * Menampilkan obat mana yang paling laku
     * @return string
     */
    public function actionLaporanObat()
    {
        // Buat model untuk form filter
        $model = new \yii\base\DynamicModel(['tanggal_awal', 'tanggal_akhir']);
        $model->addRule(['tanggal_awal', 'tanggal_akhir'], 'safe');

        // Load data dari request
        $model->load(Yii::$app->request->get());

        $tanggalMulai = $model->tanggal_awal ?: date('Y-m-01');
        $tanggalSelesai = $model->tanggal_akhir ?: date('Y-m-d');

        // Cek kolom yang tersedia di tabel transaksi_detil
        // Kemungkinan nama kolom: jumlah, qty, quantity, jml
        $tableSchema = Yii::$app->db->schema->getTableSchema('transaksi_detil');
        $columns = $tableSchema->columnNames;

        // Tentukan nama kolom yang benar
        $qtyColumn = 'jumlah'; // default
        if (in_array('qty', $columns)) {
            $qtyColumn = 'qty';
        } elseif (in_array('quantity', $columns)) {
            $qtyColumn = 'quantity';
        } elseif (in_array('jml', $columns)) {
            $qtyColumn = 'jml';
        }

        // Tentukan nama kolom harga
        $hargaColumn = 'harga_jual'; // default
        if (in_array('harga', $columns)) {
            $hargaColumn = 'harga';
        } elseif (in_array('harga_satuan', $columns)) {
            $hargaColumn = 'harga_satuan';
        } elseif (in_array('subtotal', $columns)) {
            // Jika ada subtotal, gunakan langsung
            $sql = "
                SELECT 
                    o.id,
                    o.nama_obat,
                    o.kategori,
                    o.harga_jual,
                    COUNT(td.id) AS transaksi_terjual,
                    SUM(td.$qtyColumn) AS total_qty,
                    SUM(td.subtotal) AS total_penjualan
                FROM obat o
                LEFT JOIN transaksi_detil td ON o.id = td.obat_id
                LEFT JOIN transaksi t ON td.transaksi_id = t.id
                WHERE t.tanggal BETWEEN :tanggal_mulai AND :tanggal_selesai
                GROUP BY o.id, o.nama_obat, o.kategori, o.harga_jual
                HAVING total_qty > 0
                ORDER BY total_penjualan DESC
            ";
        } else {
            // Hitung dari qty * harga
            $sql = "
                SELECT 
                    o.id,
                    o.nama_obat,
                    o.kategori,
                    o.harga_jual,
                    COUNT(td.id) AS transaksi_terjual,
                    SUM(td.$qtyColumn) AS total_qty,
                    SUM(td.$qtyColumn * td.$hargaColumn) AS total_penjualan
                FROM obat o
                LEFT JOIN transaksi_detil td ON o.id = td.obat_id
                LEFT JOIN transaksi t ON td.transaksi_id = t.id
                WHERE t.tanggal BETWEEN :tanggal_mulai AND :tanggal_selesai
                GROUP BY o.id, o.nama_obat, o.kategori, o.harga_jual
                HAVING total_qty > 0
                ORDER BY total_penjualan DESC
            ";
        }

        // Jika query di atas masih error, gunakan query alternatif yang lebih sederhana
        try {
            $data = Yii::$app->db->createCommand($sql)
                ->bindValue(':tanggal_mulai', $tanggalMulai)
                ->bindValue(':tanggal_selesai', $tanggalSelesai)
                ->queryAll();
        } catch (\Exception $e) {
            // Query alternatif - ambil semua kolom dari transaksi_detil
            $sql = "
                SELECT 
                    o.id,
                    o.nama_obat,
                    o.kategori,
                    o.harga_jual,
                    COUNT(DISTINCT t.id) AS transaksi_terjual,
                    COUNT(td.id) AS total_qty,
                    SUM(o.harga_jual) AS total_penjualan
                FROM obat o
                INNER JOIN transaksi_detil td ON o.id = td.obat_id
                INNER JOIN transaksi t ON td.transaksi_id = t.id
                WHERE t.tanggal BETWEEN :tanggal_mulai AND :tanggal_selesai
                GROUP BY o.id, o.nama_obat, o.kategori, o.harga_jual
                ORDER BY total_penjualan DESC
            ";

            $data = Yii::$app->db->createCommand($sql)
                ->bindValue(':tanggal_mulai', $tanggalMulai)
                ->bindValue(':tanggal_selesai', $tanggalSelesai)
                ->queryAll();
        }

        // Buat data provider dari array
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // Hitung total penjualan
        $totalPenjualan = array_sum(array_column($data, 'total_penjualan'));

        return $this->render('laporan-obat', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalPenjualan' => $totalPenjualan,
        ]);
    }

    /**
     * Export Laporan ke Excel
     * @return mixed
     */
    public function actionExportExcel()
    {
        $tanggalMulai = Yii::$app->request->get('tanggal_mulai', date('Y-m-01'));
        $tanggalSelesai = Yii::$app->request->get('tanggal_selesai', date('Y-m-d'));

        $query = Transaksi::find()
            ->andWhere(['between', 'tanggal', $tanggalMulai, $tanggalSelesai])
            ->orderBy(['tanggal' => SORT_DESC]);

        $transaksi = $query->all();

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_' . date('YmdHis') . '.xls"');
        header('Cache-Control: max-age=0');

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th colspan="6" style="text-align:center;"><h2>LAPORAN TRANSAKSI PENJUALAN</h2></th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th colspan="6">Periode: ' . date('d-m-Y', strtotime($tanggalMulai)) . ' s/d ' . date('d-m-Y', strtotime($tanggalSelesai)) . '</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Nama Pelanggan</th>';
        echo '<th>Total Harga</th>';
        echo '<th>Bayar</th>';
        echo '<th>Kembalian</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $no = 1;
        $total = 0;
        foreach ($transaksi as $item) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($item->tanggal)) . '</td>';
            echo '<td>' . $item->nama_pelanggan . '</td>';
            echo '<td style="text-align:right;">Rp ' . number_format($item->total_harga, 0, ',', '.') . '</td>';
            echo '<td style="text-align:right;">Rp ' . number_format($item->bayar, 0, ',', '.') . '</td>';
            echo '<td style="text-align:right;">Rp ' . number_format($item->kembalian, 0, ',', '.') . '</td>';
            echo '</tr>';
            $total += $item->total_harga;
        }

        echo '<tr>';
        echo '<td colspan="3"><strong>TOTAL PENJUALAN</strong></td>';
        echo '<td style="text-align:right;"><strong>Rp ' . number_format($total, 0, ',', '.') . '</strong></td>';
        echo '<td colspan="2"></td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';

        exit;
    }

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
