<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['refreshEachSession'] = isset($_SESSION['refreshEachSession']) ? $_SESSION['refreshEachSession'] : uniqid('bnd', true);
}
require_once($_SERVER['DOCUMENT_ROOT'].'/m/DB.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Snackbar.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/User.php');
$action = isset($action) && $action != ''
    ? $action
    : (isset($_POST['action']) && $_POST['action'] != ''
        ? $_POST['action']
        : (isset($_SESSION['POST']['action']) && $_SESSION['POST']['action'] != ''
            ? $_SESSION['POST']['action']
            : 'login'));
?>
<!DOCTYPE html>
<html lang="en, es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Books & Dungeons</title>
    <link rel="icon" href="/v/inc/img/favicon.png" type="image/png" sizes="16x16">
    <link href="/v/inc/fa/css/all.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/v/inc/jquery-ui.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/v/inc/grid.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/v/inc/base.css?<?php echo $_SESSION['refreshEachSession']; ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="/v/inc/jquery-3.4.0.min.js" type="text/javascript"></script>
    <script src="/v/inc/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/v/inc/fa/js/all.min.js" type="text/javascript"></script>
    <script src="/v/inc/base.js?<?php echo $_SESSION['refreshEachSession']; ?>" type="text/javascript"></script>
</head>
<body>
<main>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/v/'.$controller.'/'.$action.'.php') ?>
</main>
<?php echo Snackbar::show(); ?>
</body>
</html>