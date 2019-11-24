<?php

trait Helpers
{
    /**
     * finds an entry.
     *
     * @param [string] $table
     * @param [int] $id
     * @param [Connection] $con
     * @return object
     */
    function find($table, $id, $con)
    {
        $sql = "SELECT * FROM $table WHERE id='$id'";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_assoc($qry);
        return mysqli_num_rows($qry) > 0 ? $res : [];
    }

    /**
     * deletes an entry from the database.
     *
     * @param [string] $table
     * @param [int] $id
     * @param [Connection] $con
     * @return boolean
     */
    function delete($table, $id, $con)
    {

        $sql = "DELETE FROM $table WHERE id ='$id'";
        if (mysqli_query($con, $sql)) {
            return 1;
        }
    }
    /**
     * Returns all the entries in a table.
     *
     * @param [string] $table
     * @param [connection] $con
     * @return array
     */
    function all($table, $con)
    {
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($con, $sql);
        $res = mysqli_fetch_all($qry, MYSQLI_ASSOC);
        return !empty($res) ? $res : [];
    }

    /**
     * returns all of the entries that belongs to or requested by the user.
     *
     * @param [string] $table
     * @param [int] $user_id
     * @param [Connection] $con
     * @return void
     */
    function belongsTo($table, $user_id, $con)
    {
        $sql = "SELECT * FROM $table WHERE user_id ='$user_id'";
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
