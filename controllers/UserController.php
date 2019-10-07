<?php
require_once '../controllers/BaseController.php';

class User extends Base
{
    public $user, $conn;

    public function __construct()
    {
        session_start();
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $this->conn = $this->connect();
    }

    public function getAuthUser()
    {
        exit(json_encode($this->find('users', $this->user['id'], $this->conn)));
    }

    public function updateUser($f, $l, $e)
    {
        $fname = $this->clean($f, $this->conn);
        $lname = $this->clean($l, $this->conn);
        $email = $this->clean($e, $this->conn);
        if ($this->isEmailAvail($email, $this->user['id'], $this->conn) == 0) {
            exit(json_encode(['error' => 'Email is already in use.']));
        } else {
            $sql = "UPDATE users SET email='$email', firstname='$fname',lastname='$lname' WHERE id='" . $this->user['id'] . "'";
            if (mysqli_query($this->conn, $sql)) {
                exit(json_encode(['update' => 'Users updated successfully.']));
            }
        }
    }

    public function emailYours($e)
    {
        $email = $this->clean($e, $this->conn);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $qry = mysqli_query($this->conn, $sql);
        $res = mysqli_fetch_assoc($qry);
        if (mysqli_num_rows($qry) > 0) {
            $this->addState('user_data', $res);
            exit(json_encode(['status' => 1]));
        } else {
            exit(json_encode(['status' => 0]));
        }
    }

    public function passwordReset($r, $p)
    {
        $r_key = $this->clean($r, $this->conn);
        $password = sha1($this->clean($p, $this->conn));
        if (!empty($this->dynamicBelongsTo("users", 'r_key', $r_key, $this->conn))) {
            $sql = "UPDATE users SET password ='$password' WHERE r_key='$r_key'";
            if (mysqli_query($this->conn, $sql)) {
                exit(json_encode(['password' => 1]));
            }
        } else {
            exit(json_encode(['password' => 0]));
        }
    }

    public function getAllNotify()
    {
        exit(json_encode($this->getUnClickedNotify($this->user['id'], $this->conn)));
    }

    public function seenNotify($id)
    {
        if ($this->removeNotify($id, $this->conn) == 1) {
            return 1;
        }
    }

}

$function = isset($_GET['func']) ? (int) $_GET['func'] : null;

$user = new User;
switch ($function) {
    case 1:
        $user->getAuthUser();
        break;
    case 2:
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $user->updateUser($fname, $lname, $email);
        break;
    case 3:
        $email = $_POST['email'];
        $user->emailYours($email);
        break;
    case 4:
        $_rkey = $_POST['r_key'];
        $password = $_POST['password'];
        $user->passwordReset($_rkey, $password);
        break;
    case 5:
        $user->getAllNotify();
        break;
    case 6:
        $id = $_POST['id'];
        $user->seenNotify($id);
        break;
}
