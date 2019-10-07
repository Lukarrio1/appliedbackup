<?php
include_once '../controllers/BaseController.php';
class Post extends Base
{
    public $conn, $user, $date;

    public function __construct()
    {
        $this->conn = $this->connect();
        session_start();
        $this->user = $_SESSION['user'];
        $this->date = date('M j, Y h:ia', strtotime("now"));
    }

    public function createPost($t, $b)
    {
        $title = $this->clean($t, $this->conn);
        $body = $this->clean($b, $this->conn);
        $imgname = $this->storeImage('postImg');
        $user_id = $this->user['id'];
        $friends = $this->belongsTo('friends', $this->user['id'], $this->conn);
        foreach ($friends as $friend) {
            $user = $this->find('users', $friend['user_id'], $this->conn);
            $notification = array();
            $notification = [
                'user_id' => $this->user['id'],
                're_id' => $friend['friend_id'],
                'notify' => $user['firstname'] . " made a new post",
                'class' => 'newpost',
                'icon' => 'fas fa-atlas',
            ];
            $this->setNotify($notification, $this->conn);
        }
        $sql = "INSERT INTO posts (title,body,img,user_id) VALUES('$title','$body','$imgname','$user_id')";
        if (mysqli_query($this->conn, $sql)) {

            exit(json_encode(['status' => 200]));
        }
    }

    public function deletePost($id)
    {
        $post = $this->find('posts', $id, $this->conn);
        $likes = $this->dynamicBelongsTo('likes', 'post_id', $id, $this->conn);
        $comments = $this->dynamicBelongsTo('comments', 'post_id', $id, $this->conn);

        foreach ($likes as $like) {
            $this->delete('likes', $like['id'], $this->conn);
        }
        foreach ($comments as $comment) {
            $this->delete('comments', $comment['id'], $this->conn);
        }

        if (unlink("../storage/postImg/" . $post['img'])) {
            if ($this->delete('posts', $id, $this->conn)) {
                exit(json_encode(['status' => 1]));
            }
        }

    }

    public function updatePost($t, $b, $id)
    {
        $title = $this->clean($t, $this->conn);
        $body = $this->clean($b, $this->conn);
        $sql = "UPDATE posts SET title='$title', body='$body' WHERE id='$id'";
        if (mysqli_query($this->conn, $sql)) {
            return json_encode(['status' => 200]);
        }
    }

    public function getMyPosts()
    {
        $res = array();
        $posts = $this->belongsTo('posts', $this->user['id'], $this->conn);
        foreach ($posts as $post) {
            $likes = $this->dynamicBelongsTo('likes', 'post_id', $post['id'], $this->conn);
            $comments = $this->dynamicBelongsTo('comments', 'post_id', $post['id'], $this->conn);
            $users = array();
            foreach ($comments as $comment) {
                $user = $this->find('users', $comment['user_id'], $this->conn);
                $users[] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'is_active' => $user['is_active'],
                    'comment' => $comment,
                ];
            }
            $res[] = [
                'id' => $post['id'],
                'body' => $post['body'],
                'title' => $post['title'],
                'img' => $post['img'],
                'comments' => $users,
                'likes' => $likes,
                'user' => $this->user,
            ];
        }
        exit(json_encode($res));

    }

    public function Like($post)
    {
        $id = $this->user['id'];
        $post_id = (int) $this->clean($post, $this->conn);
        $like = $this->pivot('likes', $id, $post_id, 'user_id', 'post_id', $this->conn);
        $acpost = $this->find('posts', $post_id, $this->conn);
        $powner = $this->find('users', $acpost['user_id'], $this->conn);
        $user = $this->find('users', $this->user['id'], $this->conn);
        $notification = array();
        $notification = [
            'user_id' => $this->user['id'],
            're_id' => $powner['id'],
            'notify' => $user['firstname'] . " liked your post",
            'class' => 'newlike',
            'icon' => 'fas fa-heart',
        ];
        if (empty($like)) {
            $sql = "INSERT INTO likes (post_id, user_id) VALUES('$post_id','$id')";
            if (mysqli_query($this->conn, $sql)) {
                $this->setNotify($notification, $this->conn);
                exit(json_encode(['liked' => 1]));
            }
        } else {
            $this->delete('likes', $like['id'], $this->conn);
            exit(json_encode(['liked' => 0]));
        }
    }

    public function deleteComment($id)
    {
        $comment = $this->find('comments', $id, $this->conn);
        $post = $this->find('posts', $comment['post_id'], $this->conn);
        if ($comment['user_id'] == $this->user['id'] || $post['user_id'] == $this->user['id']) {
            if ($this->delete('comments', $id, $this->conn)) {
                exit(json_encode(['status' => 1]));
            }
        }
    }

    public function addComment($c, $p)
    {
        $comment = $this->clean($c, $this->conn);
        $post_id = $this->clean($p, $this->conn);
        $id = $this->user['id'];
        $sql = "INSERT INTO comments(user_id,post_id,comment,created_at) VALUES('$id','$post_id','$comment','$this->date')";
        if (mysqli_query($this->conn, $sql)) {
            exit(json_encode(['status' => 1]));
        }
    }

    public function reportPost($i)
    {
        $id = $this->clean($i, $this->conn);
        $user_id = $this->user['id'];
        $sql = "INSERT INTO reports(post_id,user_id,created_at) VALUES('$id','$user_id','$this->date')";
        if (mysqli_query($this->conn, $sql)) {
            exit(json_encode(['report' => 1]));
        }

    }

    public function getAllPosts()
    {
        $res = array();
        $friends = $this->belongsTo('friends', $this->user['id'], $this->conn);
        foreach ($friends as $friend) {
            $posts = $this->belongsTo('posts', $friend['friend_id'], $this->conn);
            foreach ($posts as $post) {
                $user = $this->find('users', $post['user_id'], $this->conn);
                $res[] = [
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'body' => $post['body'],
                    'img' => $post['img'],
                    'owner' => $user,
                ];
            }
        }

        exit(json_encode($res));

    }
}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$post = new Post;

switch ($function) {
    case 1:
        $title = $_POST['title'];
        $body = $_POST['body'];
        $post->createPost($title, $body);
        break;
    case 2:
        $post->getMyPosts();
        break;
    case 3:
        $post_id = $_POST['post_id'];
        $post->Like($post_id);
        break;
    case 4:
        $id = $_POST['id'];
        $post->deleteComment($id);
        break;
    case 5:
        $id = $_POST['id'];
        $post->deletePost($id);
        break;
    case 6:
        $comment = $_POST['comment'];
        $post_id = $_POST['post_id'];
        $post->addComment($comment, $post_id);
        break;
    case 7:
        $id = $_POST['id'];
        $post->reportPost($id);
        break;
    case 8:
        $post->getAllPosts();
        break;
    default:
        # code...
        break;
}
