<?php

$config = require "config.php";
if($_SERVER['REQUEST_URI'] == '/create.php' or $_SERVER['REQUEST_URI'] == '/create'){
    die($config['hackerman_msg']);
}
require "database.php";

$database = new DataBase(
  $config["mysql"]["host"],
  $config["mysql"]["user"],
  $config["mysql"]["password"],
  $config["mysql"]["database"]
);

$database->query("CREATE TABLE IF NOT EXISTS `{$config['mysql']['uses_table']}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `command` text NOT NULL,
  `time` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

echo "Таблица успешно сгенерирована";

?>
