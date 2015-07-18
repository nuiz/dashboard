<?php
return [
	"dsn"=> 'mysql:host=localhost;dbname=dashboard',
	"username"=> "root",
	"password"=> "",
	"option"=> [
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
	]
];