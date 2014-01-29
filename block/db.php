<?php
$dbPrefix = 'intcenter_';
try{
	$db = new PDO('mysql:host=localhost;dbname=intcenter', 'mysql', 'mysql', array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('set names utf8');
}
catch(PDOException $e){
	header('Location: /error/');
}
?>