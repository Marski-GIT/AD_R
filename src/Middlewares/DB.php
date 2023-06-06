<?php

declare(strict_types=1);

namespace adRespect\Middlewares;

use adRespect\Exceptions\AppException;
use mysqli;

final class DB
{
    /**
     * @description Creates a database connection.
     * @throws AppException
     */
    public static function connect(): mysqli
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli(getenv('HOST'), getenv('USER_NAME'), getenv('PASSWORD'), getenv('DB_NAME'));

        if ($mysqli->connect_errno) {
            throw new AppException('Connection failed: ' . $mysqli->connect_error);
        }

        return $mysqli;
    }
}