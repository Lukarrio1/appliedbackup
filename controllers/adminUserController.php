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
        exit(json_encode($this->find('users', $id, $this->conn)));
    }
}

$func = isset($_GET['function']) ? (int) $_GET['function'] : null;
$user = new Admin_user;

switch ($func) {
    case 1:
        $user->AllUser($_POST['search']);
        break;
    case 2:
        $user->AdminDeleteUser($_POST['id']);
        break;
    case 3:
        $user->SingleUser($_POST['id']);
        break;
}
