<?php

session_start();

trait State
{
    /**
     * Adds data to a session
     *
     * @param [string] $key
     * @param [array] $data
     * @return void
     */
    function addState($key, $data)
    {

        $_SESSION[$key] = $data;
        return 1;
    }

    /**
     * Removes data from a session
     *
     * @param [string] $key
     * @return void
     */
    function removeState($key)
    {
        $_SESSION[$key] = null;
        return 1;
    }

    /**
     * Returns data from a session
     *
     * @param [string] $key
     * @return void
     */
    function getState($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : 0;
    }
}
