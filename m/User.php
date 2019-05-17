<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/m/DB.php');

class User {

    public $col;
    static $table = 'users';

    /**
     * @param array $options: array fields, array filter
     *
     * @return array
     */
    static function listAll (array $options = []) {
        $fields = isset($options['fields']) ? $options['fields'] : [];
        $filter = isset($options['filter']) ? $options['filter'] : [];
        $keys = array_keys($fields);
        $values = array_values($fields);
        foreach ($keys as $index => $key) {
            $fields[] = $key." = '".$values[$index]."'";
        }
        $fields = count($fields) > 0 ? implode(', ', $fields) : '*';
        $keys = array_keys($filter);
        $values = array_values($filter);
        foreach ($keys as $index => $key) {
            $filter[] = $key." = '".$values[$index]."'";
        }
        $filter = count($filter) > 0 ? ' WHERE '.implode(' AND ', $filter) : '';
        $result = DB::query('SELECT '.$fields.' FROM '.User::$table.$filter);
        return $result['count'] > 0 ? $result['data'] : [];
    }

    /**
     * @param array $options: array usuario [key => value]
     *
     * @return User|null
     */
    static function add (array $options = []) {
        $user = isset($options['user']) ? $options['user'] : [];
        if (count($user) > 0) {
            $user['user_since'] = date('Y-m-d h:i:s');
            $keys = implode(', ', array_keys($user));
            $values = "'".implode("', '", array_values($user))."'";
            if (count(array_keys($user)) > 0 && count(array_values($user))) {
                $result = DB::query('INSERT INTO '.User::$table.' ('.$keys.') VALUES ('.$values.')');
                if ($result['success']) {
                    return new User(['id' => $result['id']]);
                }
            }
        }
        return null;
    }

    /**:
     * User constructor.
     *
     * @param array $options: int id
     */
    function __construct (array $options = []) {
        $id = isset($options['id']) ? $options['id'] : 0;
        $user = DB::query('SELECT * FROM '.User::$table.' WHERE id = '.$id);
        $this->col = $user['success'] ? $user['data'][0] : null;
    }

    /**
     * @param array $options: array new_user [key => value]
     *
     * @return bool
     */
    function update (array $options = []) {
        $newUser = isset($options['new_user']) ? $options['new_user'] : [];
        if (count($newUser) > 0) {
            $keys = array_keys($newUser);
            $values = array_values($newUser);
            $newData = [];
            foreach ($keys as $index => $key) {
                $newData[] = $key." = '".$values[$index]."'";
            }
            if (count($newData) > 0) {
                $newData = implode(', ', $newData);
                $result = DB::query('UPDATE '.User::$table.' SET '.$newData.' WHERE id = '.$this->col['id']);
                if ($result['success']) {
                    $newUser = new User(['id' => $result['id']]);
                    $this->col = $newUser->col;
                }
                return $result['success'];
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    function delete () {
        $result = DB::query('DELETE FROM '.User::$table.' WHERE id = '.$this->col['id']);
        return $result['success'];
    }
}