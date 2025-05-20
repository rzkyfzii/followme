<?php require('function.php'); ?>
<?php require ('cek.php');?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h2>Stok Barang Box - Gudang A</h2>

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
                    <a href="export.php?gudang=c" class="btn btn-danger" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                  </a>
                    </a>
                  </div>
                      <table id="datatablesSimple" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>PO</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th>Penerima</th>
                                <th>Varian</th>
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

                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM box_a $searchQuery");
                            $i = 1;
                            while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                $tanggal = $data['tanggal'];
                                $po = $data['po'];
                                $namabarang = $data['namabarang'];
                                $keterangan = $data['keterangan'];
                                $penerima = $data['penerima'];
                                $varian = $data['varian'];
                                $innerBox = $data['innerBox'];
                                $outerBox = $data['outerBox'];
                                $partisi = $data['partisi'];
                                $idb = $data['idbarang'];
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $po; ?></td>
                                    <td><?= $namabarang; ?></td>
                                    <td><?= $keterangan; ?></td>
                                    <td><?= $penerima; ?></td>
                                    <td><?= $varian; ?></td>
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
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#move<?= $data['idbarang']; ?>">
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
                                                            <label for="po">PO</label>
                                                            <input type="number" name="po" value="<?= $po; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="namabarang">Nama Barang</label>
                                                            <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" required>
                                                            <br>
                                                            <label for="penerima">Penerima</label>
                                                            <input type="text" name="penerima" value="<?= $penerima; ?>" class="form-control" required>
                                                            <br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="varian">Varian</label>
                                                            <input type="text" name="varian" value="<?= $varian; ?>" class="form-control" required>
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
                                                    <button type="submitC" class="btn btn-primary" name="updatebarangbox">Submit</button>
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
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangbox">Hapus</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
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
              <label for="po">PO</label>
              <input type="number" class="form-control" name="po" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="namabarang">Nama Barang</label>
              <input type="text" class="form-control" name="namabarang" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" name="keterangan" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="penerima">Penerima</label>
              <input type="text" class="form-control" name="penerima"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="varian">Varian</label>
              <input type="text" class="form-control" name="varian"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="innerBox">InnerBox</label>
              <input type="number" class="form-control" name="innerBox" value="0"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="outerBox">OuterBox</label>
              <input type="number" class="form-control" name="outerBox" value="0"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="partisi">Partisi</label>
              <input type="number" class="form-control" name="partisi" value="0"  required>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="submit" name="submitbox" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
