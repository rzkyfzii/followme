<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Perbaiki nama database (hilangkan spasi)
$conn = mysqli_connect("localhost", "root", "", "followme");

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}


// tambah barang gudang a botol
if (isset($_POST['submitbotol'])) {
    $inputTanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d H:i:s', strtotime($inputTanggal));

    // Ambil data dari form
    $po = $_POST['po'] ?: '';
    $namabarang = $_POST['namabarang'] ?: '';
    $keterangan = $_POST['keterangan'] ?: '';
    $penerima = $_POST['penerima'] ?: '';
    $botol = $_POST['botol'] ?: 0;
    $varian = $_POST['varian'] ?: 0;

    // Pengecekan apakah barang dengan PO, Nama, dan Varian sudah ada
    $check = mysqli_query($conn, "SELECT * FROM botol_a 
        WHERE po = '$po' AND namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Jika sudah ada, update stok-nya
        $existing = mysqli_fetch_assoc($check);
        $idbarang = $existing['idbarang'];

        $update = mysqli_query($conn, "UPDATE botol_a SET 
            botol = botol + $botol,
            tanggal = '$tanggal'
            WHERE idbarang = '$idbarang'");

        if ($update) {
            header("Location: botol_a.php");
            exit();
        } else {
            echo "Gagal update barang: " . mysqli_error($conn);
        }
    } else {
        // Jika belum ada, insert baru
        $idbarang = uniqid("BRG-");

        $insert = mysqli_query($conn, "INSERT INTO botol_a
            (idbarang, po, namabarang, keterangan, penerima, botol, varian, tanggal) 
            VALUES 
            ('$idbarang', '$po', '$namabarang', '$keterangan', '$penerima', '$botol', '$varian', '$tanggal')");

        if ($insert) {
            header("Location: botol_a.php");
            exit();
        } else {
            echo "Gagal tambah barang: " . mysqli_error($conn);
        }
    }
}

//update barang botol gudang a
if (isset($_POST['updatebarangbotol'])) {
    // Ambil data dari form
    $idb = $_POST['idb'];
    $po = isset($_POST['po']) ? $_POST['po'] : '';
    $namabarang = isset($_POST['namabarang']) ? $_POST['namabarang'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $penerima= isset($_POST['penerima']) ? $_POST['penerima'] : '';
    $botol = isset($_POST['botol']) ? $_POST['botol'] : 0;
    $varian = isset($_POST['varian']) ? $_POST['varian'] : '';

    // Pastikan tanggal tidak berubah
    // Hanya memperbarui kolom lain selain tanggal
    $update = mysqli_query($conn, "UPDATE botol_a SET 
        po='$po',
        namabarang='$namabarang',
        keterangan='$keterangan',
        penerima='$penerima',
        botol='$botol',
        varian='$varian'
        WHERE idbarang='$idb'");

    if($update){
        header("Location: botol_a.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}

// Hapus barang dari botol_a (Gudang A)
if(isset($_POST['hapusbarangbotol'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from botol_a where idbarang='$idb'");
    if($hapus){
        header("Location: botol_a.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

// tambah barang komponen gudang a
if (isset($_POST['submitkomponen'])) {
    $inputTanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d H:i:s', strtotime($inputTanggal));

    // Ambil data dari form
    $po = $_POST['po'] ?: '';
    $namabarang = $_POST['namabarang'] ?: '';
    $keterangan = $_POST['keterangan'] ?: '';
    $deskripsi = $_POST['deskripsi'] ?: '';
    $varian = $_POST['varian'] ?: 0;
    $sprayer = $_POST['sprayer'] ?: 0;
    $ring = $_POST['ring'] ?: 0;
    $tutup = $_POST['tutup'] ?: 0;

    // Pengecekan apakah barang dengan PO, Nama, dan Varian sudah ada
    $check = mysqli_query($conn, "SELECT * FROM komponen_a 
        WHERE po = '$po' AND namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Jika sudah ada, update stok-nya
        $existing = mysqli_fetch_assoc($check);
        $idbarang = $existing['idbarang'];

        $update = mysqli_query($conn, "UPDATE komponen_a SET 
            sprayer = sprayer + $sprayer,
            ring = ring + $ring,
            tutup = tutup + $tutup,
            tanggal = '$tanggal'
            WHERE idbarang = '$idbarang'");

        if ($update) {
            header("Location: komponen_a.php");
            exit();
        } else {
            echo "Gagal update barang: " . mysqli_error($conn);
        }
    } else {
        // Jika belum ada, insert baru
        $idbarang = uniqid("BRG-");

        $insert = mysqli_query($conn, "INSERT INTO komponen_a
            (idbarang, po, namabarang, keterangan, deskripsi, varian, tanggal, sprayer, ring, tutup) 
            VALUES 
            ('$idbarang', '$po', '$namabarang', '$keterangan', '$deskripsi', '$varian', '$tanggal', '$sprayer', '$ring', '$tutup') ");

        if ($insert) {
            header("Location: komponen_a.php");
            exit();
        } else {
            echo "Gagal tambah barang: " . mysqli_error($conn);
        }
    }
}

//update barang komponen gudang a
if (isset($_POST['updatebarangkomponen'])) {
    // Ambil data dari form
    $idb = $_POST['idb'];
    $po = isset($_POST['po']) ? $_POST['po'] : '';
    $namabarang = isset($_POST['namabarang']) ? $_POST['namabarang'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $varian = isset($_POST['varian']) ? $_POST['varian'] : '';
    $sprayer = isset($_POST['sprayer']) ? $_POST['sprayer'] : 0;
    $ring = isset($_POST['ring']) ? $_POST['ring'] : 0;
    $tutup = isset($_POST['tutup']) ? $_POST['tutup'] : 0;

    // Pastikan tanggal tidak berubah
    // Hanya memperbarui kolom lain selain tanggal
    $update = mysqli_query($conn, "UPDATE komponen_a SET 
        po='$po',
        namabarang='$namabarang',
        keterangan='$keterangan',
        deskripsi='$deskripsi',
        varian='$varian',
        sprayer='$sprayer',
        ring='$ring',
        tutup='$tutup'
        WHERE idbarang='$idb'");

    if($update){
        header("Location: komponen_a.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
 
// delete barang komponen gudang a
if(isset($_POST['hapusbarangkomponen'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from komponen_a where idbarang='$idb'");
    if($hapus){
        header("Location: komponen_a.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

//submit box a
if (isset($_POST['submitbox'])) {
    $inputTanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d H:i:s', strtotime($inputTanggal));

    // Ambil data dari form
    $po = $_POST['po'] ?: '';
    $namabarang = $_POST['namabarang'] ?: '';
    $keterangan = $_POST['keterangan'] ?: '';
    $penerima = $_POST['penerima'] ?: '';
    $varian = $_POST['varian'] ?: 0;
    $innerBox = $_POST['innerBox'] ?: 0;
    $outerBox = $_POST['outerBox'] ?: 0;
    $partisi = $_POST['partisi'] ?: 0;

    // Pengecekan apakah barang dengan PO, Nama, dan Varian sudah ada
    $check = mysqli_query($conn, "SELECT * FROM box_a 
        WHERE po = '$po' AND namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Jika sudah ada, update stok-nya
        $existing = mysqli_fetch_assoc($check);
        $idbarang = $existing['idbarang'];

        $update = mysqli_query($conn, "UPDATE box_a SET 
            innerBox = innerBox + $inerBox,
            outerBox = outerBox + $outerBox,
            partisi = partisi + $partisi,
            tanggal = '$tanggal'
            WHERE idbarang = '$idbarang'");

        if ($update) {
            header("Location: box_a.php");
            exit();
        } else {
            echo "Gagal update barang: " . mysqli_error($conn);
        }
    } else {
        // Jika belum ada, insert baru
        $idbarang = uniqid("BRG-");

        $insert = mysqli_query($conn, "INSERT INTO box_a
            (idbarang, po, namabarang, keterangan, penerima, varian, tanggal, innerBox, outerBox, partisi) 
            VALUES 
            ('$idbarang', '$po', '$namabarang', '$keterangan', '$penerima', '$varian', '$tanggal', '$innerBox', '$outerBox', '$partisi')");

        if ($insert) {
            header("Location: box_a.php");
            exit();
        } else {
            echo "Gagal tambah barang: " . mysqli_error($conn);
        }
    }
}

//update box a
if (isset($_POST['updatebarangbox'])) {
    $idb = mysqli_real_escape_string($conn, $_POST['idb'] ?? '');
    if (!$idb) {
        die('ID barang tidak valid');
    }
    
    $varian = mysqli_real_escape_string($conn, $_POST['varian'] ?? '');
    $po = mysqli_real_escape_string($conn, $_POST['po'] ?? '');
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang'] ?? '');
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan'] ?? '');
    $penerima = mysqli_real_escape_string($conn, $_POST['penerima'] ?? '');
    $innerBox = (int)($_POST['innerBox'] ?? 0);
    $outerBox = (int)($_POST['outerBox'] ?? 0);
    $partisi = (int)($_POST['partisi'] ?? 0);

    $update = mysqli_query($conn, "UPDATE box_a SET 
        po='$po',
        namabarang='$namabarang',
        keterangan='$keterangan',
        penerima='$penerima',
        varian='$varian',
        innerBox=$innerBox,
        outerBox=$outerBox,
        partisi=$partisi
        WHERE idbarang='$idb'");

    if ($update) {
        header("Location: box_a.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}

//delete box a
if(isset($_POST['hapusbarangbox'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from box_a where idbarang='$idb'");
    if($hapus){
        header("Location: box_a.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

// tambah barang produksi a
if (isset($_POST['A'])) {
    // Ambil dan sanitasi input
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $varian = mysqli_real_escape_string($conn, $_POST['varian']);
    $po = mysqli_real_escape_string($conn, $_POST['po']);
    $botol = (int)$_POST['botol'];
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $tanggal = date("Y-m-d");

    // Ambil data stok dari ketiga tabel berdasarkan namabarang, varian, po
    $q_botol = mysqli_query($conn, "SELECT * FROM botol_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_komponen = mysqli_query($conn, "SELECT * FROM komponen_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_box = mysqli_query($conn, "SELECT * FROM box_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");

    if (mysqli_num_rows($q_botol) > 0 && mysqli_num_rows($q_komponen) > 0 && mysqli_num_rows($q_box) > 0) {
        $stok_botol = mysqli_fetch_assoc($q_botol);
        $stok_komponen = mysqli_fetch_assoc($q_komponen);
        $stok_box = mysqli_fetch_assoc($q_box);

        // Validasi stok cukup
        $kurang = [];
        if ($stok_botol['botol'] < $botol) $kurang[] = 'Botol';
        if ($stok_komponen['sprayer'] < $sprayer) $kurang[] = 'Sprayer';
        if ($stok_komponen['ring'] < $ring) $kurang[] = 'Ring';
        if ($stok_komponen['tutup'] < $tutup) $kurang[] = 'Tutup';
        if ($stok_box['innerBox'] < $innerBox) $kurang[] = 'Inner Box';
        if ($stok_box['outerBox'] < $outerBox) $kurang[] = 'Outer Box';
        if ($stok_box['partisi'] < $partisi) $kurang[] = 'Partisi';

        if (count($kurang) > 0) {
            echo "❌ Stok tidak mencukupi untuk: " . implode(', ', $kurang);
            exit;
        }

        // Kurangi stok di botol_a
        $update_botol = mysqli_query($conn, "UPDATE botol_a SET 
            botol = botol - $botol 
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di komponen_a
        $update_komponen = mysqli_query($conn, "UPDATE komponen_a SET 
            sprayer = sprayer - $sprayer,
            ring = ring - $ring,
            tutup = tutup - $tutup
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di box_a
        $update_box = mysqli_query($conn, "UPDATE box_a SET 
            innerBox = innerBox - $innerBox,
            outerBox = outerBox - $outerBox,
            partisi = partisi - $partisi
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        if ($update_botol && $update_komponen && $update_box) {
            // Masukkan ke produksi_a, cek dulu apakah sudah ada untuk tanggal dan varian yang sama
            $cekProd = mysqli_query($conn, "SELECT * FROM produksi_a WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal' LIMIT 1");

            if (mysqli_num_rows($cekProd) > 0) {
                // Update produksi
                $updateProd = mysqli_query($conn, "UPDATE produksi_a SET
                    botol = botol + $botol,
                    sprayer = sprayer + $sprayer,
                    ring = ring + $ring,
                    tutup = tutup + $tutup,
                    innerBox = innerBox + $innerBox,
                    outerBox = outerBox + $outerBox,
                    partisi = partisi + $partisi
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal'");
            } else {
                // Insert produksi baru
                $insertProd = mysqli_query($conn, "INSERT INTO produksi_a 
                    (namabarang, varian, po, botol, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) VALUES
                    ('$namabarang', '$varian', '$po', $botol, $sprayer, $ring, $tutup, $innerBox, $outerBox, $partisi, NOW())");
            }

           
        } else {
            echo "❌ Gagal update stok di salah satu tabel.";
        }
    } else {
        echo "❌ Data tidak lengkap. Barang harus ada di botol_a, komponen_a, dan box_a.";
    }
}

// delete produksi a
if (isset($_POST['hapusbarangproduksia'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_a
    $get = mysqli_query($conn, "SELECT * FROM produksi_a WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    if (!$data) {
        echo "Data produksi tidak ditemukan.";
        exit;
    }

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    $po = trim($data['po']); // pastikan ada kolom po di produksi_a

    // Update stok botol_a
    $updateBotol = mysqli_query($conn, "UPDATE botol_a SET 
        botol = botol + {$data['botol']} 
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok komponen_a
    $updateKomponen = mysqli_query($conn, "UPDATE komponen_a SET 
        sprayer = sprayer + {$data['sprayer']},
        ring = ring + {$data['ring']},
        tutup = tutup + {$data['tutup']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok box_a
    $updateBox = mysqli_query($conn, "UPDATE box_a SET 
        innerBox = innerBox + {$data['innerBox']},
        outerBox = outerBox + {$data['outerBox']},
        partisi = partisi + {$data['partisi']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    if ($updateBotol && $updateKomponen && $updateBox) {
        // Jika semua update berhasil, hapus produksi_a
        $hapus = mysqli_query($conn, "DELETE FROM produksi_a WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_a.php");
            exit();
        } else {
            echo "Gagal hapus data produksi: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stok komponen: " . mysqli_error($conn);
    }
}

//tambah barang guda b
if (isset($_POST['B'])) {
    // Ambil dan sanitasi input
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $varian = mysqli_real_escape_string($conn, $_POST['varian']);
    $po = mysqli_real_escape_string($conn, $_POST['po']);
    $botol = (int)$_POST['botol'];
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $tanggal = date("Y-m-d");

    // Ambil data stok dari ketiga tabel berdasarkan namabarang, varian, po
    $q_botol = mysqli_query($conn, "SELECT * FROM botol_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_komponen = mysqli_query($conn, "SELECT * FROM komponen_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_box = mysqli_query($conn, "SELECT * FROM box_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");

    if (mysqli_num_rows($q_botol) > 0 && mysqli_num_rows($q_komponen) > 0 && mysqli_num_rows($q_box) > 0) {
        $stok_botol = mysqli_fetch_assoc($q_botol);
        $stok_komponen = mysqli_fetch_assoc($q_komponen);
        $stok_box = mysqli_fetch_assoc($q_box);

        // Validasi stok cukup
        $kurang = [];
        if ($stok_botol['botol'] < $botol) $kurang[] = 'Botol';
        if ($stok_komponen['sprayer'] < $sprayer) $kurang[] = 'Sprayer';
        if ($stok_komponen['ring'] < $ring) $kurang[] = 'Ring';
        if ($stok_komponen['tutup'] < $tutup) $kurang[] = 'Tutup';
        if ($stok_box['innerBox'] < $innerBox) $kurang[] = 'Inner Box';
        if ($stok_box['outerBox'] < $outerBox) $kurang[] = 'Outer Box';
        if ($stok_box['partisi'] < $partisi) $kurang[] = 'Partisi';

        if (count($kurang) > 0) {
            echo "❌ Stok tidak mencukupi untuk: " . implode(', ', $kurang);
            exit;
        }

        // Kurangi stok di botol_a
        $update_botol = mysqli_query($conn, "UPDATE botol_a SET 
            botol = botol - $botol 
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di komponen_a
        $update_komponen = mysqli_query($conn, "UPDATE komponen_a SET 
            sprayer = sprayer - $sprayer,
            ring = ring - $ring,
            tutup = tutup - $tutup
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di box_a
        $update_box = mysqli_query($conn, "UPDATE box_a SET 
            innerBox = innerBox - $innerBox,
            outerBox = outerBox - $outerBox,
            partisi = partisi - $partisi
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        if ($update_botol && $update_komponen && $update_box) {
            // Masukkan ke produksi_a, cek dulu apakah sudah ada untuk tanggal dan varian yang sama
            $cekProd = mysqli_query($conn, "SELECT * FROM produksi_b WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal' LIMIT 1");

            if (mysqli_num_rows($cekProd) > 0) {
                // Update produksi
                $updateProd = mysqli_query($conn, "UPDATE produksi_b SET
                    botol = botol + $botol,
                    sprayer = sprayer + $sprayer,
                    ring = ring + $ring,
                    tutup = tutup + $tutup,
                    innerBox = innerBox + $innerBox,
                    outerBox = outerBox + $outerBox,
                    partisi = partisi + $partisi
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal'");
            } else {
                // Insert produksi baru
                $insertProd = mysqli_query($conn, "INSERT INTO produksi_b
                    (namabarang, varian, po, botol, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) VALUES
                    ('$namabarang', '$varian', '$po', $botol, $sprayer, $ring, $tutup, $innerBox, $outerBox, $partisi, NOW())");
            }

           
        } else {
            echo "❌ Gagal update stok di salah satu tabel.";
        }
    } else {
        echo "❌ Data tidak lengkap. Barang harus ada di botol_a, komponen_a, dan box_a.";
    }
}

// delete produksi b
if (isset($_POST['hapusbarangproduksib'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_a
    $get = mysqli_query($conn, "SELECT * FROM produksi_b WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    if (!$data) {
        echo "Data produksi tidak ditemukan.";
        exit;
    }

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    $po = trim($data['po']); // pastikan ada kolom po di produksi_a

    // Update stok botol_a
    $updateBotol = mysqli_query($conn, "UPDATE botol_a SET 
        botol = botol + {$data['botol']} 
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok komponen_a
    $updateKomponen = mysqli_query($conn, "UPDATE komponen_a SET 
        sprayer = sprayer + {$data['sprayer']},
        ring = ring + {$data['ring']},
        tutup = tutup + {$data['tutup']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok box_a
    $updateBox = mysqli_query($conn, "UPDATE box_a SET 
        innerBox = innerBox + {$data['innerBox']},
        outerBox = outerBox + {$data['outerBox']},
        partisi = partisi + {$data['partisi']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    if ($updateBotol && $updateKomponen && $updateBox) {
        // Jika semua update berhasil, hapus produksi_a
        $hapus = mysqli_query($conn, "DELETE FROM produksi_b WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_b.php");
            exit();
        } else {
            echo "Gagal hapus data produksi: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stok komponen: " . mysqli_error($conn);
    }
}

// tambah barang produksi C
if (isset($_POST['C'])) {
    // Ambil dan sanitasi input
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $varian = mysqli_real_escape_string($conn, $_POST['varian']);
    $po = mysqli_real_escape_string($conn, $_POST['po']);
    $botol = (int)$_POST['botol'];
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $tanggal = date("Y-m-d");

    // Ambil data stok dari ketiga tabel berdasarkan namabarang, varian, po
    $q_botol = mysqli_query($conn, "SELECT * FROM botol_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_komponen = mysqli_query($conn, "SELECT * FROM komponen_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_box = mysqli_query($conn, "SELECT * FROM box_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");

    if (mysqli_num_rows($q_botol) > 0 && mysqli_num_rows($q_komponen) > 0 && mysqli_num_rows($q_box) > 0) {
        $stok_botol = mysqli_fetch_assoc($q_botol);
        $stok_komponen = mysqli_fetch_assoc($q_komponen);
        $stok_box = mysqli_fetch_assoc($q_box);

        // Validasi stok cukup
        $kurang = [];
        if ($stok_botol['botol'] < $botol) $kurang[] = 'Botol';
        if ($stok_komponen['sprayer'] < $sprayer) $kurang[] = 'Sprayer';
        if ($stok_komponen['ring'] < $ring) $kurang[] = 'Ring';
        if ($stok_komponen['tutup'] < $tutup) $kurang[] = 'Tutup';
        if ($stok_box['innerBox'] < $innerBox) $kurang[] = 'Inner Box';
        if ($stok_box['outerBox'] < $outerBox) $kurang[] = 'Outer Box';
        if ($stok_box['partisi'] < $partisi) $kurang[] = 'Partisi';

        if (count($kurang) > 0) {
            echo "❌ Stok tidak mencukupi untuk: " . implode(', ', $kurang);
            exit;
        }

        // Kurangi stok di botol_a
        $update_botol = mysqli_query($conn, "UPDATE botol_a SET 
            botol = botol - $botol 
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di komponen_a
        $update_komponen = mysqli_query($conn, "UPDATE komponen_a SET 
            sprayer = sprayer - $sprayer,
            ring = ring - $ring,
            tutup = tutup - $tutup
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di box_a
        $update_box = mysqli_query($conn, "UPDATE box_a SET 
            innerBox = innerBox - $innerBox,
            outerBox = outerBox - $outerBox,
            partisi = partisi - $partisi
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        if ($update_botol && $update_komponen && $update_box) {
            // Masukkan ke produksi_a, cek dulu apakah sudah ada untuk tanggal dan varian yang sama
            $cekProd = mysqli_query($conn, "SELECT * FROM produksi_c WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal' LIMIT 1");

            if (mysqli_num_rows($cekProd) > 0) {
                // Update produksi
                $updateProd = mysqli_query($conn, "UPDATE produksi_c SET
                    botol = botol + $botol,
                    sprayer = sprayer + $sprayer,
                    ring = ring + $ring,
                    tutup = tutup + $tutup,
                    innerBox = innerBox + $innerBox,
                    outerBox = outerBox + $outerBox,
                    partisi = partisi + $partisi
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal'");
            } else {
                // Insert produksi baru
                $insertProd = mysqli_query($conn, "INSERT INTO produksi_c
                    (namabarang, varian, po, botol, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) VALUES
                    ('$namabarang', '$varian', '$po', $botol, $sprayer, $ring, $tutup, $innerBox, $outerBox, $partisi, NOW())");
            }

           
        } else {
            echo "❌ Gagal update stok di salah satu tabel.";
        }
    } else {
        echo "❌ Data tidak lengkap. Barang harus ada di botol_a, komponen_a, dan box_a.";
    }
}

// delete produksi c
if (isset($_POST['hapusbarangproduksic'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_c
    $get = mysqli_query($conn, "SELECT * FROM produksi_c WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    if (!$data) {
        echo "Data produksi tidak ditemukan.";
        exit;
    }

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    $po = trim($data['po']); // pastikan ada kolom po di produksi_c

    // Update stok botol_a
    $updateBotol = mysqli_query($conn, "UPDATE botol_a SET 
        botol = botol + {$data['botol']} 
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok komponen_a
    $updateKomponen = mysqli_query($conn, "UPDATE komponen_a SET 
        sprayer = sprayer + {$data['sprayer']},
        ring = ring + {$data['ring']},
        tutup = tutup + {$data['tutup']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok box_a
    $updateBox = mysqli_query($conn, "UPDATE box_a SET 
        innerBox = innerBox + {$data['innerBox']},
        outerBox = outerBox + {$data['outerBox']},
        partisi = partisi + {$data['partisi']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    if ($updateBotol && $updateKomponen && $updateBox) {
        // Jika semua update berhasil, hapus produksi_c
        $hapus = mysqli_query($conn, "DELETE FROM produksi_c WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_c.php");
            exit();
        } else {
            echo "Gagal hapus data produksi: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stok komponen: " . mysqli_error($conn);
    }
}

// tambah barang produksi d
if (isset($_POST['D'])) {
    // Ambil dan sanitasi input
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $varian = mysqli_real_escape_string($conn, $_POST['varian']);
    $po = mysqli_real_escape_string($conn, $_POST['po']);
    $botol = (int)$_POST['botol'];
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $tanggal = date("Y-m-d");

    // Ambil data stok dari ketiga tabel berdasarkan namabarang, varian, po
    $q_botol = mysqli_query($conn, "SELECT * FROM botol_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_komponen = mysqli_query($conn, "SELECT * FROM komponen_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");
    $q_box = mysqli_query($conn, "SELECT * FROM box_a WHERE namabarang='$namabarang' AND varian='$varian' AND po='$po' LIMIT 1");

    if (mysqli_num_rows($q_botol) > 0 && mysqli_num_rows($q_komponen) > 0 && mysqli_num_rows($q_box) > 0) {
        $stok_botol = mysqli_fetch_assoc($q_botol);
        $stok_komponen = mysqli_fetch_assoc($q_komponen);
        $stok_box = mysqli_fetch_assoc($q_box);

        // Validasi stok cukup
        $kurang = [];
        if ($stok_botol['botol'] < $botol) $kurang[] = 'Botol';
        if ($stok_komponen['sprayer'] < $sprayer) $kurang[] = 'Sprayer';
        if ($stok_komponen['ring'] < $ring) $kurang[] = 'Ring';
        if ($stok_komponen['tutup'] < $tutup) $kurang[] = 'Tutup';
        if ($stok_box['innerBox'] < $innerBox) $kurang[] = 'Inner Box';
        if ($stok_box['outerBox'] < $outerBox) $kurang[] = 'Outer Box';
        if ($stok_box['partisi'] < $partisi) $kurang[] = 'Partisi';

        if (count($kurang) > 0) {
            echo "❌ Stok tidak mencukupi untuk: " . implode(', ', $kurang);
            exit;
        }

        // Kurangi stok di botol_a
        $update_botol = mysqli_query($conn, "UPDATE botol_a SET 
            botol = botol - $botol 
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di komponen_a
        $update_komponen = mysqli_query($conn, "UPDATE komponen_a SET 
            sprayer = sprayer - $sprayer,
            ring = ring - $ring,
            tutup = tutup - $tutup
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        // Kurangi stok di box_a
        $update_box = mysqli_query($conn, "UPDATE box_a SET 
            innerBox = innerBox - $innerBox,
            outerBox = outerBox - $outerBox,
            partisi = partisi - $partisi
            WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

        if ($update_botol && $update_komponen && $update_box) {
            // Masukkan ke produksi_a, cek dulu apakah sudah ada untuk tanggal dan varian yang sama
            $cekProd = mysqli_query($conn, "SELECT * FROM produksi_d WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal' LIMIT 1");

            if (mysqli_num_rows($cekProd) > 0) {
                // Update produksi
                $updateProd = mysqli_query($conn, "UPDATE produksi_d SET
                    botol = botol + $botol,
                    sprayer = sprayer + $sprayer,
                    ring = ring + $ring,
                    tutup = tutup + $tutup,
                    innerBox = innerBox + $innerBox,
                    outerBox = outerBox + $outerBox,
                    partisi = partisi + $partisi
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po' AND DATE(tanggal) = '$tanggal'");
            } else {
                // Insert produksi baru
                $insertProd = mysqli_query($conn, "INSERT INTO produksi_d
                    (namabarang, varian, po, botol, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) VALUES
                    ('$namabarang', '$varian', '$po', $botol, $sprayer, $ring, $tutup, $innerBox, $outerBox, $partisi, NOW())");
            }

           
        } else {
            echo "❌ Gagal update stok di salah satu tabel.";
        }
    } else {
        echo "❌ Data tidak lengkap. Barang harus ada di botol_a, komponen_a, dan box_a.";
    }
}

// delete produksi d
if (isset($_POST['hapusbarangproduksid'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_c
    $get = mysqli_query($conn, "SELECT * FROM produksi_d WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    if (!$data) {
        echo "Data produksi tidak ditemukan.";
        exit;
    }

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    $po = trim($data['po']); // pastikan ada kolom po di produksi_c

    // Update stok botol_a
    $updateBotol = mysqli_query($conn, "UPDATE botol_a SET 
        botol = botol + {$data['botol']} 
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok komponen_a
    $updateKomponen = mysqli_query($conn, "UPDATE komponen_a SET 
        sprayer = sprayer + {$data['sprayer']},
        ring = ring + {$data['ring']},
        tutup = tutup + {$data['tutup']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    // Update stok box_a
    $updateBox = mysqli_query($conn, "UPDATE box_a SET 
        innerBox = innerBox + {$data['innerBox']},
        outerBox = outerBox + {$data['outerBox']},
        partisi = partisi + {$data['partisi']}
        WHERE namabarang = '$namabarang' AND varian = '$varian' AND po = '$po'");

    if ($updateBotol && $updateKomponen && $updateBox) {
        // Jika semua update berhasil, hapus produksi_c
        $hapus = mysqli_query($conn, "DELETE FROM produksi_d WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_d.php");
            exit();
        } else {
            echo "Gagal hapus data produksi: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stok komponen: " . mysqli_error($conn);
    }
}

//tambah barang shrink
if (isset($_POST['shrink'])) {
    $po = $_POST['po'];
    $namabarang = $_POST['namabarang'];
    $jumlahPcs = (int)$_POST['jumlahpcs'];
    $asalProduksi = $_POST['asalproduksi'];
    $varian = $_POST['varian'];
    $keterangan = $_POST['keterangan'];

    if (empty($namabarang)) {
        echo "<script>alert('Nama Barang tidak boleh kosong!'); window.location.href='barja.php';</script>";
        exit();
    }

    if (empty($asalProduksi)) {
        echo "<script>alert('Asal Produksi tidak dipilih!'); window.location.href='barja.php';</script>";
        exit();
    }

    $tabelProduksi = $asalProduksi;

    // Cek apakah barang dan varian sudah ada di tabel barja
    $checkBarja = mysqli_query($conn, "SELECT * FROM barja WHERE namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if (mysqli_num_rows($checkBarja) > 0) {
        // Jika ada, update jumlahpcs-nya
        $updateBarja = mysqli_query($conn, "UPDATE barja SET jumlahpcs = jumlahpcs + $jumlahPcs, tanggal = NOW() WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika belum ada, buat baris baru
        $insertBarja = mysqli_query($conn, "INSERT INTO barja (namabarang, po, produksi, varian, keterangan, jumlahpcs, tanggal) 
            VALUES ('$namabarang', '$po', '$asalProduksi', '$varian', '$keterangan', '$jumlahPcs', NOW())");
    }

    // Cek dan kurangi stok produksi
    $checkStock = mysqli_query($conn, "SELECT * FROM $tabelProduksi WHERE namabarang = '$namabarang' LIMIT 1");

    if ($checkStock && mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        $updateFields = [];

        if ($barang['botol'] >= $jumlahPcs) {
            $updateFields[] = "botol = botol - $jumlahPcs";
        }
        if ($barang['sprayer'] >= $jumlahPcs) {
            $updateFields[] = "sprayer = sprayer - $jumlahPcs";
        }
        if ($barang['ring'] >= $jumlahPcs) {
            $updateFields[] = "ring = ring - $jumlahPcs";
        }
        if ($barang['tutup'] >= $jumlahPcs) {
            $updateFields[] = "tutup = tutup - $jumlahPcs";
        }
        if ($barang['innerBox'] >= $jumlahPcs) {
            $updateFields[] = "innerBox = innerBox - $jumlahPcs";
        }
        if ($barang['outerBox'] >= $jumlahPcs) {
            $updateFields[] = "outerBox = outerBox - $jumlahPcs";
        }
        if ($barang['partisi'] >= $jumlahPcs) {
            $updateFields[] = "partisi = partisi - $jumlahPcs";
        }

        if (!empty($updateFields)) {
            $setClause = implode(", ", $updateFields);
            $updateStok = mysqli_query($conn, "UPDATE $tabelProduksi SET $setClause WHERE idbarang = '$idbarang'");

            if ($updateStok) {
                echo "<script>alert('Stok berhasil dikurangi dan data barja diperbarui.'); window.location.href='barja.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui stok produksi.'); window.location.href='barja.php';</script>";
            }
        } else {
            echo "<script>alert('Tidak ada komponen yang memiliki stok cukup. Tidak ada perubahan stok.'); window.location.href='barja.php';</script>";
        }
    } else {
        echo "<script>alert('Barang tidak ditemukan di produksi.'); window.location.href='barja.php';</script>";
    }
}

//delete barang shrink
if(isset($_POST['hapusbarangshrink'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from barja where idbarang='$idb'");
    if($hapus){
        header("Location: barja.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

if (isset($_POST['kirim'])) {
    $tanggal        = $_POST['tanggal'];
    $po             = $_POST['po'];
    $namapenerima   = $_POST['namapenerima'];
    $namabarang     = $_POST['namabarang'];
    $varian         = $_POST['varian'];
    $alamat         = $_POST['alamat'];
    $jumlahkoli     = (int)$_POST['jumlahkoli'];
    $jumlahpcs      = (int)$_POST['jumlahpcs'];
    $keterangan     = $_POST['keterangan'];

    // Validasi
    if (empty($namabarang) || empty($jumlahpcs) || empty($po)) {
        echo "<script>alert('PO, Namabarang dan Jumlah PCS wajib diisi!'); window.location.href='pengiriman.php';</script>";
        exit();
    }

    // Cek stok dari barja
    $cekStok = mysqli_query($conn, "SELECT * FROM barja WHERE namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if ($cekStok && mysqli_num_rows($cekStok) > 0) {
        $dataBarja = mysqli_fetch_assoc($cekStok);
        $stokSaatIni = (int)$dataBarja['jumlahpcs'];

        if ($stokSaatIni >= $jumlahpcs) {
            // Kurangi stok barja
            $updateStok = mysqli_query($conn, "UPDATE barja SET jumlahpcs = jumlahpcs - $jumlahpcs WHERE namabarang = '$namabarang' AND varian = '$varian'");

            if ($updateStok) {
                // Simpan ke tabel pengiriman
                $simpan = mysqli_query($conn, "INSERT INTO pengiriman (tanggal, po, namapenerima, namabarang, varian, alamat, jumlahkoli, jumlahpcs, keterangan)
                    VALUES ('$tanggal', '$po', '$namapenerima', '$namabarang', '$varian', '$alamat', $jumlahkoli, $jumlahpcs, '$keterangan')");

                if ($simpan) {
                    echo "<script>alert('Data pengiriman berhasil disimpan dan stok dikurangi.'); window.location.href='pengiriman.php';</script>";
                } else {
                    $error = mysqli_error($conn);
                    echo "<script>alert('Gagal menyimpan data pengiriman: $error'); window.location.href='pengiriman.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengurangi stok dari barja.'); window.location.href='pengiriman.php';</script>";
            }
        } else {
            echo "<script>alert('Stok tidak mencukupi. Stok saat ini: $stokSaatIni PCS'); window.location.href='pengiriman.php';</script>";
        }
    } else {
        echo "<script>alert('Data barang tidak ditemukan di barja.'); window.location.href='pengiriman.php';</script>";
    }
}





if (isset($_POST['reject'])) {
    $namabarang = $_POST['namabarang'];
    $jumlahPcs = (int)$_POST['jumlahpcs'];
    $asalProduksi = $_POST['asalproduksi'];
    $varian = $_POST['varian'];
    $keterangan = $_POST['keterangan'];

    // Validasi input
    if (empty($namabarang)) {
        echo "<script>alert('Nama Barang tidak boleh kosong!'); window.location.href='reject.php';</script>";
        exit();
    }

    if (empty($asalProduksi)) {
        echo "<script>alert('Asal Produksi tidak dipilih!'); window.location.href='reject.php';</script>";
        exit();
    }

    $tabelProduksi = $asalProduksi;

    // Cek apakah barang dan varian sudah ada di tabel reject
    $checkReject = mysqli_query($conn, "SELECT * FROM reject WHERE namabarang = '$namabarang' AND varian = '$varian' LIMIT 1");

    if (mysqli_num_rows($checkReject) > 0) {
        // Jika ada, update jumlahpcs-nya
        $updateReject = mysqli_query($conn, "UPDATE reject SET jumlahpcs = jumlahpcs + $jumlahPcs, tanggal = NOW() WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika belum ada, buat baris baru
        $insertReject = mysqli_query($conn, "INSERT INTO reject (namabarang, produksi, varian, keterangan, jumlahpcs, tanggal) 
            VALUES ('$namabarang', '$asalProduksi', '$varian', '$keterangan', '$jumlahPcs', NOW())");
    }

    // Kurangi stok dari tabel produksi
    $checkStock = mysqli_query($conn, "SELECT * FROM $tabelProduksi WHERE namabarang = '$namabarang' LIMIT 1");

    if ($checkStock && mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        $updateFields = [];

        if ($barang['botol'] >= $jumlahPcs) {
            $updateFields[] = "botol = botol - $jumlahPcs";
        }
        if ($barang['sprayer'] >= $jumlahPcs) {
            $updateFields[] = "sprayer = sprayer - $jumlahPcs";
        }
        if ($barang['ring'] >= $jumlahPcs) {
            $updateFields[] = "ring = ring - $jumlahPcs";
        }
        if ($barang['tutup'] >= $jumlahPcs) {
            $updateFields[] = "tutup = tutup - $jumlahPcs";
        }
        if ($barang['innerBox'] >= $jumlahPcs) {
            $updateFields[] = "innerBox = innerBox - $jumlahPcs";
        }
        if ($barang['outerBox'] >= $jumlahPcs) {
            $updateFields[] = "outerBox = outerBox - $jumlahPcs";
        }
        if ($barang['partisi'] >= $jumlahPcs) {
            $updateFields[] = "partisi = partisi - $jumlahPcs";
        }

        if (!empty($updateFields)) {
            $setClause = implode(", ", $updateFields);
            $updateStok = mysqli_query($conn, "UPDATE $tabelProduksi SET $setClause WHERE idbarang = '$idbarang'");

            if ($updateStok) {
                echo "<script>alert('Data reject berhasil ditambahkan dan stok dikurangi.'); window.location.href='reject.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui stok produksi.'); window.location.href='reject.php';</script>";
            }
        } else {
            echo "<script>alert('Tidak ada komponen yang memiliki stok cukup. Tidak ada perubahan stok.'); window.location.href='reject.php';</script>";
        }
    } else {
        echo "<script>alert('Barang tidak ditemukan di produksi.'); window.location.href='reject.php';</script>";
    }
}


// Pastikan tombol submit sudah ditekan
if (isset($_POST['pindahbarang'])) {

    // Ambil data dari form
    $namabarang = $_POST['namabarang'];
    $varian = $_POST['varian'];
    $gudang_asal = $_POST['gudang_asal'];
    $gudang_tujuan = $_POST['gudang_tujuan'];
    $fields = ['botol', 'sprayer', 'ring', 'tutup', 'innerBox', 'outerBox', 'partisi'];

    // Ambil jumlah dari form
    $data = [];
    foreach ($fields as $f) {
        $data[$f] = $_POST[$f];
    }

    // Tentukan nama tabel asal dan tujuan
    $tabel_asal = ($gudang_asal == 'gudang_a') ? 'stok' : 'gudangc';
    $tabel_tujuan = ($gudang_tujuan == 'gudang_a') ? 'stok' : 'gudangc';

    // Cek apakah barang ada di gudang asal
    $cek = $db->query("SELECT * FROM $tabel_asal WHERE namabarang = '$namabarang' AND varian = '$varian'");

    if ($cek->num_rows > 0) {
        $row = $cek->fetch_assoc();

        // Proses pemindahan barang berdasarkan field yang diisi
        foreach ($fields as $f) {
            $jumlah = intval($data[$f]);
            if ($jumlah > 0) {
                // Update stok di gudang asal
                $new_qty = $row[$f] - $jumlah;
                $db->query("UPDATE $tabel_asal SET $f = $new_qty WHERE namabarang = '$namabarang' AND varian = '$varian'");

                // Cek jika data sudah ada di gudang tujuan
                $cekTujuan = $db->query("SELECT * FROM $tabel_tujuan WHERE namabarang = '$namabarang' AND varian = '$varian'");
                if ($cekTujuan->num_rows > 0) {
                    // Update stok di gudang tujuan
                    $rowTujuan = $cekTujuan->fetch_assoc();
                    $new_qty_tujuan = $rowTujuan[$f] + $jumlah;
                    $db->query("UPDATE $tabel_tujuan SET $f = $new_qty_tujuan WHERE namabarang = '$namabarang' AND varian = '$varian'");
                } else {
                    // Jika tidak ada, insert data baru di gudang tujuan
                    $db->query("INSERT INTO $tabel_tujuan (namabarang, varian, $f) VALUES ('$namabarang', '$varian', $jumlah)");
                }
            }
        }

        echo "Stok barang berhasil dipindahkan!";
    } else {
        echo "Data tidak ditemukan di gudang asal!";
    }
}



?>

