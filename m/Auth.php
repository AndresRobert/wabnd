<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/m/DB.php');

abstract class Auth {

    /**
     * @param array $options: type [email, username], email/username, password
     *
     * @return bool
     */
    static public function login ($options = []) {
        $type = isset($options['type']) ? $options['type'] : 'username';
        $email = isset($options['email']) ? DB::clean($options['email']) : '';
        $username = isset($options['username']) ? DB::clean($options['username']) : '';
        $password = isset($options['password']) ? DB::clean($options['password']) : '';
        $user = $type == 'username'
            ? DB::query("SELECT id, password FROM users WHERE username = '{$username}' AND deleted = 0")
            : DB::query("SELECT id, password FROM users WHERE email = '{$email}' AND deleted = 0");
        if (isset($user['data'][0]['password']) && $user['data'][0]['password'] == Auth::encrypt(['password' => $password])) {
            $_SESSION['bnd_user_authenticated'] = $user['data'][0]['id'];
            return true;
        } else {
            unset($_SESSION['bnd_user_authenticated']);
        }
        return false;
    }

    /**
     * @return bool
     */
    static public function logout () {
        session_unset();
        session_destroy();
        return true;
    }

    /**
     * @return bool
     */
    static public function isAuthenticated () {
        return isset($_SESSION['bnd_user_authenticated']);
    }

    /**
     * @param array $options: password
     *
     * @return bool|string
     */
    static public function encrypt ($options = []) {
        $password = isset($options['password']) ? $options['password'] : '';
        $salt = isset($options['salt']) ? $options['salt'] : '652c4c937a28b835210517ef345188fd24623a4be4560634965f9b944630315876776bd1c6d938c9316a055483bdd8c989eade7861ccc807';
        $password = strlen($password) < strlen($salt) ? substr($salt, 0, strlen($salt) - strlen($password)).$password : $password;
        return base64_encode(sha1(md5($password)));
    }

    /**
     * @param array $options: int length
     *
     * @return string
     */
    static public function newPassword ($options = []) {
        $length = isset($options['length']) ? $options['length'] : 8;
        if ($length > 0) return chr(rand(33, 126)).newPassword(['length' => ($length - 1)]);
    }

}