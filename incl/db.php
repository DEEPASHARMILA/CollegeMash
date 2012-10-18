<?php
/********************************************************
DB Connection

Establish a connection to the database.
********************************************************/
define('MYSQL_HOST','localhost');
define('MYSQL_USER','thezuck');
define('MYSQL_PASSWORD','password');
define('MYSQL_DB','collegemash');

	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die ('Our hamsters that power the servers seem to be taking a break.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>