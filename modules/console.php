<?php

date_default_timezone_set('Europe/Moscow');

$config = require "../config.php";
session_start();

if($_SESSION['console'] != 'validated'){
    die($config['hackerman_msg']);
}
if(empty($_SESSION['username']) or empty($_SESSION['group'])) {
    unset($_SESSION["console"]);
    die($config['hackerman_msg']);
}

require "../database.php";
require "../rcon.php";
$database = new DataBase(
    $config["mysql"]["host"],
    $config["mysql"]["user"],
    $config["mysql"]["password"],
    $config["mysql"]["database"]
);
$params = array(
    "username"      => $_SESSION['username'],
    'group'         => $_SESSION['group']
);
switch($_POST["action"]) {
    case "sendCommand":
        $commandList = $config["groups"][$params["group"]];
        $array = explode(",", $commandList);
        $userCommand = trim($_POST["command"], "/");
        if(empty($userCommand)) {
            die(json_encode(array("status" => "danger", "message" => "Укажите команду")));
        }
        $explodedCommand = explode(" ", $userCommand);

        $file = "../log.txt";
        $current = file_get_contents($file);
        $date = date("d.m.y H:i", time());
        $forLogCommand = strtoupper($explodedCommand[0]);
        if(isset($config["commmands_with_arguments"][$explodedCommand[0]])) {
            $ex = explode(":", $config["commmands_with_arguments"][$explodedCommand[0]]);
            $position = $ex[1];
            if($ex[0] == "{username}") {
                $ex[0] = $params["username"];
            }
            if($explodedCommand[$position] != $ex[0]) {
                die(json_encode(array("status" => "danger", "message" => "Вы не можете использовать эту команду без определенного аргумента [{$ex[0]}]")));
            }
        }
        if(!in_array($explodedCommand[0], $array)) {
            $current .= "[{$date} - {$params["username"]}] Не хватает прав для выполнения {$forLogCommand} (Полная команда: $userCommand)\n";
            file_put_contents($file, $current);
            die(json_encode(array("status" => "danger", "message" => "Команда [{$userCommand}] не может быть выполнена")));
        } elseif(preg_match("/[а-яё]/iu", $explodedCommand[0])) {
            die(json_encode(array("status" => "danger", "message" => "Тело команды не может содержать русских символов")));
        } else {
            if(isset($config["timeout"][$explodedCommand[0]])) {
                $data = $database->select("SELECT * FROM `{$config['mysql']['uses_table']}` WHERE `command` = {?} AND `username` = {?}", [$explodedCommand[0], $params["username"]]);
                foreach($data as $c) {
                    if(time() > $c["time"]) {
                        $database->query("DELETE FROM `{$config['mysql']['uses_table']}` WHERE `id` = {?}", [$c["id"]]);
                    }
                }
                $count = $database->selectCell("SELECT COUNT(*) FROM `{$config['mysql']['uses_table']}` WHERE `command` = {?} AND `username` = {?}", [$explodedCommand[0], $params["username"]]);
                if($count >= $config["timeout"][$explodedCommand[0]]) {
                    die(json_encode(array("status" => "danger", "message" => "Вы использование максимальное количество раз. Подождите до завтра!")));
                }
                $database->query("INSERT INTO `{$config['mysql']['uses_table']}` (`id`, `username`, `command`, `time`) VALUES (NULL, {?}, {?}, {?})", [$params["username"], $explodedCommand[0], time() + 60 * 60 * 24]);
            }

            $rcon = new Rcon(
                $config["rcon"]["host"],
                $config["rcon"]["port"],
                $config["rcon"]["password"],
                $config["rcon"]["timeout"]
            );

            if($rcon->connect()) {
                $serverResult = $rcon->sendCommand($userCommand);
            } else {
                $current .= "[{$date} - {$params["username"]}] Поступил запрос на обработку команды {$forLogCommand}, но сервер не отвечает\n";
                file_put_contents($file, $current);
                die(json_encode(array("status" => "danger", "message" => "Отсутствует подключение к серверу")));
            }
            $current .= "[{$date} - {$params["username"]}] Успешно выполнена команда {$forLogCommand} (Полная команда: $userCommand)\n";
            file_put_contents($file, $current);

            die(json_encode(array("status" => "success", "message" => "Ответ сервера: {$serverResult}")));
        }
        break;
    case "getCommands":
        $a = explode(",", $config["groups"][$params["group"]]);
        $result = '<ul class="list-group">';
        foreach($a as $c) {
            $c = str_replace(" ", "", $c);
            $player_use_count = $database->selectCell("SELECT COUNT(*) FROM `{$config['mysql']['uses_table']}` WHERE `command` = {?} AND `username` = {?}", [$c, $params["username"]]);
            $config_count = $config["timeout"][$c];
            if(empty($config_count)) {
                $config_count = "∞";
            }
            $onClick = "setCommandVal('{$c}')";
            if(isset($config["commmands_with_arguments"][$c])) {
                $arg = explode(":", $config["commmands_with_arguments"][$c]);
                if($arg[0] == "{username}") {
                    $arg[0] = $params["username"];
                }
                $result .= '<li class="list-group-item d-flex justify-content-between align-items-center">
          /'.$c.' <small>Только с аргументом: "'.$arg[0].'"</small>
          <a href="#" onClick="'.$onClick.'" class="badge badge-primary badge-pill">Использовать ('.$player_use_count.'/'.$config_count.')</a>
        </li>';
            } else {
                $result .= '<li class="list-group-item d-flex justify-content-between align-items-center">
          /'.$c.'
          <a href="#" onClick="'.$onClick.'" class="badge badge-primary badge-pill">Использовать ('.$player_use_count.'/'.$config_count.')</a>
        </li>';
            }
        }
        $result .= '</ul>';
        die($result);
        break;
    default:
        unset($_SESSION['group']);
        unset($_SESSION['console']);
        die();
        break;
}

?>
