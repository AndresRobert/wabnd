<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['refreshEachSession'] = isset($_SESSION['refreshEachSession']) ? $_SESSION['refreshEachSession'] : uniqid('bnd', true);
}
require_once($_SERVER['DOCUMENT_ROOT'].'/m/DB.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Snackbar.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Helper.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/User.php');
$action = isset($action) && $action != ''
    ? $action
    : (isset($_POST['action']) && $_POST['action'] != ''
        ? $_POST['action']
        : (isset($_SESSION['POST']['action']) && $_SESSION['POST']['action'] != ''
            ? $_SESSION['POST']['action']
            : 'dashboard'
        )
    );
?>
<!DOCTYPE html>
<html lang="en, es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Books & Dungeons</title>
    <link rel="icon" href="/v/inc/img/favicon.png" type="image/png" sizes="16x16">
    <link href="/v/inc/jquery-ui.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/v/inc/grid.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/v/inc/base.css?<?php echo $_SESSION['refreshEachSession']; ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="/v/inc/jquery-3.4.0.min.js" type="text/javascript"></script>
    <script src="/v/inc/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/v/inc/base.js?<?php echo $_SESSION['refreshEachSession']; ?>" type="text/javascript"></script>
    <script src="/v/inc/main.js?<?php echo $_SESSION['refreshEachSession']; ?>" type="text/javascript"></script>
</head>
<body>
<div class="nav-disabler"></div>
<fab class="nav-toggle-s"><icon class="menu"></icon></fab>
<nav class="collapsed">
    <div class="nav-toggle-l"><icon class="menu"></icon></div>
    <ul>
        <li id="goToDashboard">Dashboard <icon class="dashboard to-right"></icon></li>
        <li class="divider"></li>
        <li id="logMeOut">Logout <icon class="logout to-right"></icon></li>
    </ul>
</nav>
<main>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/v/'.$controller.'/'.$action.'.php') ?>
</main>
<script>
    $(() => {
        $(document).on('click', '#logMeOut', () => {
            let data = {request: "logout"};
            service('/ms/users.php', data)
                .then((data) => {
                    snackbar('result', data.message);
                    location.href = '/';
                })
                .catch((error) => {
                    // TODO: Mail Admin page and error
                    snackbar('result', error);
                });
        });
        $(document).on('click', '#goToDashboard', () => {
            postRedirect('users', 'dashboard');
        });
    });
</script>
<?php echo Snackbar::show(); ?>
</body>
</html>