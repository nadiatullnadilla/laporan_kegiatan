<?php

$width = 1700;
$height = 1560;
$img = imagecreatetruecolor($width, $height);

imageantialias($img, true);

$colors = [
    'bg' => imagecolorallocate($img, 248, 250, 252),
    'text' => imagecolorallocate($img, 15, 23, 42),
    'muted' => imagecolorallocate($img, 71, 85, 105),
    'line' => imagecolorallocate($img, 51, 65, 85),
    'white' => imagecolorallocate($img, 255, 255, 255),
    'blue_fill' => imagecolorallocate($img, 239, 246, 255),
    'blue' => imagecolorallocate($img, 37, 99, 235),
    'green_fill' => imagecolorallocate($img, 220, 252, 231),
    'green' => imagecolorallocate($img, 22, 163, 74),
    'yellow_fill' => imagecolorallocate($img, 254, 243, 199),
    'yellow' => imagecolorallocate($img, 217, 119, 6),
    'gray_fill' => imagecolorallocate($img, 241, 245, 249),
    'gray' => imagecolorallocate($img, 100, 116, 139),
];

imagefill($img, 0, 0, $colors['bg']);

$font = 'C:/Windows/Fonts/arial.ttf';
$fontBold = 'C:/Windows/Fonts/arialbd.ttf';

function textCenter($img, $text, $x, $y, $size, $color, $font)
{
    $box = imagettfbbox($size, 0, $font, $text);
    $tw = $box[2] - $box[0];
    imagettftext($img, $size, 0, (int) ($x - $tw / 2), $y, $color, $font, $text);
}

function wrapLines($text, $maxChars)
{
    $words = explode(' ', $text);
    $lines = [];
    $line = '';

    foreach ($words as $word) {
        $test = trim($line . ' ' . $word);
        if (strlen($test) > $maxChars && $line !== '') {
            $lines[] = $line;
            $line = $word;
        } else {
            $line = $test;
        }
    }

    if ($line !== '') {
        $lines[] = $line;
    }

    return $lines;
}

function boxNode($img, $x, $y, $w, $h, $title, $subtitle, $fill, $stroke, $text, $muted, $font, $fontBold)
{
    imagefilledrectangle($img, $x, $y, $x + $w, $y + $h, $fill);
    imagerectangle($img, $x, $y, $x + $w, $y + $h, $stroke);
    imagerectangle($img, $x + 1, $y + 1, $x + $w - 1, $y + $h - 1, $stroke);

    textCenter($img, $title, $x + $w / 2, $y + 33, 16, $text, $fontBold);
    if ($subtitle) {
        $lines = wrapLines($subtitle, 28);
        $lineY = $y + 60;
        foreach ($lines as $line) {
            textCenter($img, $line, $x + $w / 2, $lineY, 12, $muted, $font);
            $lineY += 19;
        }
    }
}

function ellipseNode($img, $cx, $cy, $w, $h, $title, $fill, $stroke, $text, $fontBold)
{
    imagefilledellipse($img, $cx, $cy, $w, $h, $fill);
    imageellipse($img, $cx, $cy, $w, $h, $stroke);
    imageellipse($img, $cx, $cy, $w - 2, $h - 2, $stroke);
    textCenter($img, $title, $cx, $cy + 8, 17, $text, $fontBold);
}

function diamondNode($img, $cx, $cy, $w, $h, $title, $subtitle, $fill, $stroke, $text, $muted, $font, $fontBold)
{
    $points = [$cx, $cy - $h / 2, $cx + $w / 2, $cy, $cx, $cy + $h / 2, $cx - $w / 2, $cy];
    imagefilledpolygon($img, $points, 4, $fill);
    imagepolygon($img, $points, 4, $stroke);
    imagepolygon($img, [$cx, $cy - $h / 2 + 2, $cx + $w / 2 - 2, $cy, $cx, $cy + $h / 2 - 2, $cx - $w / 2 + 2, $cy], 4, $stroke);
    textCenter($img, $title, $cx, $cy - 3, 15, $text, $fontBold);
    if ($subtitle) {
        textCenter($img, $subtitle, $cx, $cy + 23, 11, $muted, $font);
    }
}

function arrow($img, $x1, $y1, $x2, $y2, $color)
{
    imageline($img, $x1, $y1, $x2, $y2, $color);
    $angle = atan2($y2 - $y1, $x2 - $x1);
    $len = 13;
    $a1 = $angle + pi() * 0.82;
    $a2 = $angle - pi() * 0.82;
    imagefilledpolygon($img, [
        $x2, $y2,
        (int) ($x2 + $len * cos($a1)), (int) ($y2 + $len * sin($a1)),
        (int) ($x2 + $len * cos($a2)), (int) ($y2 + $len * sin($a2)),
    ], 3, $color);
}

function polyArrow($img, $points, $color)
{
    for ($i = 0; $i < count($points) - 1; $i++) {
        [$x1, $y1] = $points[$i];
        [$x2, $y2] = $points[$i + 1];
        if ($i === count($points) - 2) {
            arrow($img, $x1, $y1, $x2, $y2, $color);
        } else {
            imageline($img, $x1, $y1, $x2, $y2, $color);
        }
    }
}

