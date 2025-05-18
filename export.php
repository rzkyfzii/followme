<?php
// Menggunakan DOMPDF yang ada di folder lib
require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil parameter gudang
$gudang = $_GET['gudang'] ?? 'a'; // default ke 'a'

// Validasi nama tabel
$tabel = '';
if ($gudang === 'a') {
    $tabel = 'stock';
} elseif ($gudang === 'c') {
    $tabel = 'gudangc'; // pastikan ini nama tabel yang benar di database kamu
} else {
    die("Gudang tidak valid.");
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
$html .= '<h1>Data Stock Barang Gudang ' . strtoupper($gudang) . '</h1>';
$html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
$html .= '<thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                <th>Deskripsi</th>
                <th>Botol</th>
                <th>Varian</th>
                <th>Sprayer</th>
                <th>Ring</th>
                <th>Tutup</th>
                <th>InnerBox</th>
                <th>OuterBox</th>
                <th>Partisi</th>
            </tr>
          </thead>';
$html .= '<tbody>';

// Loop data
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . $i++ . '</td>';
    $html .= '<td>' . $row['namabarang'] . '</td>';
    $html .= '<td>' . $row['keterangan'] . '</td>';
    $html .= '<td>' . $row['deskripsi'] . '</td>';
    $html .= '<td>' . $row['botol'] . '</td>';
    $html .= '<td>' . $row['varian'] . '</td>';
    $html .= '<td>' . $row['sprayer'] . '</td>';
    $html .= '<td>' . $row['ring'] . '</td>';
    $html .= '<td>' . $row['tutup'] . '</td>';
    $html .= '<td>' . $row['innerBox'] . '</td>';
    $html .= '<td>' . $row['outerBox'] . '</td>';
    $html .= '<td>' . $row['partisi'] . '</td>';
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
$dompdf->stream("stock_barang_gudang_$gudang.pdf", array("Attachment" => 0));
?>
