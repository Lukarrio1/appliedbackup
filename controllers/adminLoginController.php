<?php
require_once '../controllers/BaseController.php';

class Admin_login extends Base
{
    public $conn;
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function login($p, $e)
    {
        $password = sha1($this->clean($p, $this->conn));
        $email = $this->isEmail($e) == 1 ? $this->clean($e, $this->conn) : null;
        $sql = "SELECT * FROM admins WHERE email='$email' AND password ='$password'";
        $qry = mysqli_query($this->conn, $sql);
        $res = mysqli_fetch_assoc($qry);
        if (!empty($res)) {
            $this->addState('admin', $res);
            exit(json_encode(['status' => 200]));
        } else {
            $this->createAdmin();
            exit(json_encode(['status' => 403]));
        }
    }

    public function createAdmin()
    {
        $name = "admin";
        $email = "admin@carrium.com";
        $password = sha1("admin123");
        $all = $this->all('admins', $this->conn);
        if (count($all) < 1) {
            $sql = "INSERT INTO admins(name,email,password) VALUES('$name','$email','$password')";
            if (mysqli_query($this->conn, $sql)) {
                exit(json_encode(['status' => 200]));
            }
        }
    }

    public function logout()
    {
        $this->removeState('admin');
        exit(json_encode(['status' => 200]));
    }
}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$admin = new Admin_login;

switch ($function) {
    case 1:
        $email = $_POST['email'];
        $password = $_POST['password'];
        $admin->login($password, $email);
        break;
    case 2:
        $admin->logout();
        break;
}
