<?php require('function.php'); ?>
<?php require ('cek.php');?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h2>Stok Barang - Gudang A</h2>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Barang
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search Bar -->
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="search" placeholder="Cari Barang" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="export.php?gudang=a" class="btn btn-danger" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                  </a>
                  </div>
                      <table id="datatablesSimple" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th>Penerima</th>
                                <th>Botol</th>
                                <th>Varian</th>
                                <th>Sprayer</th>
                                <th>Ring</th>
                                <th>Tutup</th>
                                <th>InnerBox</th>
                                <th>OuterBox</th>
                                <th>Partisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Search query
                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $searchQuery = $search ? "WHERE namabarang LIKE '%$search%'" : "";

                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock $searchQuery");
                            $i = 1;
                            while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                $tanggal = $data['tanggal'];
                                $namabarang = $data['namabarang'];
                                $keterangan = $data['keterangan'];
                                $deskripsi = $data['deskripsi'];
                                $botol = $data['botol'];
                                $varian = $data['varian'];
                                $sprayer = $data['sprayer'];
                                $ring = $data['ring'];
                                $tutup = $data['tutup'];
                                $innerBox = $data['innerBox'];
                                $outerBox = $data['outerBox'];
                                $partisi = $data['partisi'];
                                $idb = $data['idbarang'];
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $namabarang; ?></td>
                                    <td><?= $keterangan; ?></td>
                                    <td><?= $deskripsi; ?></td>
                                    <td><?= $botol; ?></td>
                                    <td><?= $varian; ?></td>
                                    <td><?= $sprayer; ?></td>
                                    <td><?= $ring; ?></td>
                                    <td><?= $tutup; ?></td>
                                    <td><?= $innerBox; ?></td>
                                    <td><?= $outerBox; ?></td>
                                    <td><?= $partisi; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idb; ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                            Delete
                                        </button>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#pindah<?= $idb; ?>">
                                            Pindah
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit<?= $idb; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Barang</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="post">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="namabarang">Nama Barang</label>
                                                            <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="deskripsi">Penerima</label>
                                                            <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="botol">Botol</label>
                                                            <input type="number" name="botol" value="<?= $botol; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="varian">Varian</label>
                                                            <input type="text" name="varian" value="<?= $varian; ?>" class="form-control" required>
                                                            <br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="sprayer">Sprayer</label>
                                                            <input type="number" name="sprayer" value="<?= $sprayer; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="ring">Ring</label>
                                                            <input type="number" name="ring" value="<?= $ring; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="tutup">Tutup</label>
                                                            <input type="number" name="tutup" value="<?= $tutup; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="innerBox">InnerBox</label>
                                                            <input type="number" name="innerBox" value="<?= $innerBox; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="outerBox">OuterBox</label>
                                                            <input type="number" name="outerBox" value="<?= $outerBox; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="partisi">Partisi</label>
                                                            <input type="number" name="partisi" value="<?= $partisi; ?>" class="form-control" required>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                    <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete<?= $idb; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Barang</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="post">
                                                <div class="modal-body">
                                                    Yakin Ingin Hapus <?= $namabarang; ?>?
                                                    <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pindah Modal -->
<div class="modal fade" id="pindah<?= $idb; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pindahkan Stok Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong><?= $namabarang; ?> (<?= $varian; ?>)</strong></p>
                            <label for="gudang_tujuan">Pindahkan ke:</label>
                            <select name="gudang_tujuan" class="form-control" required>
                                <option value="">-- Pilih Gudang --</option>
                                <?php if ($lokasi == 'gudang_a'): ?>
                                    <option value="gudang_a">Gudang <A></A></option>
                                <?php else: ?>
                                    <option value="gudang_c">Gudang C</option>
                                <?php endif; ?>
                            </select>
                            <br>
                            <label for="botol">Jumlah Botol</label>
                            <input type="number" name="botol" class="form-control" min="0" max="<?= $botol; ?>" value="0">
                            <br>
                            <label for="sprayer">Jumlah Sprayer</label>
                            <input type="number" name="sprayer" class="form-control" min="0" max="<?= $sprayer; ?>" value="0">
                            <br>
                            <label for="ring">Jumlah Ring</label>
                            <input type="number" name="ring" class="form-control" min="0" max="<?= $ring; ?>" value="0">
                            <br>
                            <label for="tutup">Jumlah Tutup</label>
                            <input type="number" name="tutup" class="form-control" min="0" max="<?= $tutup; ?>" value="0">
                            <br>
                            <label for="innerBox">Jumlah InnerBox</label>
                            <input type="number" name="innerBox" class="form-control" min="0" max="<?= $innerBox; ?>" value="0">
                            <br>
                            <label for="outerBox">Jumlah OuterBox</label>
                            <input type="number" name="outerBox" class="form-control" min="0" max="<?= $outerBox; ?>" value="0">
                            <br>
                            <label for="partisi">Jumlah Partisi</label>
                            <input type="number" name="partisi" class="form-control" min="0" max="<?= $partisi; ?>" value="0">
                            <br>
                            <input type="hidden" name="namabarang" value="<?= $namabarang; ?>">
                            <input type="hidden" name="varian" value="<?= $varian; ?>">
                            <input type="hidden" name="gudang_asal" value="<?= $lokasi; ?>">
                            <button type="submit" class="btn btn-warning" name="pindahbarang">Pindahkan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("sidebarToggle");
    const body = document.body;
    const sidebar = document.querySelector(".sidebar");

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener("click", function () {
        body.classList.toggle("sidebar-toggled");
        sidebar.classList.toggle("toggled");
      });
    }
  });
</script>


</body>

   <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form method="POST" class="custom-form">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="namabarang">Nama Barang</label>
              <input type="text" class="form-control" name="namabarang" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" name="keterangan" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="deskripsi">Penerima</label>
              <input type="text" class="form-control" name="deskripsi"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="botol">Botol</label>
              <input type="number" class="form-control" name="botol" value="0"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="varian">Varian</label>
              <input type="text" class="form-control" name="varian" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="sprayer">Sprayer</label>
              <input type="number" class="form-control" name="sprayer" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="ring">Ring</label>
              <input type="number" class="form-control" name="ring" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="tutup">Tutup</label>
              <input type="number" class="form-control" name="tutup" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="innerBox">InnerBox</label>
              <input type="number" class="form-control" name="innerBox" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="outerBox">OuterBox</label>
              <input type="number" class="form-control" name="outerBox" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="partisi">Partisi</label>
              <input type="number" class="form-control" name="partisi" value="0" required>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
