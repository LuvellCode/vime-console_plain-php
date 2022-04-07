<?php
if($_POST['action'] == 'run') {
    $config = require("../config.php");
    require('../database.php');

    if (!$config["enabled"]) {
        unset($_SESSION['group']);
        unset($_SESSION['console']);
        header('Location: /');
    }

    session_start();

    if (!isset($_SESSION["console"]) || $_SESSION['console'] != 'validated' || !isset($_SESSION['group']) || !isset($_SESSION['username'])) {
        $_SESSION['login'] = true;
        include "../views/login.php";
        return false;
    }
    unset( $_SESSION['login']);
    $perms = new DataBase(
        $config["perms"]["host"],
        $config["perms"]["user"],
        $config["perms"]["password"],
        $config["perms"]["database"]
    );

    $users_data = $perms->select("SELECT {$config['perms']['user_data_col']} FROM `{$config['perms']['user_data_table']}`");
    foreach ($users_data as $user_data):

        $user_info = json_decode($user_data[$config['perms']['user_data_col']], true);
        $db_username = mb_strtolower($user_info[$config['perms']['user_name']]);

        if ($db_username == $_SESSION['username']) {
            //С СЕССИЕЙ
            $user_group = mb_strtolower($user_info[$config['perms']['user_group']]);
            if ($_SESSION['group'] == $user_group) {
                include '../views/console.php';
            }
        }
    endforeach;
}
else{
    header('Location: /');
}
?>
