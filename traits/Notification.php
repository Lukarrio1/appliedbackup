<?php

trait Notification
{
    function setNotify($notification, $conn)
    {
        $user_id = $notification['user_id'];
        $re_id = $notification['re_id'];
        $notify = $notification['notify'];
        $class = $notification['class'];
        $icon = $notification['icon'];
        // $check_sql = "SELECT * FROM notifications WHERE re_id='$re_id' AND class='$class'";
        // $check_qry = mysqli_query($conn, $check_sql);
        // $res = mysqli_fetch_all($check_qry, MYSQLI_ASSOC);
        // if (count($res) < 1) {
        $sql = "INSERT INTO notifications(user_id,re_id,notify,class,icon) VALUES('$user_id','$re_id','$notify','$class','$icon')";
        if (mysqli_query($conn, $sql)) {
            return 1;
        }
        // }
    }

    function getOneNotify($id, $con)
    {
        $sql = "SELECT * FROM notifications WHERE id='$id'";
        $qry = mysqli_query($con, $sql);
        return mysqli_fetch_all($qry, MYSQLI_ASSOC);
    }

    function getUnClickedNotify($re_id, $conn)
    {
        $sql = "SELECT * FROM notifications WHERE re_id='$re_id'";
        $qry = mysqli_query($conn, $sql);
        return mysqli_fetch_all($qry, MYSQLI_ASSOC);
    }

    function removeNotify($id, $conn)
    {
        $sql = "DELETE FROM notifications WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            return 1;
        }
    }
}
