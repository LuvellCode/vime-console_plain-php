<?
$config = require('../config.php');
if(isset($_POST['submit'])){
    session_start();
    $username = mb_strtolower($_POST['username']);
    $password = $_POST['password'];
    $_SESSION['username'] = $username;
    //AUTH_LOG
    if($config['auth_log']){
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $file = "auth_log.txt";
        $current = file_get_contents($file);
        $date = date("d.m.y H:i", time());
        $current .= PHP_EOL."[{$date} - {$ip}] Попытка входа. Ник: {$username}. Статус: ";
    }
    require('../database.php');
    //permissionsEX DataBase[protected]
    $perms = new DataBase(
        $config["perms"]["host"],
        $config["perms"]["user"],
        $config["perms"]["password"],
        $config["perms"]["database"]
    );
    //AuthMe DataBase [protected]
    $authMe = new DataBase(
        $config["authme"]["host"],
        $config["authme"]["user"],
        $config["authme"]["password"],
        $config["authme"]["database"]
    );
    if (empty($username) || empty($password)) {
        //empty_fields
        $_SESSION["error"] = 'empty_fields';
        //AUTH LOG
        if($config['auth_log']){
            $current.="Ошибка (Пустые поля).";
            file_put_contents($file, $current);
        }
        header('Location: /');
    } else {
        $result = $authMe->select("SELECT {$config['authme']['password_col']} FROM `{$config['authme']['table_name']}` WHERE `{$config['authme']['username_col']}`={?}", [$username]);
        if(!empty($result)){
            if (isValidPassword($password, $result[0][$config['authme']['password_col']])) {
                /*УСПЕШНЫЙ ВХОД*/
                $users_data = $perms->select("SELECT {$config['perms']['user_data_col']} FROM `{$config['perms']['user_data_table']}`");
                foreach ($users_data as $user_data):
                    $user_info = json_decode($user_data[$config['perms']['user_data_col']], true);
                    $db_username = mb_strtolower($user_info[$config['perms']['user_name']]);
                    if($db_username == $username){
                        //С СЕССИЕЙ
                        $_SESSION['group']= mb_strtolower($user_info[$config['perms']['user_group']]);
                        $_SESSION['username']= $username;
                        $_SESSION['console'] = 'validated';
                        //setcookie('__console', $user_nickname.":".hashGroupPassword($user_group), 0,'/');
                        //AUTH LOG
                        if($config['auth_log']){
                            $current.="Успех. Группа: [".$_SESSION['group']."]";
                            file_put_contents($file, $current);
                        }
                        header("Location: /");
                    }
                endforeach;
            } else {
                //wrong_password
                $_SESSION["error"] = 'wrong_password';
                //AUTH LOG
                if($config['auth_log']){
                    $current.="Ошибка (Неверный пароль).";
                    file_put_contents($file, $current);
                }
                header('Location: /');
            }
        } else {
            //user_not_found
            $_SESSION["error"] = 'user_not_found';
            //AUTH LOG
            if($config['auth_log']){
                $current.="Ошибка (Игрок не найден).";
                file_put_contents($file, $current);
            }
            header('Location: /');
        }
    }
}
else{
    die($config['hackerman_msg']);
}

function isValidPassword($password, $hash) {
    // $SHA$salt$hash, where hash := sha256(sha256(password) . salt)
    $parts = explode('$', $hash);
    return count($parts) === 4 && $parts[3] === hash('sha256', hash('sha256', $password) . $parts[2]);
}
?>