<?php
 
	$crud = new crud();

	$crud->dsn = "mysql:dbname={$config['dbname']};host=localhost;charset=utf8mb4;";
	$crud->username =  $config['username'];
	$crud->password = $config['password'];


	// $crud->rawQuery(" SET time_zone = 'UTC' ");


