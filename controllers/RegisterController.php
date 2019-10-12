<?php
include '../controllers/BaseController.php';

class Register extends Base
{
    public $conn, $_key, $date;

    public function __construct()
    {
        $this->conn = $this->connect();
        $this->_key = str_shuffle('abcdefghijklmnopqrstuvwyz');
        $this->date = date('M j, Y h:ia', strtotime("now"));
    }

    public function register($f, $l, $e, $p)
    {
        $fname = $this->clean($f, $this->conn);
        $lname = $this->clean($l, $this->conn);
        $email = $this->clean($e, $this->conn);
        $password = $this->clean($p, $this->conn);

        if ($this->isEmailInUse($email, $this->conn) == 1) {
            exit(json_encode([
                'Error' => 'Email is already in use.',
                'register' => 0,
            ]));
        } else {
            $sql = "INSERT INTO users (email,password,firstname,lastname,r_key,created_at,is_active) VALUES('$email','$password','$fname','$lname','$this->_key','$this->date',0)";
            if (mysqli_query($this->conn, $sql)) {
                // $user = $this->dynamicBelongsTo('users', 'email', $email, $this->conn);
                // $this->addState('user', $user);
                exit(json_encode(['register' => 1]));
            }

        }
    }
}

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = sha1($_POST['password']);

$rg = new Register;
$rg->register($fname, $lname, $email, $password);
