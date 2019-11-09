<?php

require_once '../controllers/BaseController.php';

class DashBoard extends Base
{
    public $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function dashBoard()
    {
        $users = $this->all('users', $this->conn);
        $reports = $this->all('reports', $this->conn);
        $posts = $this->all('posts', $this->conn);
        $deleted = 0;
        foreach ($users as $user) {
            $deleted = $this->isDeleted($user['id'], $this->conn) == 1 ? $deleted + 1 : $deleted + 0;
        }
        $data = [
            'active_users' => count($users) - $deleted,
            'reports' => count($reports),
            'posts' => count($posts),
            'deleted_users' => $deleted,
        ];

        exit(json_encode($data));
    }

}

$func = isset($_GET['function']) ? (int) $_GET['function'] : null;
$dashBoard = new DashBoard;

switch ($func) {
    case 1:
        $dashBoard->dashBoard();
        break;

}
