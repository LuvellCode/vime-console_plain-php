<?php


/*
 * ReCreated by Hito (vk.com/igordux)
 * Version: 2.0.1
 * UPD: VimeMC Login/Permission system
 * UPD: SESSIONS(deleted cookies)
 * UPD: Protection
 * 12.05.2019
 *
 *
*/

return array(
    "enabled"                 => true, // Доступно для пользователей (true - да, false - нет)
    'auth_log'                => true, // Логирование попыток входа
    "mysql" => array(         //Для хранения кулдауна команд пользователей
        "host"                => "localhost",
        "user"                => "root",
        "password"            => "",
        "database"            => "consolesurv",
        "uses_table"          => "uses",   //REQUIRES 'id', 'username', 'command', 'time'
    ),
    "rcon" => array(          //Ркон-данные
        "host"                => "localhost",
        "port"                => 3321,
        "password"            => "",
        "timeout"             => 3 // Время ожидания (по default - 3)
    ),
    //lowercase groups
    "groups" => array(        //Комманды для привилегий, БЕЗ ПРОБЕЛОВ
                              //чтобы ставить без задержек МЕНЯЙТЕ КОМАНДЫ
        "console"             => "list,gamemode,clear,broadcast,tp,kick,pl,fly,give,me,tempban,tempmute",
        "staff"               => "list,gamemode,clear,broadcast,tpo,kick,warn,fly,eco,clearchat,give,me,deop,ban,mute,ipban,user, group,minecraft:op"
    ),
    "timeout" => array(       //Максимальное кол-во использований за день
        "gamemode"            => 3,
        "kick"                => 3,
        "fly"                 => 3,
        "broadcast"           => 3,
        "eco"                 => 3,
        "warn"                => 3,
        "tempban"             => 1,
        "tempmute"            => 1,
        "clearchat"           => 1,
        "me"                  => 4
    ),
    "commmands_with_arguments"=> array(
        /*
          Цифра после ":" обознает положение аргумента
          (считать от 1, 0 - сама команда)
          Можно использовать параметр {username} - ник пользователя
        */
        "eco"                 => "{username}:2",
        "clear"               => "{username}:1",
        "give"                => "{username}:1"
    ),

    //Дальше подключение ауза и пермов
    "authme" => array(        //ДБ с аузом
        'host'                => 'localhost',
        'user'                => 'root',
        'password'            => '',
        'database'            => 'authme',  //название дб

        'table_name'          => 'authme',  //название таблицы с юзерами
        'username_col'        => 'username',//название колонки с никами
        'password_col'        => 'password',//колонка с паролями
    ),

    "perms" => array(         //ДБ с пермами
        'host'                => 'localhost',
        'user'                => 'root',
        'password'            => '',
        'database'            => 'perms',

        'user_data_table'     => 'permissionsex',//Таблица с пользователями
        'user_data_col'       => 'data',         //колонка с данными
        'user_name'           => 'name',         //часть JSON'a с данными о нике игрока
        'user_group'          => 'userGroup'     //часть JSON'a с данными о группе игрока
    ),

    "error" => array(         //Ошибки входа
        'disabled'            => 'Выключено администрацией',
        'empty_fields'        => 'Заполните все поля!',
        'wrong_password'      => 'Неверный пароль!',
        'user_not_found'      => 'Пользователь не найден!',
        'no_permissions'      => 'У Вас нет прав для входа в консоль!',
    ),

    //При попытках нелегитного входа die(сообщение)
    "hackerman_msg"           => 'Мамкин хакер',

);
?>
