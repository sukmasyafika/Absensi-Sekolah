<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

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
    public function exportExcel()
    {
        $absensiModel = new \App\Models\AbsensiModel();
        $data = $absensiModel->getRekapAbsensiLengkap(); // atau getRekapAbsensi()

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C1', 'Jenis Kelamin');
        $sheet->setCellValue('D1', 'Kelas');
        $sheet->setCellValue('E1', 'Jurusan');
        $sheet->setCellValue('F1', 'Mata Pelajaran');
        $sheet->setCellValue('G1', 'Semester');
        $sheet->setCellValue('H1', 'Hadir');
        $sheet->setCellValue('I1', 'Sakit');
        $sheet->setCellValue('J1', 'Izin');
        $sheet->setCellValue('K1', 'Alpa');
        $sheet->setCellValue('L1', 'Total Pertemuan');

        // Isi data
        $no = 1;
        $baris = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $row->nama);
            $sheet->setCellValue('C' . $baris, $row->jenis_kelamin);
            $sheet->setCellValue('D' . $baris, $row->nama_kls . ' ' . $row->rombel);
            $sheet->setCellValue('E' . $baris, $row->kode_jurusan);
            $sheet->setCellValue('F' . $baris, $row->nama_mapel);
            $sheet->setCellValue('G' . $baris, $row->semester);
            $sheet->setCellValue('H' . $baris, $row->hadir);
            $sheet->setCellValue('I' . $baris, $row->sakit);
            $sheet->setCellValue('J' . $baris, $row->izin);
            $sheet->setCellValue('K' . $baris, $row->alpa);
            $sheet->setCellValue('L' . $baris, $row->total);
            $baris++;
        }

        // Buat file excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Absensi_' . date('Ymd_His') . '.xlsx';

        // Output langsung ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $absensiModel = new \App\Models\AbsensiModel();
        $data = $absensiModel->getRekapAbsensiLengkap();

        $html = view('admin/laporan/pdf_absen', ['data' => $data]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('Laporan_Absensi_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
    }
}
