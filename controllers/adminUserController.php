<?php
require_once '../controllers/BaseController.php';

class Admin_user extends Base
{
    public $conn;
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function AllUser($s)
    {
        $search = trim($this->clean($s, $this->conn));
        $sql = $search == "all" ? "SELECT * FROM users" : $sql = "SELECT * FROM users
        WHERE email LIKE '%$search%' or firstname LIKE '%$search%'";
        $qry = mysqli_query($this->conn, $sql);
        $users = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        $res = array();
        foreach ($users as $user) {
            $person = $this->belongsTo('deleted_users', $user['id'], $this->conn);
            $posts = count($this->belongsTo('posts', $user['id'], $this->conn));
            $friends = count($this->belongsTo('friends', $user['id'], $this->conn));
            $res[] = [
                'firstName' => $user['firstname'],
                'lastName' => $user['lastname'],
                'email' => count($person) < 1 ? $user['email'] : $person[0]['email'],
                'id' => $user['id'],
                'is_active' => $user['is_active'],
                'created_at' => $user['created_at'],
                'img' => $user['img'],
                'post_count' => $posts,
                'friend_count' => $friends,
                'is_deleted' => count($person) < 1 ? 0 : 1,
            ];
        }
        exit(json_encode($res));
    }

    public function AdminDeleteUser($i)
    {
        $id = $this->clean($i, $this->conn);
        $posts = $this->belongsTo('posts', $id, $this->conn);
        foreach ($posts as $post) {
            unlink('../storage/postImg/' . $post['img']);
            $likes = $this->belongsTo('likes', $id, $this->conn);
            foreach ($likes as $like) {
                $this->delete('likes', $like['id'], $this->conn);
            }
            $comments = $this->belongsTo('comments', $id, $this->conn);
            foreach ($comments as $comment) {
                $this->delete('comments', $comment['id'], $this->conn);
            }
            $this->delete('posts', $post['id'], $this->conn);
        }
        $this->delete('users', $id, $this->conn);
        exit(json_encode(['status' => 200]));
    }

    public function SingleUser($i)
    {
        $id = $this->clean($i, $this->conn);
        $user = $this->find('users', $id, $this->conn);
        $is_deleted = $this->belongsTo('deleted_users', $id, $this->conn);
        $res = array();
        $email = count($is_deleted) > 0 ? $is_deleted[0]['email'] : $user['email'];
        $res = [
            'email' => $email,
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'id' => $user['id'],
        ];
        exit(json_encode($res));
    }

    public function EmailCheck($e, $i)
    {
        $email = $this->clean($e, $this->conn);
        $id = $this->clean($i, $this->conn);
        if ($this->isEmailAvail('users', $email, $id, $this->conn) == 0) {
            exit(json_encode(['status' => 'Email is in use!', 'error' => 1]));
        } else {
            exit(json_encode(['status' => 200, 'error' => 0]));
        }
    }

    public function UpdateUser($f, $l, $e, $i)
    {
        $firstName = $this->clean($f, $this->conn);
        $lastName = $this->clean($l, $this->conn);
        $email = $this->clean($e, $this->conn);
        $id = $this->clean($i, $this->conn);
        $sql = "UPDATE users set firstname='$firstName', lastname='$lastName', email='$email' WHERE id='$id'";
        if (mysqli_query($this->conn, $sql)) {
            exit(json_encode(['status' => 200]));
        }

    }
}

$func = isset($_GET['function']) ? (int) $_GET['function'] : null;
$user = new Admin_user;

switch ($func) {
    case 1:
        $search = isset($_POST['search']) ? $_POST['search'] : "all";
        $user->AllUser($search);
        break;
    case 2:
        $user->AdminDeleteUser($_POST['id']);
        break;
    case 3:
        $user->SingleUser($_POST['id']);
        break;
    case 4:
        $user->EmailCheck($_POST['email'], $_POST['id']);
        break;
    case 5:
        $user->UpdateUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['id']);
        break;
    default:
        header('Location:../../../resources/view/404.php');
        break;
}
