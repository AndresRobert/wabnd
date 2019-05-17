<?php

abstract class Helper {

    static public function imgProfile($options = []) {
        $filename = isset($options['filename']) && trim($options['filename']) != '' ? '/v/inc/img/'.$options['filename'] : '/v/inc/img/avatar_default.svg';
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].$filename)) {
            $filename = '/v/inc/img/avatar_default.svg';
        }
        return $filename;
    }

}