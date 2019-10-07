<?php

trait State
{
    function addState($key, $data)
    {
        session_start();
        $_SESSION[$key] = $data;
        return 1;
    }

    function removeState($key)
    {
        session_start();
        $_SESSION[$key] = null;
        return 1;
    }

    function getState($key)
    {
        session_start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : 0;
    }
}
