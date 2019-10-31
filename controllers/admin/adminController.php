<?php
require_once '../../controllers/BaseController.php';

class Admin extends Base
{
    public $conn, $admin;
    public function __construct()
    {
        $this->conn = $this->connect();
        $this->admin = $this->getState('admin');
    }

    public function Admin()
    {
        exit(json_encode($this->find('admin', $this->admin['id'], $this->conn)));
    }

}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$admin = new Admin;

switch ($function) {
    case 1:
        $admin->Admin();
        break;
}
