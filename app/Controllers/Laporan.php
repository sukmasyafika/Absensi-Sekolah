<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Laporan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Laporan',
        ];

        return view('admin/laporan/index', $data);
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
    public function absensiExcel()
    {
        $filter = $this->request->getGet();
        $absensiModel = new AbsensiModel();
        $data = $absensiModel->getFilteredAbsensi($filter);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Siswa')
            ->setCellValue('C1', 'Mata Pelajaran')
            ->setCellValue('D1', 'Tanggal')
            ->setCellValue('E1', 'Semester')
            ->setCellValue('F1', 'Kehadiran');

        // Data
        $row = 2;
        $no = 1;
        foreach ($data as $absen) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $absen['nama'])
                ->setCellValue('C' . $row, $absen['mapel'])
                ->setCellValue('D' . $row, $absen['tanggal'])
                ->setCellValue('E' . $row, $absen['semester'])
                ->setCellValue('F' . $row, $absen['status']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan-Absensi.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function absensiPdf()
    {
        $filter = $this->request->getGet();
        $absensiModel = new AbsensiModel();
        $data['absensi'] = $absensiModel->getFilteredAbsensi($filter);

        $dompdf = new Dompdf();
        $html = view('laporan/pdf_absensi', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Laporan-Absensi.pdf', ['Attachment' => false]);
        exit;
    }
}
