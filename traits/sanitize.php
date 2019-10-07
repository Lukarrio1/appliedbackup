<?php

trait Sanitize
{

    public function clean($dirt, $con)
    {
        return trim(htmlentities(mysqli_real_escape_string($con, $dirt)));
    }
}
