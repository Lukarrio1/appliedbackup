<?php
include_once '../controllers/BaseController.php';

class Friend extends Base
{
    public $conn, $user;

    public function __construct()
    {
        $this->conn = $this->connect();
        $this->user = $this->getState('user')['id'];
    }

    public function searchFriend($search)
    {
        $sql = "";
        if ($search == "all") {
            $sql = "SELECT * FROM users";
        } else {
            $sql = "SELECT * FROM users
        WHERE email LIKE '%$search%' or firstname LIKE '%$search%'";
        }
        $qry = mysqli_query($this->conn, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        exit(json_encode($res));
    }

    public function singleFriend($id)
    {
        $res = array();
        $post_arr = array();
        $comments = array();
        $user = $this->find('users', $id, $this->conn);
        $friends = $this->belongsTo('friends', $id, $this->conn);
        foreach ($friends as $friend) {
            $f = $this->find('users', $friend['friend_id'], $this->conn);
            $res[] = [
                'firstname' => $f['firstname'],
                'lastname' => $f['lastname'],
                'id' => $f['id'],
                'email' => $f['email'],
                'is_active' => $f['is_active'],
            ];
        }
        $posts = $this->belongsTo('posts', $id, $this->conn);
        foreach ($posts as $post) {
            $comment = $this->dynamicBelongsTo('comments', 'post_id', $post['id'], $this->conn);
            $likes = $this->dynamicBelongsTo('likes', 'post_id', $post['id'], $this->conn);
            foreach ($comment as $c) {
                $person = $this->find('users', $c['user_id'], $this->conn);
                $comments[] = [
                    'email' => $person['email'],
                    'firstname' => $person['firstname'],
                    'lastname' => $person['lastname'],
                    'id' => $person['id'],
                    'is_active' => $person['is_active'],
                    'comment' => $c,
                ];
            }
            $post_arr[] = [
                'title' => $post['title'],
                'body' => $post['body'],
                'id' => $post['id'],
                'img' => $post['img'],
                'comments' => $comments,
                'likes' => $likes,

            ];
        }
        $is_friend = empty($this->pivot('friends', $this->user, $id, 'user_id', 'friend_id', $this->conn)) ? 0 : 1;
        $array = array();
        $array = [
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'id' => $user['id'],
            'email' => $user['email'],
            'is_active' => $user['is_active'],
            'friends' => $res,
            'posts' => $post_arr,
            'friend' => $is_friend,
            'logged_user_id' => $this->user,
        ];
        exit(json_encode($array));
    }

    public function followUser($id)
    {
        $notification = array();
        $user = $this->find('users', $this->user, $this->conn);
        $notification = [
            'user_id' => $this->user,
            're_id' => $id,
            'notify' => $user['firstname'] . " is now following you.",
            'class' => 'newfollower',
            'icon' => 'fas fa-walking',
            'ref_id' => $this->user,
        ];
        $friends = $this->pivot('friends', $this->user, $id, 'user_id', 'friend_id', $this->conn);
        if (empty($friends)) {
            $sql = "INSERT INTO friends(friend_id,user_id) VALUES('$id','$this->user')";
            if (mysqli_query($this->conn, $sql)) {
                $this->setNotify($notification, $this->conn);
                exit(json_encode(['friend' => 1]));
            }
        } else {
            if ($this->delete('friends', $friends['id'], $this->conn)) {
                exit(json_encode(['friend' => 0]));
            }
        }
    }

    public function getAllFriends($s)
    {
        $search = $this->clean($s, $this->conn);
        $sql = "";
        if ($search == "all") {
            $sql = "SELECT * FROM users";
        } else {
            $sql = "SELECT * FROM users
        WHERE email LIKE '%$search%' or firstname LIKE '%$search%'";
        }
        $qry = mysqli_query($this->conn, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        exit(json_encode($res));

    }
}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$friend = new Friend;

switch ($function) {
    case 1:
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $friend->searchFriend($search);
        break;
    case 2:
        $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        $friend->singleFriend($id);
        break;
    case 3:
        $id = $_POST['id'];
        $friend->followUser($id);
        break;
    case 4:
        $search = $_POST['search'];
        $friend->getAllFriends($search);
        break;
}
