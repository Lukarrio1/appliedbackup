<?php

trait User_trait
{
    /**
     *Deletes a user.
     *
     * @param [int] $id
     * @param [connection string] $con
     * @return void
     */
    function deleteUser($id, $email, $con)
    {
        $sql = "SELECT * FROM deleted_users WHERE user_id= '$id'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        $e = sha1($email);
        $s = "UPDATE users SET email='$e' WHERE id='$id'";
        $q = mysqli_query($con, $s);
        if (!empty($res)) {
            return 0;
        } else {
            $sql = "INSERT INTO deleted_users(user_id,email) VALUES('$id','$email')";
            if (mysqli_query($con, $sql)) {
                return 1;
            }
        }

    }

    /**
     * Checks if the user is deleted
     *
     * @param [int] $id
     * @param [connection string] $con
     * @return boolean
     */
    function isDeleted($id, $con)
    {
        $S = "SELECT * FROM deleted_users WHERE user_id='$id'";
        $Q = mysqli_query($con, $S);
        $R = mysqli_fetch_all($Q, MYSQLI_ASSOC);
        if (count($R) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Makes the user status either active or inactive.
     *
     * @param [int] $active
     * @param [int] $id
     * @param [connection string] $con
     * @return boolean
     */
    function isActive($active, $id, $con)
    {
        $sql = "UPDATE users set is_active ='$active' where id='$id'";
        return mysqli_query($con, $sql) ? 1 : 0;
    }
}
