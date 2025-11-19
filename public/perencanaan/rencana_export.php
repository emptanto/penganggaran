<?php
// rencana_export.php (Final dengan kolom Kode Program/Rekening tunggal)
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;

require_once '../../config/db.php';
require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/config/auth_check.php';
require_once ROOT_PATH . '/controllers/RencanaController.php';

// --- PERSIAPAN FILTER & PENGAMBILAN DATA ---
$rencanaController = new RencanaController($conn);
$isSuperadmin = ($_SESSION['role'] === 'superadmin');
$userId = $_SESSION['user_id'];
$isReport = isset($_GET['report']) && $_GET['report'] == '1';

// sortBy: urut program, rekening
$sortBy = 'kegiatan.kode_kegiatan ASC, rekening.kode_rekening ASC';
$filters = [
    'isSuperadmin'    => $isReport ? true : $isSuperadmin,
    'userId'          => $userId,
    'filter_kegiatan' => $_GET['filter_kegiatan'] ?? '',
    'filter_rekening' => $_GET['filter_rekening'] ?? '',
    'filter_bulan'    => $_GET['filter_bulan'] ?? '',
    'filter_user'     => $_GET['filter_user'] ?? '',
    'filter_uraian'   => $_GET['filter_uraian'] ?? '',
    'sortBy'          => $sortBy,
    'order'           => 'asc',
];

$result = $rencanaController->getFiltered($filters)['data'];

// --- KELOMPOKKAN DATA ---

$groupedData = [];
$grandTotal = 0;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grandTotal += $row['total_biaya'];

        $kegiatanParts = explode('.', $row['kode_kegiatan']);
        $programKey    = $kegiatanParts[0] ?? '';
        $subProgramKey = ($kegiatanParts[0] ?? '') . '.' . ($kegiatanParts[1] ?? '');
        $kegiatanKey   = ($kegiatanParts[0] ?? '') . '.' . ($kegiatanParts[1] ?? '') . '.' . ($kegiatanParts[2] ?? '');
        $rekeningKey   = $row['kode_rekening'];

        if (!isset($groupedData[$programKey])) {
            $groupedData[$programKey] = [
                'nama'         => $row['program'],
                'sub_programs' => []
            ];
        }
        if (!isset($groupedData[$programKey]['sub_programs'][$subProgramKey])) {
            $groupedData[$programKey]['sub_programs'][$subProgramKey] = [
                'nama'      => $row['sub_program'],
                'kegiatans' => []
            ];
        }
        if (!isset($groupedData[$programKey]['sub_programs'][$subProgramKey]['kegiatans'][$kegiatanKey])) {
            $groupedData[$programKey]['sub_programs'][$subProgramKey]['kegiatans'][$kegiatanKey] = [
                'nama'      => $row['nama_kegiatan'],
                'rekenings' => []
            ];
        }
        if (!isset($groupedData[$programKey]['sub_programs'][$subProgramKey]['kegiatans'][$kegiatanKey]['rekenings'][$rekeningKey])) {
            $groupedData[$programKey]['sub_programs'][$subProgramKey]['kegiatans'][$kegiatanKey]['rekenings'][$rekeningKey] = [
                'nama'  => $row['nama_rekening'],
                'items' => []
            ];
        }
        $groupedData[$programKey]['sub_programs'][$subProgramKey]['kegiatans'][$kegiatanKey]['rekenings'][$rekeningKey]['items'][] = $row;
    }
}

/**
 *  >>> TAMBAHKAN BLOK SORTING INI <<<
 *  Mengurutkan program, sub_program, kegiatan, dan rekening
 *  berdasarkan key kodenya (string) dari kecil ke besar.
 */
if (!empty($groupedData)) {
    // Urut program
    ksort($groupedData, SORT_STRING);

    foreach ($groupedData as &$program) {
        if (!empty($program['sub_programs'])) {
            // Urut sub program
            ksort($program['sub_programs'], SORT_STRING);

            foreach ($program['sub_programs'] as &$subProgram) {
                if (!empty($subProgram['kegiatans'])) {
                    // Urut kegiatan
                    ksort($subProgram['kegiatans'], SORT_STRING);

                    foreach ($subProgram['kegiatans'] as &$kegiatan) {
                        if (!empty($kegiatan['rekenings'])) {
                            // Urut rekening
                            ksort($kegiatan['rekenings'], SORT_STRING);
                        }
                    }
                    unset($kegiatan);
                }
            }
            unset($subProgram);
        }
    }
    unset($program);
}

