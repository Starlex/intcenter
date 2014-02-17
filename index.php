<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'block/db.php';
require_once 'block/phpfunlib.php';
require_once 'block/header.php';

if(isset($_GET['page'])){
	try{
		$query = $db->prepare("SELECT drawProgMenu FROM intcenter_pages WHERE link=?");
		$query->execute(array($_GET['page']));
		$row = $query->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		echo '<h2 class="req">Ошибка подключения к базе данных</h2>';
	}
	$drawProgMenu = (bool)$row['drawProgMenu'];
}
else{
	$drawProgMenu = true;
}


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
	elseif( '/news/' === $_GET['page'] or ('/summer-schools/' === $_GET['page']) and isset($_GET['var1']) ){
		require_once 'block/top.php';
		require_once 'pages/news.php';
		require_once 'block/bottom.php';
	}
	elseif('/partners/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/partners.php';
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