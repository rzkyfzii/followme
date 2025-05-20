<?php require('function.php'); ?>
<?php require ('cek.php');?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h2>Produksi B</h2>

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
                      <table id="datatablesSimple" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>PO</th>
                                <th>Nama Barang</th>
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

                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM produksi_b $searchQuery");
                            $i = 1;
                            while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                $tanggal = $data['tanggal'];
                                $po = $data['po'];
                                $namabarang = $data['namabarang'];
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
                                    <td><?= $po; ?></td>
                                    <td><?= $namabarang; ?></td>
                                    <td><?= $botol; ?></td>
                                    <td><?= $varian; ?></td>
                                    <td><?= $sprayer; ?></td>
                                    <td><?= $ring; ?></td>
                                    <td><?= $tutup; ?></td>
                                    <td><?= $innerBox; ?></td>
                                    <td><?= $outerBox; ?></td>
                                    <td><?= $partisi; ?></td>
                                    <td>
                                        
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                            Delete
                                        </button>
                                </tr>

                              

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
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangproduksib">Hapus</button>
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
            <!-- Pilih Gudang A atau C -->
            <div class="col-md-6 mb-3">
              <label for="gudang">Pilih Gudang</label>
              <select class="form-control" name="gudang" required>
                <option value="A">Gudang A</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="po">PO</label>
              <input type="number" class="form-control" name="po" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="namabarang">Nama Barang</label>
              <input type="text" class="form-control" name="namabarang" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="botol">Botol</label>
              <input type="number" class="form-control" name="botol" value="0" required>
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
            <button type="submit" name="B" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<?php include 'layout/footer.php'; ?>
