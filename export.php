<?php
// Menggunakan DOMPDF yang ada di folder lib
require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil parameter gudang, default 'botol'
$gudanga = $_GET['gudanga'] ?? 'botol';

// Validasi dan tentukan nama tabel berdasarkan parameter
$tabel = '';
if ($gudanga === 'botol') {
    $tabel = 'botol_a';
} elseif ($gudanga === 'komponen') {
    $tabel = 'komponen_a';
} elseif ($gudanga === 'box') {
    $tabel = 'box_a';
} else {
    die("Parameter gudang tidak valid.");
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "followme");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil data dari tabel sesuai gudang
$sql = "SELECT * FROM $tabel";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Mulai HTML untuk PDF
$html = '<html><body>';
$html .= '<h1>Data Stock Barang Gudang ' . strtoupper($gudanga) . '</h1>';
$html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
$html .= '<thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                <th>Penerima</th>
                <th>Botol</th>
                <th>Varian</th>
            </tr>
          </thead>';
$html .= '<tbody>';

// Loop data
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . $i++ . '</td>';
    $html .= '<td>' . htmlspecialchars($row['namabarang']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['penerima']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['botol'] ?? '') . '</td>'; // cek jika kolom ada
    $html .= '<td>' . htmlspecialchars($row['varian']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';
$html .= '</body></html>';

// Render PDF
$options = new Options();
$options->set("isHtml5ParserEnabled", true);
$options->set("isPhpEnabled", true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->render();

// Output ke browser
$dompdf->stream("stock_barang_gudang_$gudanga.pdf", array("Attachment" => 0));
