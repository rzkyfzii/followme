<?php require 'function.php'; ?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>
<?php include 'auth.php'; ?>

<h1>Welcome to Dashboard</h1>
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


<?php include 'layout/footer.php'; ?>
