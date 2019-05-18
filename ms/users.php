<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/m/User.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Auth.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/m/Snackbar.php');
$post = json_decode(file_get_contents('php://input'), true);

if ($post['request'] == 'login') {
    $email = $post['email'];
    $password = $post['password'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(['success' => false, 'message' => 'Email is not valid ('.$email.')']);
    } else {
        if (Auth::login(['type' => 'email', 'email' => $email, 'password' => $password])) {
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Your email/password does not match any user']);
        }
    }
}
elseif ($post['request'] == 'register') {
    $email = $post['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(['success' => false, 'message' => 'Email is not valid ('.$email.')']);
    } else {
        $username = filter_var($post['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        if (trim($username, ' ') == '') {
            echo json_encode(['success' => false, 'message' => 'Username is not valid']);
        } else {
            $password = filter_var($post['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            if (trim($password, ' ') == '') {
                echo json_encode(['success' => false, 'message' => 'Password is not valid']);
            } else {
                $password = Auth::encrypt(['password' => $password]);
                $user = User::add(['user' => ['email' => $email, 'username' => $username, 'password' => $password]]);
                if (!is_null($user)) {
                    echo json_encode(['success' => true, 'message' => 'User created']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'User could not be created: '.$_SESSION['DB']['last_error']]);
                }
            }
        }
    }
}
elseif ($post['request'] == 'recover') {
    $email = $post['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(['success' => false, 'message' => 'Email is not valid ('.$email.')']);
    } else {
        $result = DB::query("SELECT id FROM users WHERE email like '{$email}'");
        if ($result['success']) {
            $user = new User(['id' => $result['data']['id']]);
            if (!is_null($user)) {
                $password = Auth::newPassword();
                if ($user->update(['password' => Auth::encrypt(['password' => $password])])) {
                    Mail::send(['to' => $email, 'message' => "Your new password is: {$password}"]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No user found']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No user found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user found']);
        }
    }
}
elseif ($post['request'] == 'logout') {
    Auth::logout();
    echo json_encode(['success' => true, 'message' => 'Logout successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}