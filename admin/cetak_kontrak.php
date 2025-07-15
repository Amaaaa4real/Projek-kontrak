<?php
require '../dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

require '../config/koneksi.php';

if (!isset($_GET['id'])) {
    die('ID tidak ditemukan');
}

$id = intval($_GET['id']);
$data = $conn->query("SELECT k.*, 
    p1.nama AS pihak1_nama, p1.jabatan AS jabatan1, p1.perusahaan AS perusahaan1,
    p2.nama AS pihak2_nama, p2.jabatan AS jabatan2, p2.perusahaan AS perusahaan2
    FROM kontrak k
    LEFT JOIN pihak p1 ON k.pihak1_id = p1.id
    LEFT JOIN pihak p2 ON k.pihak2_id = p2.id
    WHERE k.id = $id")->fetch_assoc();

if (!$data) {
    die('Data kontrak tidak ditemukan.');
}

// Fungsi terbilang sampai triliun
function terbilang($number)
{
    $number = abs($number);
    $angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    $result = "";

    if ($number < 12) {
        $result = $angka[$number];
    } elseif ($number < 20) {
        $result = terbilang($number - 10) . " Belas";
    } elseif ($number < 100) {
        $result = terbilang($number / 10) . " Puluh " . terbilang($number % 10);
    } elseif ($number < 200) {
        $result = "Seratus " . terbilang($number - 100);
    } elseif ($number < 1000) {
        $result = terbilang($number / 100) . " Ratus " . terbilang($number % 100);
    } elseif ($number < 2000) {
        $result = "Seribu " . terbilang($number - 1000);
    } elseif ($number < 1000000) {
        $result = terbilang($number / 1000) . " Ribu " . terbilang($number % 1000);
    } elseif ($number < 1000000000) {
        $result = terbilang($number / 1000000) . " Juta " . terbilang($number % 1000000);
    } elseif ($number < 1000000000000) {
        $result = terbilang($number / 1000000000) . " Milyar " . terbilang($number % 1000000000);
    } elseif ($number < 1000000000000000) {
        $result = terbilang($number / 1000000000000) . " Triliun " . terbilang($number % 1000000000000);
    } else {
        $result = "Nominal terlalu besar";
    }

    return trim(preg_replace('/\s+/', ' ', $result));
}

// Optional logo
$logoPath = '../assets/images/logo.jpg';
if (file_exists($logoPath)) {
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoMime = mime_content_type($logoPath);
} else {
    $logoBase64 = '';
    $logoMime = 'image/png';
}

// HTML DOMPDF
ob_start();
?>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #000;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        width: 255px;
        height: auto;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
    }

    .subtitle {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    .nomor {
        text-align: center;
        font-size: 12px;
        margin-bottom: 15px;
    }

    hr {
        border: 0;
        height: 1px;
        background: #000;
        margin: 10px 0 20px 0;
    }

    .section {
        margin-bottom: 12px;
    }

    .label {
        display: inline-block;
        width: 120px;
        font-weight: bold;
        vertical-align: top;
    }

    .value {
        display: inline-block;
        width: calc(100% - 130px);
    }

    .signature {
        margin-top: 350px;
        text-align: right;
    }

    .signature .line {
        margin-top: 40px;
        border-top: 1px solid #000;
        width: 200px;
        margin-left: auto;
        text-align: center;
    }

    .footer {
        margin-top: 30px;
        font-size: 10px;
        text-align: center;
        color: #666;
    }
</style>

<div class="header">
    <div></div>
    <?php if ($logoBase64): ?>
        <img src="data:<?= $logoMime ?>;base64,<?= $logoBase64 ?>" class="logo" alt="Logo">
    <?php endif; ?>
</div>

<hr>

<div class="title">SURAT KONTRAK</div>
<div class="subtitle">"<?= htmlspecialchars($data['judul']) ?>"</div>
<div class="nomor">Nomor: <?= htmlspecialchars($data['nomor_surat']) ?></div>

<hr>

<div class="section">
    <span class="label">Dari</span>: <span class="value"><?= $data['pihak1_nama'] ?> (<?= $data['jabatan1'] ?>), <?= $data['perusahaan1'] ?></span>
</div>
<div class="section">
    <span class="label">Kepada Yth.</span>: <span class="value"><?= $data['pihak2_nama'] ?> (<?= $data['jabatan2'] ?>), <?= $data['perusahaan2'] ?></span>
</div>
<div class="section">
    <span class="label">Deskripsi</span>: <span class="value"><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></span>
</div>
<div class="section">
    <span class="label">Tanggal</span>: <span class="value"><?= date('d F Y', strtotime($data['tanggal'])) ?></span>
</div>
<div class="section">
    <span class="label">Waktu Kontrak</span>: <span class="value"><?= $data['waktu_kontrak'] ?></span>
</div>
<div class="section">
    <span class="label">Dana</span>:
    <span class="value">
        Rp <?= number_format($data['dana'], 0, ',', '.') ?>
        (<?= ucwords(terbilang((int)$data['dana'])) ?> Rupiah)
    </span>
</div>
<div class="section">
    <span class="label">Status</span>: <span class="value"><?= ucfirst($data['status']) ?></span>
</div>
<div class="signature">
    <p>Hormat Kami,</p><br><br><br>
    <div class="line"><?= $data['pihak1_nama'] ?>, <?= date('F Y') ?></div>
</div>

<hr style="border-top: 1px solid #ccc; margin-top: 40px;">
<div class="footer">
    Dicetak otomatis pada <?= date('d F Y') ?> | Sistem Kontrak Digital
</div>

<?php
$html = ob_get_clean();

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("kontrak_{$data['id']}.pdf", ["Attachment" => false]);
exit;
