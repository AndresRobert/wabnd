<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Snackbar.php');
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

if ($type == 'result') {
    $jquery = '<script>$(".snackbar").animate({opacity: 1, bottom: "+=1rem"}, slow, () => {
        setTimeout(() => {$(".snackbar-close").trigger("click");}, slow * 3);
    });</script>';
    Snackbar::alert(['message' => $message]);
    echo Snackbar::show().$jquery;
}