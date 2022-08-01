<?php 
	define('DbHost', 'localhost');
	define('DbName', 'cn_game');
    define('DbUser', 'root');
    define('DbPass', '');
    define('MAIN_URL', 'http://localhost/cn_game/');  
    define('ADMIN_URL', 'http://localhost/cn_game/admin/');
	define('API_URL', 'http://localhost/cn_game/admin/API');
    define('Email_add', 'info@localhost.com');
    define('Project', 'Mokia club');
	define('CURRENCY', '₹');
	$conns=mysqli_connect(DbHost,DbUser,DbPass,DbName) or die('Could not connect');
?>