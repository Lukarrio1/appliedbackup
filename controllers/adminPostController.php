<?php
require_once '../controllers/BaseController.php';

class Admin_Post extends Base
{
    public $conn;
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function getReportedPosts()
    {
        $reports = $this->all('reports', $this->conn);
        $posts = array();
        foreach ($reports as $report) {
            $post = $this->find('posts', $report['post_id'], $this->conn);
            if (!empty($post)) {
                $posts[] = [
                    'title' => $post['title'],
                    'body' => $post['body'],
                    'id' => $post['id'],
                    'owner' => $this->find('users', $post['user_id'], $this->conn),
                    'report' => $report,

                ];
            } else {
                $posts[] = [
                    'title' => 'Deleted Title',
                    'body' => 'Deleted Body',
                    'id' => '*',
                    'owner' => 'Unknown User',
                    'report' => $report,
                ];
            }
        }
        exit(json_encode($posts));
    }
}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$post = new Admin_Post();

switch ($function) {
    case 1:
        $post->getReportedPosts();
        break;
}
