<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'block/db.php';
require_once 'block/phpfunlib.php';
require_once 'block/header.php';
$drawProgMenu = true;

echo "<a href='/admin/'>Adminka</a>";
if(isset($_GET['page'])){
	if(0 === strpos($_GET['page'], '/admin')){
		session_start();
		require_once 'block/auth.php';
		require_once 'pages/admin.php';
	}
	elseif('/login/' === $_GET['page'] or '/logout/' === $_GET['page']){
		require_once 'pages/loginout.php';
	}
	elseif('/news/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/news.php';
		require_once 'block/bottom.php';

	}
	elseif('/error/' === $_GET['page']){
		require_once 'pages/error.php';
	}
	else{
		require_once 'block/top.php';
		require_once 'pages/main.php';
		require_once 'block/bottom.php';
	}
}
elseif(empty($_GET)){
	require_once 'block/top.php';
	require_once 'pages/main.php';
	require_once 'block/bottom.php';
}


require_once 'block/footer.php';
?>