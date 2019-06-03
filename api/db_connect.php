<?php

class DB_CONNECT
{
    function __construct()
    {
        $this->connect();
    }

    function __destruct()
    {
        $this->close();
    }

    function connect()
    {
        require_once 'db_config.php';
        $con = mysqli_connect(
            DB_SERVER,
            DB_USER,
            DB_PASSWORD,
            DB_DATABASE
        )
        or die(mysqli_error($con));

        mysqli_set_charset($con, "utf8");

        $db = mysqli_select_db($con, DB_DATABASE) or die(mysqli_error($con)) or die(mysqli_error($con));

        return $con;
    }

    function close()
    {
        mysqli_close($this->connect());
    }
}
