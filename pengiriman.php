<?php require('function.php'); ?>
<?php require ('cek.php');?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h2>Pengiriman</h2>

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
                                <th>Nama Penerima</th>
                                <th>Nama Barang</th>
                                <th>Varian</th>
                                <th>Alamat</th>
                                <th>Jumlah Koli</th>
                                <th>Jumlah PCS</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Search query
                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $searchQuery = $search ? "WHERE namabarang LIKE '%$search%'" : "";

                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM pengiriman $searchQuery");
                            $i = 1;
                            while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                $tanggal = $data['tanggal'];
                                $po = $data['po'];
                                $namapenerima = $data['namapenerima'];
                                $namabarang = $data['namabarang'];
                                $varian = $data['varian'];
                                $alamat = $data['alamat'];
                                $jumlahkoli = $data['jumlahkoli'];
                                $jumlahpcs = $data['jumlahpcs'];
                                $innerBox = $data['keterangan'];
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $po; ?></td>
                                    <td><?= $namapenerima; ?></td>
                                    <td><?= $namabarang; ?></td>
                                    <td><?= $varian; ?></td>
                                    <td><?= $alamat; ?></td>
                                    <td><?= $jumlahkoli; ?></td>
                                    <td><?= $jumlahpcs; ?></td>
                                    <td><?= $keterangan; ?></td>
                                    <td>
                                </tr>

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
   <!-- The Modal -->
   <div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Pengiriman Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form method="POST" class="custom-form">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="po">PO</label>
              <input type="number" class="form-control" name="po" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="namapenerima">Nama Penerima</label>
              <input type="text" class="form-control" name="namapenerima" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="namabarang">Nama Barang</label>
              <input type="text" class="form-control" name="namabarang" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="varian">Varian</label>
              <input type="text" class="form-control" name="varial"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" name="alamat"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="jumlahkoli">Jumlah Koli</label>
              <input type="number" class="form-control" name="jumlahkoli" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="jumlahpcs">Jumlah PCS</label>
              <input type="number" class="form-control" name="jumlahpcs" value="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" name="keterangan" required>
            </div>
          

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="submit" name="kirim" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>



<?php include 'layout/footer.php'; ?>
