<?php

abstract class Snackbar {

    /**
     * @param array $options: message
     */
    public static function alert($options = []) {
        $message = isset($options['message']) ? $options['message'] : '';
        $_SESSION['bnd_snackbar']['message'] = $message;
        $_SESSION['bnd_snackbar']['show'] = true;
    }

    /**
     * @return string
     */
    public static function show() {
        $html = '';
        if (isset($_SESSION['bnd_snackbar']['show']) && $_SESSION['bnd_snackbar']['show']) {
            unset($_SESSION['bnd_snackbar']['show']);
            $html = '<div class="snackbar">
                <div class="snackbar-message">'.$_SESSION['bnd_snackbar']['message'].'</div>
            </div>';
        }
        return $html;
    }
}