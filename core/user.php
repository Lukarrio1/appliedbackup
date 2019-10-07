
  <?php
  session_start();
  if (!isset($_SESSION['user'])) {
    header('location:../../../resources/view/login.php');
  }
