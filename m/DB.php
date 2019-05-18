<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

abstract class DB {

    // Development
    //private static $server = ['host' => '127.0.0.1', 'user' => 'root', 'password' => 'mysql', 'DB' => 'arcodepr_bnd'];

    // Production
    private static $server = ['host' => 'localhost', 'user' => 'arcodepr_admindd', 'password' => 'Kanashimi.1', 'DB' => 'arcodepr_bnd'];

    /**
     * @return false|mysqli|string
     */
    private static function connect () {
        $conn = mysqli_connect(DB::$server['host'], DB::$server['user'], DB::$server['password'], DB::$server['DB']);
        return $conn ? $conn : mysqli_connect_error();
    }

    /**
     * Cleans a string before execute a query
     *
     * @param string $input
     *
     * @return string
     */
    public static final function clean ($input = '') {
        $c = DB::connect();
        return mysqli_real_escape_string($c, $input);
    }

    /**
     * Executes select, update, insert or delete
     * Returns an array with parameters received, data, count & status
     *
     * @param string $query : 'select * from example limit 1'
     *
     * @return array
     */
    public static final function query ($query = '') {
        $response = [
            'data' => [],
            'count' => 0,
            'success' => false,
            'options' => $query
        ];
        $c = DB::connect();
        if (strpos(strtolower($query), 'select') === 0) {
            if ($result = mysqli_query($c, $query)) {
                $response['count'] = mysqli_num_rows($result);
                while ($row = mysqli_fetch_assoc($result)) {
                    $response['data'][] = $row;
                }
                $response['success'] = true;
            }
        } elseif (strpos(strtolower($query), 'update') === 0) {
            if (mysqli_query($c, $query)) {
                $response['data'] = ['status' => 'Updated'];
                $response['count'] = mysqli_affected_rows($c);
                $response['success'] = true;
            } else {
                $response['data'] = ['status' => 'Error: '.mysqli_error($c)];
                $_SESSION['DB']['last_error'] = str_replace('key', '', str_replace('entry', '', mysqli_error($c)));
            }
        } elseif (strpos(strtolower($query), 'insert') === 0) {
            if (mysqli_query($c, $query)) {
                $response['data'] = ['id' => mysqli_insert_id($c)];
                $response['count'] = mysqli_affected_rows($c);
                $response['success'] = true;
            } else {
                $response['data'] = ['status' => 'Error: '.mysqli_error($c)];
                $_SESSION['DB']['last_error'] = str_replace('key', '', str_replace('entry', '', mysqli_error($c)));
            }
        } elseif (strpos(strtolower($query), 'delete') === 0) {
            if (mysqli_query($c, $query)) {
                $response['data'] = ['status' => 'Deleted'];
                $response['count'] = mysqli_affected_rows($c);
                $response['success'] = true;
            } else {
                $response['data'] = ['status' => 'Error: '.mysqli_error($c)];
                $_SESSION['DB']['last_error'] = str_replace('key', '', str_replace('entry', '', mysqli_error($c)));
            }
        } else {
            $response['data'] = ['status' => 'Query not allowed'];
        }
        mysqli_close($c);
        return $response;
    }

}