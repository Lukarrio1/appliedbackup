<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location:../../../resources/view/index.php');
} else if (isset($_SESSION['admin'])) {
    header('Location:../../../resources/view/admin/index.php');
}
