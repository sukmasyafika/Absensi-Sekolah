<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    protected $siswaModel, $jadwalModel, $absensiModel, $kelasModel, $mapelModel, $guruModel;

    public function index()
    {
        $data = [
            'title' => 'Laporan',
        ];

        return view('admin/laporan/index', $data);
    }

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->absensiModel = new AbsensiModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->guruModel = new GuruModel();
    }

    public function getSiswa()
    {
        $siswaModel = new \App\Models\SiswaModel();
        $data = $siswaModel->findAll();

        return $this->response->setJSON($data);
    }
    public function getAbsensi()
    {
        $absensiModel = new AbsensiModel();
        $data = $absensiModel->getAbsen();

        return $this->response->setJSON($data);
    }

    // ================================================
    // Laporan Siswa
    // ================================================
    public function siswaExcel()
    {
        $filter = $this->request->getGet();
        $siswaModel = new SiswaModel();
        $data = $siswaModel->getFilteredData($filter);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'NISN')
            ->setCellValue('C1', 'Nama Siswa')
            ->setCellValue('D1', 'Jenis Kelamin')
            ->setCellValue('E1', 'Agama')
            ->setCellValue('F1', 'Kelas')
            ->setCellValue('G1', 'Jurusan')
            ->setCellValue('H1', 'rombel');


        // Data
        $row = 2;
        $no = 1;
        foreach ($data as $siswa) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $siswa['nisn'])
                ->setCellValue('C' . $row, $siswa['nama'])
                ->setCellValue('D' . $row, $siswa['jenis_kelamin'])
                ->setCellValue('E' . $row, $siswa['agama'])
                ->setCellValue('F' . $row, $siswa['kelas_name'])
                ->setCellValue('G' . $row, $siswa['jurusan_name'])
                ->setCellValue('H' . $row, $siswa['rombel']);

            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan-Siswa.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function siswaPdf()
    {
        $filter = $this->request->getGet();
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->getFilteredData($filter);

        $dompdf = new Dompdf();
        $html = view('admin/laporan/pdf_siswa', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan-Siswa.pdf', ['Attachment' => false]);
        exit;
    }
    public function siswa_pdf()
    {
        $filter = $this->request->getGet(); // jika ingin pakai filter
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->getFilteredData($filter); // atau ->findAll()

        return view('admin/laporan/pdf_siswa', $data);
    }
    public function siswa()
    {
        $filter = $this->request->getGet();
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->getFilteredData($filter);

        return view('admin/laporan/pdf_siswa', $data);
    }

    // ================================================
    // Laporan Absensi
    // ================================================
    public function exportpdf()
    {
        $dompdf = new Dompdf();

        $id_kelas = $this->request->getGet('id_kelas');
        $id_mapel = $this->request->getGet('id_mapel');
        $dari     = $this->request->getGet('dari');
        $sampai   = $this->request->getGet('sampai');

        $siswa = $this->siswaModel->getSiswa();
        $jadwal = $this->jadwalModel
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Data jadwal tidak ditemukan. Pastikan kelas dan mapel sudah sesuai.');
        }

        $id_jadwal = $jadwal->id;

        $tanggalPertemuan = $this->absensiModel
            ->select('pertemuan_ke, tanggal')
            ->where('id_jadwal', $id_jadwal)
            ->where('tanggal >=', $dari)
            ->where('tanggal <=', $sampai)
            ->groupBy('pertemuan_ke, tanggal')
            ->orderBy('pertemuan_ke', 'ASC')
            ->findAll();

        $rekapAbsensi = [];

        foreach ($siswa as $s) {
            $rekap = new \stdClass();
            $rekap->id = $s->id;
            $rekap->nama = $s->nama;
            $rekap->jk = $s->jenis_kelamin;
            $rekap->kehadiran = [];

            foreach ($tanggalPertemuan as $t) {
                $absen = $this->absensiModel
                    ->where('id_jadwal', $id_jadwal)
                    ->where('id_siswa', $s->id)
                    ->where('pertemuan_ke', $t->pertemuan_ke)
                    ->first();

                $status = $absen->status ?? '-';
                $rekap->kehadiran[$t->pertemuan_ke] = $status;
            }

            $rekapAbsensi[] = $rekap;
        }

        $data = [
            'siswa' => $rekapAbsensi,
            'tanggalPertemuan' => $tanggalPertemuan,
            'kelas' => $this->kelasModel->find($id_kelas),
            'mapel' => $this->mapelModel->find($id_mapel),
            'guru' => $this->guruModel->where('id_mapel', $id_mapel)->first(),
            'tahun_ajaran' => 'Genap - 2021/2022',
            'tgl_cetak' => date('d-m-Y'),
        ];

        $html = view('admin/laporan/pdf_absen', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan-absensi.pdf' . date('Ymd_His') . '.pdf', ['Attachment' => false]);
    }
}
