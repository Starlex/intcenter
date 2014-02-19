<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'block/db.php';
require_once 'block/phpfunlib.php';
require_once 'block/header.php';

try{
	$query = $db->prepare("SELECT link FROM intcenter_pages WHERE isEditable=1");
	$query->execute();
	$row = $query->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	header('Location: /error/');
}
$editablePages = array();
foreach ($row as $page) {
	$editablePages[] = $page['link'];
}

if(isset($_GET['page'])){
	try{
		$query = $db->prepare("SELECT drawProgMenu FROM intcenter_pages WHERE link=?");
		$query->execute(array($_GET['page']));
		$row = $query->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$drawProgMenu = $row ? (bool)$row['drawProgMenu'] : true;
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
	elseif( '/news/' === $_GET['page'] or '/news-of-summer-schools/' === $_GET['page'] ){
		require_once 'block/top.php';
		require_once 'pages/news.php';
		require_once 'block/bottom.php';
	}
	elseif('/partners/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/partners.php';
		require_once 'block/bottom.php';
	}
	elseif('/learn-language/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/programs.php';
		require_once 'block/bottom.php';
	}
	elseif('/our-team/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/employees.php';
		require_once 'block/bottom.php';
	}
	elseif('/services/' === $_GET['page']){
		require_once 'block/top.php';
		require_once 'pages/services.php';
		require_once 'block/bottom.php';
	}
	elseif( in_array($_GET['page'], $editablePages) ){
		require_once 'block/top.php';
		require_once 'pages/view.php';
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