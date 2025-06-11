<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AbsensiModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\SiswaModel;
use App\Models\KetAbsenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Rekap extends BaseController
{
    protected $absensiModel, $mapelModel, $kelasModel, $siswaModel, $jadwalModel, $ketAbsenModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->ketAbsenModel = new KetAbsenModel();
    }

    public function index()
    {
        $guruId = session()->get('id_guru');

        $id_kelas  = $this->request->getGet('id_kelas');
        $id_mapel  = $this->request->getGet('id_mapel');
        $dari      = $this->request->getGet('dari');
        $sampai    = $this->request->getGet('sampai');

        $kelas = $this->jadwalModel->getKelasRekap($guruId);
        $mapel = $this->jadwalModel->getMapelRekap($guruId);
        $rekap = [];

        if ($id_kelas && $id_mapel) {
            $jadwal = $this->jadwalModel->getCekJadwal($id_mapel, $id_kelas, $guruId);

            if (!$jadwal) {
                session()->setFlashdata('error', 'Jadwal tidak ditemukan untuk kelas dan mata pelajaran yang dipilih.');
            } else {

                if (!$jadwal) {
                    session()->setFlashdata('error', 'Kombinasi kelas & mapel tidak ditemukan dalam jadwal Anda.');
                    return redirect()->back()->withInput();
                }

                $rekap = $this->absensiModel->getRekapAbsensiLengkap($id_kelas, $id_mapel, $dari, $sampai);

                if (empty($rekap)) {
                    session()->setFlashdata('error', 'Jadwal tidak ditemukan sesuai filter yang dipilih.');
                }
            }
        }

        $data = [
            'title'     => 'Rekap Absensi',
            'mapel'     => $mapel,
            'kelas'     => $kelas,
            'id_mapel'  => $id_mapel,
            'id_kelas'  => $id_kelas,
            'dari'      => $dari,
            'sampai'    => $sampai,
            'rekap'     => $rekap,
        ];

        return view('users/rekap/index', $data);
    }

    public function cetakLaporan()
    {
        $dompdf = new Dompdf();

        $data['siswa'] = $this->siswaModel->findAll();


        $html = view('users/rekap/absensi_rekap', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('laporan-absensi.pdf', ['Attachment' => false]);
    }

    public function exportExcel()
    {
        $filter_kelas = $this->request->getGet('id_kelas');
        $filter_mapel = $this->request->getGet('id_mapel');
        $filter_dari = $this->request->getGet('dari');
        $filter_sampai = $this->request->getGet('sampai');

        $siswa = $this->absensiModel->getRekapAbsensiLengkap($filter_kelas, $filter_mapel, $filter_dari, $filter_sampai);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REKAP ABSENSI SISWA');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->mergeCells('A2:A3')->setCellValue('A2', 'NO');
        $sheet->mergeCells('B2:B3')->setCellValue('B2', 'NAMA SISWA');
        $sheet->mergeCells('C2:C3')->setCellValue('C2', 'L/P');

        $row = 2;
        $no = 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $s->nama_siswa);
            $sheet->setCellValue('C' . $row, $s->nisn);
            $sheet->setCellValue('D' . $row, $s->jk);
            $sheet->setCellValue('E' . $row, $s->hari . ', ' . $s->tanggal);
            $sheet->setCellValue('F' . $row, $s->waktu . ' (' . $s->jam_mulai . '-' . $s->jam_selesai . ')');
            $sheet->setCellValue('G' . $row, str_pad($s->no_antrian, 3, '0', STR_PAD_LEFT));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data-AntrianSiswa.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save("php://output");
        exit;
    }
}
