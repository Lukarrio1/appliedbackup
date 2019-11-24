<?php
require_once '../controllers/BaseController.php';

class Admin_Post extends Base
{
    public $conn;
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function getReportedPosts($s)
    {
        $search = $this->clean($s, $this->conn);
        $sql = $search == "all" ? "SELECT * FROM posts" : "SELECT * FROM posts
        WHERE title LIKE '%$search%' or body LIKE '%$search%'";
        $qry = mysqli_query($this->conn, $sql);
        $all = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        $res = array();
        foreach ($all as $a) {
            $reports = $this->all('reports', $this->conn);
            foreach ($reports as $report) {
                $user = $this->find('users', $a['user_id'], $this->conn);
                if ($a['id'] == $report['post_id']) {
                    $res[] = [
                        'title' => $a['title'],
                        'body' => $a['body'],
                        'id' => $a['id'],
                        'owner' => [
                            'firstName' => $user['firstname'],
                            'lastName' => $user['lastname'],
                            'id' => $user['id'],
                        ],
                        'report' => $report,
                    ];
                }
            }

        }
        exit(json_encode($res));
    }

    public function warnUser($i)
    {
        $id = $this->clean($i, $this->conn);
        $report = $this->find('reports', $id, $this->conn);
        $post = $this->find('posts', $report['post_id'], $this->conn);
        $user = $this->find('users', $post['user_id'], $this->conn);
        $subject = "Post with title " . $post['title'] . " was reported.<br> Please remove or fix the post unless it will be removed by the admin permanently.";
        $this->mail('Post report warning', $subject, $user['email']);
        exit(json_encode(['warn' => 1]));
    }

    public function deleteReportAndPost($i)
    {
        $id = $this->clean($i, $this->conn);
        $report = $this->find('reports', $id, $this->conn);
        $post = $this->find('posts', $report['post_id'], $this->conn);
        $likes = $this->dynamicBelongsTo('likes', 'post_id', $report['post_id'], $this->conn);
        $comments = $this->dynamicBelongsTo('comments', 'post_id', $report['post_id'], $this->conn);
        $reports = $this->dynamicBelongsTo('reports', 'post_id', $report['post_id'], $this->conn);
        foreach ($likes as $like) {
            $this->delete('likes', $like['id'], $this->conn);
        }
        foreach ($comments as $comment) {
            $this->delete('comments', $comment['id'], $this->conn);
        }
        unlink("../storage/postImg/" . $post['img']);
        if ($this->delete('posts', $report['post_id'], $this->conn)) {
            foreach ($reports as $report) {
                $this->delete('reports', $report['id'], $this->conn);
            }
            exit(json_encode(['status' => 1]));
        }
    }
}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$post = new Admin_Post();

switch ($function) {
    case 1:
        $post->getReportedPosts($_POST['search']);
        break;
    case 2:
        $post->warnUser($_POST['id']);
        break;
    case 3:
        $post->deleteReportAndPost($_POST['id']);
        break;
}
