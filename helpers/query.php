<?php

trait Helpers
{
    function find($table, $id, $con)
    {
        $sql = "SELECT * FROM $table WHERE id='$id'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_assoc($qry);
        return mysqli_num_rows($qry) > 0 ? $res : [];
    }

    function delete($table, $id, $con)
    {

        $sql = "DELETE FROM $table WHERE id ='$id'";
        if (mysqli_query($con, $sql)) {
            return 1;
        }
    }

    function all($table, $con)
    {
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        return mysqli_num_rows($qry) > 0 ? $res : [];
    }

    function isActive($active, $id, $con)
    {
        $sql = "UPDATE users set is_active ='$active' where id='$id'";
        return mysqli_query($con, $sql) ? 1 : 0;
    }

    function belongsTo($table, $by, $con)
    {
        $sql = "SELECT * FROM $table WHERE user_id ='$by'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        return mysqli_num_rows($qry) > 0 ? $res : [];
    }

    function dynamicBelongsTo($table, $column, $id, $con)
    {
        $sql = "SELECT * FROM $table WHERE $column ='$id'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        return mysqli_num_rows($qry) > 0 ? $res : [];
    }

    function pivot($table, $id1, $id2, $f1, $f2, $conn)
    {
        $sql = "SELECT * FROM $table WHERE $f1='$id1' AND $f2='$id2'";
        $qry = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($qry);
    }
}
