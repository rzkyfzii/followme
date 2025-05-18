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



// tambah barang gudang a
if (isset($_POST['submit'])) {
    $inputTanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d H:i:s', strtotime($inputTanggal));

    $namabarang = $_POST['namabarang'] ?: 0;
    $keterangan = $_POST['keterangan'] ?: 0;
    $deskripsi = $_POST['deskripsi'] ?: 0;
    $botol = $_POST['botol'] ?: 0;
    $varian = $_POST['varian'] ?: 0;
    $sprayer = $_POST['sprayer'] ?: 0;
    $ring = $_POST['ring'] ?: 0;
    $tutup = $_POST['tutup'] ?: 0;
    $innerBox = $_POST['innerBox'] ?: 0;
    $outerBox = $_POST['outerBox'] ?: 0;
    $partisi = $_POST['partisi'] ?: 0;

    $check = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND keterangan = '$keterangan' AND deskripsi = '$deskripsi' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Jika sudah ada, update
        $existing = mysqli_fetch_assoc($check);
        $idbarang = $existing['idbarang']; // Simpan untuk mutasi nanti

        $update = mysqli_query($conn, "UPDATE stock SET 
            botol = botol + $botol,
            varian = varian + $varian,
            sprayer = sprayer + $sprayer,
            ring = ring + $ring,
            tutup = tutup + $tutup,
            innerBox = innerBox + $innerBox,
            outerBox = outerBox + $outerBox,
            partisi = partisi + $partisi,
            tanggal = '$tanggal'
            WHERE idbarang = '$idbarang'");

        if ($update) {
            header("Location: gudang_a.php");
            exit();
        } else {
            echo "Gagal update barang: " . mysqli_error($conn);
        }
    } else {
        // Generate ID baru
        $idbarang = uniqid("BRG-");

        $insert = mysqli_query($conn, "INSERT INTO stock 
            (idbarang, namabarang, keterangan, deskripsi, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) 
            VALUES 
            ('$idb', '$namabarang', '$keterangan', '$deskripsi', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', '$tanggal')");

        if ($insert) {
            header("Location: gudang_a.php");
            exit();
        } else {
            echo "Gagal tambah barang: " . mysqli_error($conn);
        }
    }
}


// tambah barang gudang c
if (isset($_POST['submitC'])) {
    // Ambil tanggal, jika kosong gunakan tanggal saat ini
    $inputTanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d H:i:s', strtotime($inputTanggal));

    // Ambil input lainnya dan pastikan nilainya
    $namabarang = $_POST['namabarang'] ?: 0;
    $keterangan = $_POST['keterangan'] ?: 0;
    $deskripsi = $_POST['deskripsi'] ?: 0;
    $botol = $_POST['botol'] ?: 0;
    $varian = $_POST['varian'] ?: 0;
    $sprayer = $_POST['sprayer'] ?: 0;
    $ring = $_POST['ring'] ?: 0;
    $tutup = $_POST['tutup'] ?: 0;
    $innerBox = $_POST['innerBox'] ?: 0;
    $outerBox = $_POST['outerBox'] ?: 0;
    $partisi = $_POST['partisi'] ?: 0;

    // Cek apakah ada barang dengan kombinasi nama, keterangan, dan deskripsi yang sama
    $check = mysqli_query($conn, "SELECT * FROM gudangc WHERE namabarang = '$namabarang' AND keterangan = '$keterangan' AND deskripsi = '$deskripsi' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Jika sudah ada, update stok (ditambah)
        $existing = mysqli_fetch_assoc($check);

        // Update stok dengan menambahkan nilai yang baru
        $update = mysqli_query($conn, "UPDATE gudangc SET 
            botol = botol + $botol,
            varian = varian + $varian,
            sprayer = sprayer + $sprayer,
            ring = ring + $ring,
            tutup = tutup + $tutup,
            innerBox = innerBox + $innerBox,
            outerBox = outerBox + $outerBox,
            partisi = partisi + $partisi,
            tanggal = '$tanggal'
            WHERE namabarang = '$namabarang' AND keterangan = '$keterangan' AND deskripsi = '$deskripsi'
        ");

        // Mengecek apakah update berhasil
        if ($update) {
            header("Location: gudang_c.php");
            exit();
        } else {
            echo "Gagal update barang: " . mysqli_error($conn);
        }
    } else {
        // Jika belum ada, insert data baru
        $insert = mysqli_query($conn, "INSERT INTO gudangc 
            (namabarang, keterangan, deskripsi, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal) 
            VALUES 
            ('$namabarang', '$keterangan', '$deskripsi', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', '$tanggal')");

        // Mengecek apakah insert berhasil
        if ($insert) {
            header("Location: gudang_c.php");
            exit();
        } else {
            echo "Gagal tambah barang: " . mysqli_error($conn);
        }
    }
}


//update barang gudang a
if (isset($_POST['updatebarang'])) {
    // Ambil data dari form
    $idb = $_POST['idb'];
    $namabarang = isset($_POST['namabarang']) ? $_POST['namabarang'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $botol = isset($_POST['botol']) ? $_POST['botol'] : 0;
    $varian = isset($_POST['varian']) ? $_POST['varian'] : '';
    $sprayer = isset($_POST['sprayer']) ? $_POST['sprayer'] : '';
    $ring = isset($_POST['ring']) ? $_POST['ring'] : '';
    $tutup = isset($_POST['tutup']) ? $_POST['tutup'] : '';
    $innerBox = isset($_POST['innerBox']) ? $_POST['innerBox'] : 0;
    $outerBox = isset($_POST['outerBox']) ? $_POST['outerBox'] : 0;
    $partisi = isset($_POST['partisi']) ? $_POST['partisi'] : 0;

    // Pastikan tanggal tidak berubah
    // Hanya memperbarui kolom lain selain tanggal
    $update = mysqli_query($conn, "UPDATE stock SET 
        namabarang='$namabarang',
        keterangan='$keterangan',
        deskripsi='$deskripsi',
        botol='$botol',
        varian='$varian',
        sprayer='$sprayer',
        ring='$ring',
        tutup='$tutup',
        innerBox='$innerBox',
        outerBox='$outerBox',
        partisi='$partisi'
        WHERE idbarang='$idb'");

    if($update){
        header("Location: gudang_a.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}

//delete barang gudang a
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header("Location: gudang_a.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

//edit barang gudang c
if (isset($_POST['updatebarangc'])) {
    // Ambil data dari form
    $idb = $_POST['idb'];
    $namabarang = isset($_POST['namabarang']) ? $_POST['namabarang'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $botol = isset($_POST['botol']) ? $_POST['botol'] : 0;
    $varian = isset($_POST['varian']) ? $_POST['varian'] : '';
    $sprayer = isset($_POST['sprayer']) ? $_POST['sprayer'] : '';
    $ring = isset($_POST['ring']) ? $_POST['ring'] : '';
    $tutup = isset($_POST['tutup']) ? $_POST['tutup'] : '';
    $innerBox = isset($_POST['innerBox']) ? $_POST['innerBox'] : 0;
    $outerBox = isset($_POST['outerBox']) ? $_POST['outerBox'] : 0;
    $partisi = isset($_POST['partisi']) ? $_POST['partisi'] : 0;

    // Pastikan tanggal tidak berubah
    // Hanya memperbarui kolom lain selain tanggal
    $update = mysqli_query($conn, "UPDATE gudangc SET 
        namabarang='$namabarang',
        keterangan='$keterangan',
        deskripsi='$deskripsi',
        botol='$botol',
        varian='$varian',
        sprayer='$sprayer',
        ring='$ring',
        tutup='$tutup',
        innerBox='$innerBox',
        outerBox='$outerBox',
        partisi='$partisi'
        WHERE idbarang='$idb'");

    if($update){
        header("Location: gudang_c.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}

   
// delete barang masuk gudang c
if(isset($_POST['hapusbarangc'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from gudangc where idbarang='$idb'");
    if($hapus){
        header("Location: gudang_c.php");
        exit(); // Tambahkan exit setelah header
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
};

// tambah barang produksi a
if (isset($_POST['A'])) {
    $namabarang = $_POST['namabarang'];
    $botol = (int)$_POST['botol'];
    $varian = mysqli_real_escape_string($conn, $_POST['varian']); // pastikan varian disanitasi
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $gudang = $_POST['gudang'];

    // Tentukan nama tabel gudang
    $gudangTable = ($gudang == 'A') ? 'stock' : 'gudangc';

    // Ambil stok barang dari tabel gudang
    $checkStock = mysqli_query($conn, "SELECT * FROM $gudangTable WHERE namabarang = '$namabarang' LIMIT 1");

    if (mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        // Cek ketersediaan masing-masing komponen
        $cukup = true;
        $pesanKurang = "";

        if ($barang['botol'] < $botol) {
            $cukup = false;
            $pesanKurang .= "Botol kurang. ";
        }
        if ($barang['varian'] < $varian) {
            $cukup = false;
            $pesanKurang .= "varian kurang. ";
        }
        if ($barang['sprayer'] < $sprayer) {
            $cukup = false;
            $pesanKurang .= "Sprayer kurang. ";
        }
        if ($barang['ring'] < $ring) {
            $cukup = false;
            $pesanKurang .= "Ring kurang. ";
        }
        if ($barang['tutup'] < $tutup) {
            $cukup = false;
            $pesanKurang .= "Tutup kurang. ";
        }
        if ($barang['innerBox'] < $innerBox) {
            $cukup = false;
            $pesanKurang .= "InnerBox kurang. ";
        }
        if ($barang['outerBox'] < $outerBox) {
            $cukup = false;
            $pesanKurang .= "OuterBox kurang. ";
        }
        if ($barang['partisi'] < $partisi) {
            $cukup = false;
            $pesanKurang .= "Partisi kurang. ";
        }

        if ($cukup) {
            // Lanjut update stok
            $update = mysqli_query($conn, "UPDATE $gudangTable SET 
                botol = botol - $botol,
                sprayer = sprayer - $sprayer,
                ring = ring - $ring,
                tutup = tutup - $tutup,
                innerBox = innerBox - $innerBox,
                outerBox = outerBox - $outerBox,
                partisi = partisi - $partisi
                WHERE idbarang = '$idbarang'
            ");

            if ($update) {
                // Masukkan ke produksi_a
                // Cek apakah barang dengan varian sama sudah ada di produksi_a hari ini
                $tanggalHariIni = date("Y-m-d");
                $cekProduksi = mysqli_query($conn, "SELECT * FROM produksi_a 
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni' LIMIT 1");

                if (mysqli_num_rows($cekProduksi) > 0) {
                    // Jika sudah ada, update jumlah komponen
                    $row = mysqli_fetch_assoc($cekProduksi);
                    $updateProduksi = mysqli_query($conn, "UPDATE produksi_a SET 
                        botol = botol + $botol,
                        sprayer = sprayer + $sprayer,
                        ring = ring + $ring,
                        tutup = tutup + $tutup,
                        innerBox = innerBox + $innerBox,
                        outerBox = outerBox + $outerBox,
                        partisi = partisi + $partisi
                        WHERE idbarang = '$idbarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni'
                    ");
                } else {
                    // Jika belum ada, insert baru
                    $insert = mysqli_query($conn, "INSERT INTO produksi_a 
                        (idbarang, namabarang, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal)
                        VALUES ('$idbarang', '$namabarang', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', NOW())
                    ");
                }

            } else {
                
            }
        } else {
           
        }
    } else {
        
    }
}

// delete produksi a
if (isset($_POST['hapusbarangproduksia'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_a
    $get = mysqli_query($conn, "SELECT * FROM produksi_a WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    
    // Ambil keterangan dan deskripsi asli dari stock (gudang_a)
    $getGudang = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");
    $gudangData = mysqli_fetch_assoc($getGudang);


    // Ambil keterangan dan deskripsi yang asli dari gudang
    $keterangan = $gudangData['keterangan'];
    $deskripsi = $gudangData['deskripsi'];

    // Cek apakah barang sudah ada di stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");

    if (mysqli_num_rows($cek) > 0) {
        // Update data stock yang sudah ada
        $update = mysqli_query($conn, "UPDATE stock SET 
            botol = botol + {$data['botol']},
            sprayer = sprayer + {$data['sprayer']},
            ring = ring + {$data['ring']},
            tutup = tutup + {$data['tutup']},
            innerBox = innerBox + {$data['innerBox']},
            outerBox = outerBox + {$data['outerBox']},
            partisi = partisi + {$data['partisi']},
            keterangan = '$keterangan',
            deskripsi = '$deskripsi'
            WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika barang belum ada, insert data baru ke stock
        $update = mysqli_query($conn, "INSERT INTO stock 
            (namabarang, varian, keterangan, deskripsi, botol, sprayer, ring, tutup, innerBox, outerBox, partisi) 
            VALUES 
            ('$namabarang', '$varian', '$keterangan', '$deskripsi', {$data['botol']}, {$data['sprayer']}, {$data['ring']}, {$data['tutup']}, {$data['innerBox']}, {$data['outerBox']}, {$data['partisi']})");
    }

    // Proses hapus data dari produksi_a jika update berhasil
    if ($update) {
        $hapus = mysqli_query($conn, "DELETE FROM produksi_a WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_a.php");
            exit();
        } else {
            echo "Gagal hapus data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stock: " . mysqli_error($conn);
    }
}


// tambah barang produksi b
if (isset($_POST['B'])) {
    $namabarang = $_POST['namabarang'];
    $botol = (int)$_POST['botol'];
    $varian = mysqli_real_escape_string($conn, $_POST['varian']); // pastikan varian disanitasi
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $gudang = $_POST['gudang'];

    // Tentukan nama tabel gudang
    $gudangTable = ($gudang == 'A') ? 'stock' : 'gudangc';

    // Ambil stok barang dari tabel gudang
    $checkStock = mysqli_query($conn, "SELECT * FROM $gudangTable WHERE namabarang = '$namabarang' LIMIT 1");

    if (mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        // Cek ketersediaan masing-masing komponen
        $cukup = true;
        $pesanKurang = "";

        if ($barang['botol'] < $botol) {
            $cukup = false;
            $pesanKurang .= "Botol kurang. ";
        }
        if ($barang['varian'] < $varian) {
            $cukup = false;
            $pesanKurang .= "varian kurang. ";
        }
        if ($barang['sprayer'] < $sprayer) {
            $cukup = false;
            $pesanKurang .= "Sprayer kurang. ";
        }
        if ($barang['ring'] < $ring) {
            $cukup = false;
            $pesanKurang .= "Ring kurang. ";
        }
        if ($barang['tutup'] < $tutup) {
            $cukup = false;
            $pesanKurang .= "Tutup kurang. ";
        }
        if ($barang['innerBox'] < $innerBox) {
            $cukup = false;
            $pesanKurang .= "InnerBox kurang. ";
        }
        if ($barang['outerBox'] < $outerBox) {
            $cukup = false;
            $pesanKurang .= "OuterBox kurang. ";
        }
        if ($barang['partisi'] < $partisi) {
            $cukup = false;
            $pesanKurang .= "Partisi kurang. ";
        }

        if ($cukup) {
            // Lanjut update stok
            $update = mysqli_query($conn, "UPDATE $gudangTable SET 
                botol = botol - $botol,
                sprayer = sprayer - $sprayer,
                ring = ring - $ring,
                tutup = tutup - $tutup,
                innerBox = innerBox - $innerBox,
                outerBox = outerBox - $outerBox,
                partisi = partisi - $partisi
                WHERE idbarang = '$idbarang'
            ");

            if ($update) {
                // Masukkan ke produksi_b
                // Cek apakah barang dengan varian sama sudah ada di produksi_a hari ini
                $tanggalHariIni = date("Y-m-d");
                $cekProduksi = mysqli_query($conn, "SELECT * FROM produksi_b 
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni' LIMIT 1");

                if (mysqli_num_rows($cekProduksi) > 0) {
                    // Jika sudah ada, update jumlah komponen
                    $row = mysqli_fetch_assoc($cekProduksi);
                    $updateProduksi = mysqli_query($conn, "UPDATE produksi_b SET 
                        botol = botol + $botol,
                        sprayer = sprayer + $sprayer,
                        ring = ring + $ring,
                        tutup = tutup + $tutup,
                        innerBox = innerBox + $innerBox,
                        outerBox = outerBox + $outerBox,
                        partisi = partisi + $partisi
                        WHERE idbarang = '$idbarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni'
                    ");
                } else {
                    // Jika belum ada, insert baru
                    $insert = mysqli_query($conn, "INSERT INTO produksi_b 
                        (idbarang, namabarang, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal)
                        VALUES ('$idbarang', '$namabarang', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', NOW())
                    ");
                }

            } else {
                
            }
        } else {
           
        }
    } else {
        
    }
}

// delete produksi b
if (isset($_POST['hapusbarangproduksib'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_b
    $get = mysqli_query($conn, "SELECT * FROM produksi_b WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    
    // Ambil keterangan dan deskripsi asli dari stock (gudang_b)
    $getGudang = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");
    $gudangData = mysqli_fetch_assoc($getGudang);

    // Ambil keterangan dan deskripsi yang asli dari gudang
    $keterangan = $gudangData['keterangan'];
    $deskripsi = $gudangData['deskripsi'];

    // Cek apakah barang sudah ada di stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");

    if (mysqli_num_rows($cek) > 0) {
        // Update data stock yang sudah ada
        $update = mysqli_query($conn, "UPDATE stock SET 
            botol = botol + {$data['botol']},
            sprayer = sprayer + {$data['sprayer']},
            ring = ring + {$data['ring']},
            tutup = tutup + {$data['tutup']},
            innerBox = innerBox + {$data['innerBox']},
            outerBox = outerBox + {$data['outerBox']},
            partisi = partisi + {$data['partisi']},
            keterangan = '$keterangan',
            deskripsi = '$deskripsi'
            WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika barang belum ada, insert data baru ke stock
        $update = mysqli_query($conn, "INSERT INTO stock 
            (namabarang, varian, keterangan, deskripsi, botol, sprayer, ring, tutup, innerBox, outerBox, partisi) 
            VALUES 
            ('$namabarang', '$varian', '$keterangan', '$deskripsi', {$data['botol']}, {$data['sprayer']}, {$data['ring']}, {$data['tutup']}, {$data['innerBox']}, {$data['outerBox']}, {$data['partisi']})");
    }

    // Proses hapus data dari produksi_a jika update berhasil
    if ($update) {
        $hapus = mysqli_query($conn, "DELETE FROM produksi_b WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_b.php");
            exit();
        } else {
            echo "Gagal hapus data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stock: " . mysqli_error($conn);
    }
}

// tambah barang produksi C
if (isset($_POST['C'])) {
    $namabarang = $_POST['namabarang'];
    $botol = (int)$_POST['botol'];
    $varian = mysqli_real_escape_string($conn, $_POST['varian']); // pastikan varian disanitasi
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $gudang = $_POST['gudang'];

    // Tentukan nama tabel gudang
    $gudangTable = ($gudang == 'A') ? 'stock' : 'gudangc';

    // Ambil stok barang dari tabel gudang
    $checkStock = mysqli_query($conn, "SELECT * FROM $gudangTable WHERE namabarang = '$namabarang' LIMIT 1");

    if (mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        // Cek ketersediaan masing-masing komponen
        $cukup = true;
        $pesanKurang = "";

        if ($barang['botol'] < $botol) {
            $cukup = false;
            $pesanKurang .= "Botol kurang. ";
        }
        if ($barang['varian'] < $varian) {
            $cukup = false;
            $pesanKurang .= "varian kurang. ";
        }
        if ($barang['sprayer'] < $sprayer) {
            $cukup = false;
            $pesanKurang .= "Sprayer kurang. ";
        }
        if ($barang['ring'] < $ring) {
            $cukup = false;
            $pesanKurang .= "Ring kurang. ";
        }
        if ($barang['tutup'] < $tutup) {
            $cukup = false;
            $pesanKurang .= "Tutup kurang. ";
        }
        if ($barang['innerBox'] < $innerBox) {
            $cukup = false;
            $pesanKurang .= "InnerBox kurang. ";
        }
        if ($barang['outerBox'] < $outerBox) {
            $cukup = false;
            $pesanKurang .= "OuterBox kurang. ";
        }
        if ($barang['partisi'] < $partisi) {
            $cukup = false;
            $pesanKurang .= "Partisi kurang. ";
        }

        if ($cukup) {
            // Lanjut update stok
            $update = mysqli_query($conn, "UPDATE $gudangTable SET 
                botol = botol - $botol,
                sprayer = sprayer - $sprayer,
                ring = ring - $ring,
                tutup = tutup - $tutup,
                innerBox = innerBox - $innerBox,
                outerBox = outerBox - $outerBox,
                partisi = partisi - $partisi
                WHERE idbarang = '$idbarang'
            ");

            if ($update) {
                // Masukkan ke produksi_b
                // Cek apakah barang dengan varian sama sudah ada di produksi_a hari ini
                $tanggalHariIni = date("Y-m-d");
                $cekProduksi = mysqli_query($conn, "SELECT * FROM produksi_c 
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni' LIMIT 1");

                if (mysqli_num_rows($cekProduksi) > 0) {
                    // Jika sudah ada, update jumlah komponen
                    $row = mysqli_fetch_assoc($cekProduksi);
                    $updateProduksi = mysqli_query($conn, "UPDATE produksi_c SET 
                        botol = botol + $botol,
                        sprayer = sprayer + $sprayer,
                        ring = ring + $ring,
                        tutup = tutup + $tutup,
                        innerBox = innerBox + $innerBox,
                        outerBox = outerBox + $outerBox,
                        partisi = partisi + $partisi
                        WHERE idbarang = '$idbarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni'
                    ");
                } else {
                    // Jika belum ada, insert baru
                    $insert = mysqli_query($conn, "INSERT INTO produksi_c 
                        (idbarang, namabarang, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal)
                        VALUES ('$idbarang', '$namabarang', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', NOW())
                    ");
                }

            } else {
                
            }
        } else {
           
        }
    } else {
        
    }
}

// delete produksi c
if (isset($_POST['hapusbarangproduksic'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_c
    $get = mysqli_query($conn, "SELECT * FROM produksi_c WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    
    // Ambil keterangan dan deskripsi asli dari stock (gudang_b)
    $getGudang = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");
    $gudangData = mysqli_fetch_assoc($getGudang);

    // Ambil keterangan dan deskripsi yang asli dari gudang
    $keterangan = $gudangData['keterangan'];
    $deskripsi = $gudangData['deskripsi'];

    // Cek apakah barang sudah ada di stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");

    if (mysqli_num_rows($cek) > 0) {
        // Update data stock yang sudah ada
        $update = mysqli_query($conn, "UPDATE stock SET 
            botol = botol + {$data['botol']},
            sprayer = sprayer + {$data['sprayer']},
            ring = ring + {$data['ring']},
            tutup = tutup + {$data['tutup']},
            innerBox = innerBox + {$data['innerBox']},
            outerBox = outerBox + {$data['outerBox']},
            partisi = partisi + {$data['partisi']},
            keterangan = '$keterangan',
            deskripsi = '$deskripsi'
            WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika barang belum ada, insert data baru ke stock
        $update = mysqli_query($conn, "INSERT INTO stock 
            (namabarang, varian, keterangan, deskripsi, botol, sprayer, ring, tutup, innerBox, outerBox, partisi) 
            VALUES 
            ('$namabarang', '$varian', '$keterangan', '$deskripsi', {$data['botol']}, {$data['sprayer']}, {$data['ring']}, {$data['tutup']}, {$data['innerBox']}, {$data['outerBox']}, {$data['partisi']})");
    }

    // Proses hapus data dari produksi_a jika update berhasil
    if ($update) {
        $hapus = mysqli_query($conn, "DELETE FROM produksi_c WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_c.php");
            exit();
        } else {
            echo "Gagal hapus data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stock: " . mysqli_error($conn);
    }
}

// tambah barang produksi d
if (isset($_POST['D'])) {
    $namabarang = $_POST['namabarang'];
    $botol = (int)$_POST['botol'];
    $varian = mysqli_real_escape_string($conn, $_POST['varian']); // pastikan varian disanitasi
    $sprayer = (int)$_POST['sprayer'];
    $ring = (int)$_POST['ring'];
    $tutup = (int)$_POST['tutup'];
    $innerBox = (int)$_POST['innerBox'];
    $outerBox = (int)$_POST['outerBox'];
    $partisi = (int)$_POST['partisi'];
    $gudang = $_POST['gudang'];

    // Tentukan nama tabel gudang
    $gudangTable = ($gudang == 'A') ? 'stock' : 'gudangc';

    // Ambil stok barang dari tabel gudang
    $checkStock = mysqli_query($conn, "SELECT * FROM $gudangTable WHERE namabarang = '$namabarang' LIMIT 1");

    if (mysqli_num_rows($checkStock) > 0) {
        $barang = mysqli_fetch_assoc($checkStock);
        $idbarang = $barang['idbarang'];

        // Cek ketersediaan masing-masing komponen
        $cukup = true;
        $pesanKurang = "";

        if ($barang['botol'] < $botol) {
            $cukup = false;
            $pesanKurang .= "Botol kurang. ";
        }
        if ($barang['varian'] < $varian) {
            $cukup = false;
            $pesanKurang .= "varian kurang. ";
        }
        if ($barang['sprayer'] < $sprayer) {
            $cukup = false;
            $pesanKurang .= "Sprayer kurang. ";
        }
        if ($barang['ring'] < $ring) {
            $cukup = false;
            $pesanKurang .= "Ring kurang. ";
        }
        if ($barang['tutup'] < $tutup) {
            $cukup = false;
            $pesanKurang .= "Tutup kurang. ";
        }
        if ($barang['innerBox'] < $innerBox) {
            $cukup = false;
            $pesanKurang .= "InnerBox kurang. ";
        }
        if ($barang['outerBox'] < $outerBox) {
            $cukup = false;
            $pesanKurang .= "OuterBox kurang. ";
        }
        if ($barang['partisi'] < $partisi) {
            $cukup = false;
            $pesanKurang .= "Partisi kurang. ";
        }

        if ($cukup) {
            // Lanjut update stok
            $update = mysqli_query($conn, "UPDATE $gudangTable SET 
                botol = botol - $botol,
                sprayer = sprayer - $sprayer,
                ring = ring - $ring,
                tutup = tutup - $tutup,
                innerBox = innerBox - $innerBox,
                outerBox = outerBox - $outerBox,
                partisi = partisi - $partisi
                WHERE idbarang = '$idbarang'
            ");

            if ($update) {
                // Masukkan ke produksi_b
                // Cek apakah barang dengan varian sama sudah ada di produksi_a hari ini
                $tanggalHariIni = date("Y-m-d");
                $cekProduksi = mysqli_query($conn, "SELECT * FROM produksi_d 
                    WHERE namabarang = '$namabarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni' LIMIT 1");

                if (mysqli_num_rows($cekProduksi) > 0) {
                    // Jika sudah ada, update jumlah komponen
                    $row = mysqli_fetch_assoc($cekProduksi);
                    $updateProduksi = mysqli_query($conn, "UPDATE produksi_d SET 
                        botol = botol + $botol,
                        sprayer = sprayer + $sprayer,
                        ring = ring + $ring,
                        tutup = tutup + $tutup,
                        innerBox = innerBox + $innerBox,
                        outerBox = outerBox + $outerBox,
                        partisi = partisi + $partisi
                        WHERE idbarang = '$idbarang' AND varian = '$varian' AND DATE(tanggal) = '$tanggalHariIni'
                    ");
                } else {
                    // Jika belum ada, insert baru
                    $insert = mysqli_query($conn, "INSERT INTO produksi_d 
                        (idbarang, namabarang, botol, varian, sprayer, ring, tutup, innerBox, outerBox, partisi, tanggal)
                        VALUES ('$idbarang', '$namabarang', '$botol', '$varian', '$sprayer', '$ring', '$tutup', '$innerBox', '$outerBox', '$partisi', NOW())
                    ");
                }

            } else {
                
            }
        } else {
           
        }
    } else {
        
    }
}

// delete produksi d
if (isset($_POST['hapusbarangproduksid'])) {
    $idb = $_POST['idb'];

    // Ambil data berdasarkan ID dari produksi_c
    $get = mysqli_query($conn, "SELECT * FROM produksi_d WHERE idbarang='$idb'");
    $data = mysqli_fetch_assoc($get);

    $namabarang = trim($data['namabarang']);
    $varian = trim($data['varian']);
    
    // Ambil keterangan dan deskripsi asli dari stock (gudang_d)
    $getGudang = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");
    $gudangData = mysqli_fetch_assoc($getGudang);

    // Ambil keterangan dan deskripsi yang asli dari gudang
    $keterangan = $gudangData['keterangan'];
    $deskripsi = $gudangData['deskripsi'];

    // Cek apakah barang sudah ada di stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang = '$namabarang' AND varian = '$varian'");

    if (mysqli_num_rows($cek) > 0) {
        // Update data stock yang sudah ada
        $update = mysqli_query($conn, "UPDATE stock SET 
            botol = botol + {$data['botol']},
            sprayer = sprayer + {$data['sprayer']},
            ring = ring + {$data['ring']},
            tutup = tutup + {$data['tutup']},
            innerBox = innerBox + {$data['innerBox']},
            outerBox = outerBox + {$data['outerBox']},
            partisi = partisi + {$data['partisi']},
            keterangan = '$keterangan',
            deskripsi = '$deskripsi'
            WHERE namabarang = '$namabarang' AND varian = '$varian'");
    } else {
        // Jika barang belum ada, insert data baru ke stock
        $update = mysqli_query($conn, "INSERT INTO stock 
            (namabarang, varian, keterangan, deskripsi, botol, sprayer, ring, tutup, innerBox, outerBox, partisi) 
            VALUES 
            ('$namabarang', '$varian', '$keterangan', '$deskripsi', {$data['botol']}, {$data['sprayer']}, {$data['ring']}, {$data['tutup']}, {$data['innerBox']}, {$data['outerBox']}, {$data['partisi']})");
    }

    // Proses hapus data dari produksi_a jika update berhasil
    if ($update) {
        $hapus = mysqli_query($conn, "DELETE FROM produksi_d WHERE idbarang='$idb'");
        if ($hapus) {
            header("Location: produksi_d.php");
            exit();
        } else {
            echo "Gagal hapus data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update stock: " . mysqli_error($conn);
    }
}


if (isset($_POST['shrink'])) {
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
        $insertBarja = mysqli_query($conn, "INSERT INTO barja (namabarang, produksi, varian, keterangan, jumlahpcs, tanggal) 
            VALUES ('$namabarang', '$asalProduksi', '$varian', '$keterangan', '$jumlahPcs', NOW())");
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

