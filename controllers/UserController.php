<?php
require_once '../controllers/BaseController.php';

class User extends Base
{
    public $user, $conn;

    public function __construct()
    {
        $this->user = $this->getState('user') != 0 ? $this->getState('user') : null;
        $this->conn = $this->connect();
    }

    public function getAuthUser()
    {
        $user = $this->find('users', $this->user['id'], $this->conn);
        if (!empty($user)) {
            exit(json_encode($user));
        } else {
            $this->removeState('user');
        }
    }

    public function updateUser($f, $l, $e)
    {
        $fname = $this->clean($f, $this->conn);
        $lname = $this->clean($l, $this->conn);
        $email = $this->clean($e, $this->conn);
        if ($this->isEmailAvail('users', $email, $this->user['id'], $this->conn) == 0) {
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
            $this->mail('Password Reset', 'please copy the reset key <br> Reset Key :' . $res['r_key'], $email);
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
            exit(json_encode(['status' => 1]));
        }
    }

    public function deleteAccount()
    {
        if ($this->deleteUser($this->user['id'], $this->user['email'], $this->conn) == 1) {
            $this->isActive(0, $this->user['id'], $this->conn);
            $this->removeState('user');
            exit(json_encode(['status' => 200]));
        }
    }

    public function UploadProImg()
    {
        $img = $this->storeImage('profile_img');
        $id = $this->user['id'];
        $user = $this->find('users', $id, $this->conn);
        unlink('../storage/profile_img/' . $user['img']);
        $sql = "UPDATE users set img='$img' WHERE id='$id'";
        if (mysqli_query($this->conn, $sql)) {
            exit(json_encode(['upload Img' => 1]));
        } else {
            exit(json_encode(['upload Img' => 0]));
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
        $fname = trim($_POST['firstname']);
        $lname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $user->updateUser($fname, $lname, $email);
        break;
    case 3:
        $email = trim($_POST['email']);
        $user->emailYours($email);
        break;
    case 4:
        $_rkey = trim($_POST['r_key']);
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
    case 7:
        $user->deleteAccount();
        break;
    case 8:
        $user->UploadProImg();
        break;
    default:
        header('Location:../resources/view/404.php');
        break;
}
