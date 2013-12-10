<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'block/db.php';
require_once 'block/phpfunlib.php';
require_once 'block/header.php';

require_once 'block/top.php';

if(isset($_GET['page'])){
	if(0 === strpos($_GET['page'], '/admin')){
		session_start();
		require_once 'block/auth.php';
		require_once 'pages/admin.php';
	}
	elseif('/login/' === $_GET['page'] or '/logout/' === $_GET['page']){
		require_once 'pages/loginout.php';
	}
	else{
		require_once 'pages/main.php';
	}
}
elseif(empty($_GET)){
	require_once 'pages/main.php';
}

// echo "<a href='/admin/'>Adminka</a>";

require_once 'block/bottom.php';
require_once 'block/footer.php';
?>