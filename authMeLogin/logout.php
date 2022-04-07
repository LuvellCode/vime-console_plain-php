<?php
if($_POST['action'] == 'logout'){
    session_start();
    unset($_SESSION['group']);
    unset($_SESSION['console']);
    unset( $_SESSION['login']);
}
else{
    $config = require '../config.php';
    die($config['hackerman_msg']);
}
?>