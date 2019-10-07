<?php
require_once '../controllers/BaseController.php';

class Login extends Base
{

    public $conn, $user;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function login($e, $password)
    {
        $npassword = sha1($this->clean($password, $this->conn));
        $email = $this->clean($e, $this->conn);
        if ($this->isEmail($email) == 1 && $this->isPassword($password) == 1) {
            $login_sql = "SELECT * FROM users WHERE email='$email' AND password='$npassword'";
            $login_qry = mysqli_query($this->conn, $login_sql);
            $this->user = mysqli_fetch_assoc($login_qry);
            if (mysqli_num_rows($login_qry) < 1) {
                exit(json_encode(['login' => false]));
            } else {
                $this->setSession();
                exit(json_encode(['login' => true]));
            }
        } else {
            exit(json_encode(['login' => 0]));
        }
    }

    public function setSession()
    {
        session_start();
        $_SESSION['user'] = $this->user;
        $this->isActive(1, $this->user['id'], $this->conn);
    }

    public function logout()
    {
        session_start();
        $this->isActive(0, $_SESSION['user']['id'], $this->conn);
        session_destroy();
    }
}

$login = new Login;

$function = isset($_GET['function']) ? $_GET['function'] : null;

switch ($function) {
    case 'login':
        $login->login(
            $_POST['email'],
            $_POST['password']
        );
        break;
    case 'logout':
        $login->logout();
        header('Location:../resources/view/login.php');
        break;
}