// --- TULIS DATA KE EXCEL ---
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// --- DEFINISI STYLE ---
$centerAlign     = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]];
$rightAlign      = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]];
$allBorders      = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
$boldFont        = ['font' => ['bold' => true]];
$titleStyle      = array_merge($boldFont, $centerAlign, ['font' => ['size' => 16]]);
$headerStyle     = array_merge($boldFont, $centerAlign, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9EAD3']]]);
$programStyle    = array_merge($boldFont, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'ff99ff']]]);
$subProgramStyle = array_merge($boldFont, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '90d152']]]);
$kegiatanStyle   = array_merge($boldFont, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'fffd00']]]);
$rekeningStyle   = ['font' => ['italic' => true]];
$grandTotalStyle = array_merge($boldFont, $rightAlign, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9D9D9']]]);
$numberFormat    = ['numberFormat' => ['formatCode' => '#,##0']];

// --- PENGATURAN JUDUL DAN HEADER ---
// Sekarang hanya sampai kolom I
$sheet->mergeCells('A1:I1');
$sheet->setCellValue('A1', 'Laporan Rencana Kegiatan dan Anggaran');
$sheet->getStyle('A1')->applyFromArray($titleStyle);

// HEADER BARU: No, Kode Program/Rekening, Uraian, Volume, Satuan, Harga Satuan, Jumlah, Bulan, Pengaju
$headers = ['No', 'Kode Program/Rekening', 'Uraian', 'Volume', 'Satuan', 'Harga Satuan', 'Jumlah', 'Bulan', 'Pengaju'];
$sheet->fromArray($headers, NULL, 'A3');
$sheet->getStyle('A3:I3')
      ->applyFromArray($headerStyle)
      ->applyFromArray($allBorders);

// --- TULIS DATA UTAMA ---
$rowNumber  = 4;
$itemNumber = 1;

foreach ($groupedData as $programKey => $program) {
    // Baris Program
    $sheet->setCellValue('B' . $rowNumber, $programKey);
    $sheet->setCellValue('C' . $rowNumber, $program['nama']);
    $sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray($programStyle);
    $rowNumber++;

    foreach ($program['sub_programs'] as $subProgramKey => $subProgram) {
        // Baris Sub Program
        $sheet->setCellValue('B' . $rowNumber, $subProgramKey);
        $sheet->setCellValue('C' . $rowNumber, $subProgram['nama']);
        $sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray($subProgramStyle);
        $rowNumber++;

        foreach ($subProgram['kegiatans'] as $kegiatanKey => $kegiatan) {
            // Baris Kegiatan
            $sheet->setCellValue('B' . $rowNumber, $kegiatanKey);
            $sheet->setCellValue('C' . $rowNumber, $kegiatan['nama']);
            $sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray($kegiatanStyle);
            $rowNumber++;

            foreach ($kegiatan['rekenings'] as $rekeningKey => $rekening) {
                // Baris Rekening: kode rekening juga di kolom B (bertumpuk di kolom yang sama)
                $sheet->setCellValue('B' . $rowNumber, $rekeningKey);
                $sheet->setCellValue('C' . $rowNumber, $rekening['nama']);
                $sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray($rekeningStyle);
                $rowNumber++;

                foreach ($rekening['items'] as $item) {
                    // Baris Rincian (Detail)
                    $uraian_lengkap = $item['nama_rencana'];
                    if (!empty($item['nama_rencana_kegiatan'])) {
                        $uraian_lengkap .= ' (' . $item['nama_rencana_kegiatan'] . ')';
                    }

                    $sheet->setCellValue('A' . $rowNumber, $itemNumber++);
                    // B dikosongkan pada baris detail (tetap diisi hanya di baris program/sub/kegiatan/rekening)
                    $sheet->setCellValue('C' . $rowNumber, $uraian_lengkap);
                    $sheet->setCellValue('D' . $rowNumber, $item['jumlah_rencana'] * $item['jumlah_kegiatan']);
                    $sheet->setCellValue('E' . $rowNumber, $item['satuan']);
                    $sheet->setCellValue('F' . $rowNumber, $item['harga_satuan']);
                    $sheet->setCellValue('G' . $rowNumber, $item['total_biaya']);
                    $sheet->setCellValue('H' . $rowNumber, $item['bulan']);
                    $sheet->setCellValue('I' . $rowNumber, $item['username']); // Pengaju
                    $rowNumber++;
                }
            }
        }
    }
}

// BARIS GRAND TOTAL
// Label di F (sebelum 'Jumlah' di G)
$sheet->setCellValue('F' . $rowNumber, 'Grand Total');
$sheet->setCellValue('G' . $rowNumber, $grandTotal);
$sheet->mergeCells('A' . $rowNumber . ':F' . $rowNumber);
$sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray($grandTotalStyle);
$rowNumber++;

// --- FINAL FORMATTING ---
$sheet->getStyle('A4:I' . ($rowNumber - 1))->applyFromArray($allBorders);
// Format angka: Volume (D), Harga, Jumlah (F,G)
$sheet->getStyle('D4:G' . $rowNumber)->applyFromArray($numberFormat);

// Auto width kolom A–I
foreach (range('A', 'I') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Uraian lebih lebar
$sheet->getColumnDimension('C')->setWidth(40);

// --- KIRIM FILE KE BROWSER ---
$filename = "Laporan_RKAS_Final_" . date('Y-m-d') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
