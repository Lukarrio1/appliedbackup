<?php
require_once '../controllers/BaseController.php';

class Admin extends Base
{
    public $conn, $admin;
    public function __construct()
    {
        $this->conn = $this->connect();
        $this->admin = $this->getState('admin') != 0 ? $this->getState('admin') : null;
    }

    public function Admin()
    {
        exit(json_encode($this->find('admins', $this->admin['id'], $this->conn)));
    }

    public function updateAdmin($n, $e)
    {
        $name = $this->clean($n, $this->conn);
        $email = $this->clean($e, $this->conn);
        $id = $this->admin['id'];
        if ($this->isEmailAvail('admins', $email, $this->admin['id'], $this->conn) == 0) {
            exit(json_encode(['is_error' => 1, 'error' => 'Email already in use.']));
        } else {
            $sql = "UPDATE admins SET name='$name', email='$email' WHERE id='$id'";
            if (mysqli_query($this->conn, $sql)) {
                exit(json_encode(['status' => 200]));
            };

        }
    }

}

$function = isset($_GET['function']) ? (int) $_GET['function'] : null;
$admin = new Admin;

switch ($function) {
    case 1:
        $admin->Admin();
        break;
    case 2:
        $admin->updateAdmin($_POST['name'], $_POST['email']);
        break;
}
