
  <?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location:../../../resources/view/admin/login.php');
}
