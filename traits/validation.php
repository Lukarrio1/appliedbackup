<?php
trait validator
{
    function isEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 0;
        } else {
            return 1;
        }
    }

    function isEmailInUse($email, $con)
    {
        if ($this->isEmail($email) == 1) {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $qry = mysqli_query($con, $sql);
            $res = mysqli_fetch_assoc($qry);
            return $res['email'] == $email ? 1 : 0;
        } else {
            return 1;
        }
    }

    function isPassword($password)
    {
        return strlen($password) >= 6 ? 1 : 0;
    }

    function isEmailAvail($table, $email, $id, $con)
    {
        $sql = "SELECT * FROM $table WHERE email='$email'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_assoc($qry);
        if ($res['id'] == $id) {
            return 1;
        } else if (mysqli_num_rows($qry) < 1) {
            return 1;
        } else {
            return 0;
        }
    }
}