textCenter($img, 'FLOWCHART SISTEM LAPORAN KEGIATAN', 850, 58, 25, $colors['text'], $fontBold);
textCenter($img, 'Alur login, hak akses admin/verifikator, pengelolaan laporan, verifikasi, rekap, file, dan riwayat aktivitas', 850, 92, 13, $colors['muted'], $font);

ellipseNode($img, 850, 155, 170, 62, 'Mulai', $colors['green_fill'], $colors['green'], $colors['text'], $fontBold);
boxNode($img, 700, 230, 300, 82, 'Buka Aplikasi', 'User mengakses halaman utama', $colors['white'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 700, 355, 300, 82, 'Halaman Login', 'Input username dan password', $colors['white'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
diamondNode($img, 850, 530, 330, 150, 'Login valid?', 'cek tabel user', $colors['yellow_fill'], $colors['yellow'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 275, 485, 300, 90, 'Login Gagal', 'Username tidak ditemukan atau password salah', $colors['white'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 700, 650, 300, 86, 'Simpan Session', 'username dan role disimpan', $colors['white'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 700, 780, 300, 86, 'Dashboard', 'Tampilkan total laporan, file, status, dan laporan terbaru', $colors['blue_fill'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
diamondNode($img, 850, 970, 330, 150, 'Role user?', 'admin atau verifikator', $colors['yellow_fill'], $colors['yellow'], $colors['text'], $colors['muted'], $font, $fontBold);

boxNode($img, 85, 1135, 290, 92, 'Admin: Input Laporan', 'Isi kegiatan, tanggal, tempat, jam, dan upload dokumen', $colors['blue_fill'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 405, 1135, 290, 92, 'Kelola Laporan', 'Cari, edit, hapus, preview, dan download file', $colors['blue_fill'], $colors['blue'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 725, 1135, 290, 92, 'Verifikator', 'Setujui laporan atau beri status revisi', $colors['green_fill'], $colors['green'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 1045, 1135, 290, 92, 'Rekap Laporan', 'Filter status, tahun, bulan, lalu export Word', $colors['gray_fill'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 1365, 1135, 250, 92, 'Riwayat & Logout', 'Lihat aktivitas dan keluar dari sistem', $colors['gray_fill'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);

boxNode($img, 85, 1310, 290, 82, 'Status: menunggu', 'Laporan baru masuk database', $colors['white'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 725, 1310, 290, 82, 'Status diperbarui', 'disetujui atau revisi', $colors['white'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);
boxNode($img, 1045, 1310, 290, 82, 'File Rekap', 'Download rekap_laporan.doc', $colors['white'], $colors['gray'], $colors['text'], $colors['muted'], $font, $fontBold);
ellipseNode($img, 850, 1480, 180, 62, 'Selesai', $colors['gray_fill'], $colors['gray'], $colors['text'], $fontBold);

arrow($img, 850, 186, 850, 230, $colors['line']);
arrow($img, 850, 312, 850, 355, $colors['line']);
arrow($img, 850, 437, 850, 455, $colors['line']);
arrow($img, 850, 605, 850, 650, $colors['line']);
arrow($img, 850, 736, 850, 780, $colors['line']);
arrow($img, 850, 866, 850, 895, $colors['line']);
polyArrow($img, [[685, 530], [575, 530]], $colors['line']);
polyArrow($img, [[425, 485], [425, 395], [700, 395]], $colors['line']);

polyArrow($img, [[685, 970], [230, 970], [230, 1135]], $colors['line']);
polyArrow($img, [[760, 1040], [550, 1040], [550, 1135]], $colors['line']);
polyArrow($img, [[900, 1040], [870, 1040], [870, 1135]], $colors['line']);
polyArrow($img, [[1015, 970], [1190, 970], [1190, 1135]], $colors['line']);
polyArrow($img, [[1015, 970], [1490, 970], [1490, 1135]], $colors['line']);

arrow($img, 230, 1227, 230, 1310, $colors['line']);
arrow($img, 870, 1227, 870, 1310, $colors['line']);
arrow($img, 1190, 1227, 1190, 1310, $colors['line']);
polyArrow($img, [[230, 1392], [230, 1480], [760, 1480]], $colors['line']);
arrow($img, 870, 1392, 870, 1449, $colors['line']);
polyArrow($img, [[1190, 1392], [1190, 1480], [940, 1480]], $colors['line']);
polyArrow($img, [[1490, 1227], [1490, 1480], [940, 1480]], $colors['line']);

imagettftext($img, 12, 0, 590, 515, $colors['muted'], $fontBold, 'Tidak');
imagettftext($img, 12, 0, 875, 633, $colors['muted'], $fontBold, 'Ya');
imagettftext($img, 12, 0, 360, 955, $colors['muted'], $fontBold, 'Admin');
imagettftext($img, 12, 0, 1015, 955, $colors['muted'], $fontBold, 'Menu umum');
imagettftext($img, 12, 0, 875, 1112, $colors['muted'], $fontBold, 'Verifikator');

imagepng($img, __DIR__ . '/../FLOWCHART.png', 9);
imagedestroy($img);

echo "FLOWCHART.png berhasil dibuat\n";
