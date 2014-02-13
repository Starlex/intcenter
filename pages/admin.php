<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);

$result = '';
$error = array();
$allowed_mime = array('', 'image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif');
$allowed_ext = array('', 'png', 'jpg', 'jpeg', 'gif');
if(isset($_POST['sendPage'])){
	if('' === $_POST['page_id']){
		echo "<h3 class='req'>Вы не выбрали страницу для редактирования<h3>";
		exit;
	}

	$page_id = $_POST['page_id'];
	$content = $_POST['page_content'];
	try{
		$query = $db->prepare("UPDATE intcenter_pages SET content=? WHERE id=?");
		$query->execute(array($content, $page_id));
	}
	catch(PDOException $e){
		echo "<h3 class='req'>Редактирование страницы не удалось<h3>";
		exit;
	}			
	$result = "<h3>Редактирование страницы прошло успешно</h3>";
}
elseif(isset($_POST['sendNews'])){
	if('/admin/' === $_GET['page']){
		$isSummer = 0;
		if(isset($_POST['isSummer'])){
			$isSummer = 1;
			unset($_POST['isSummer']);
		}
		array_pop($_POST);
		if(!empty($_FILES)){
			array_pop($_FILES['image']);
			array_pop($_FILES['image']);
		}
		foreach(array_merge($_POST, $_FILES) as $item){
			if('' === $item){
				echo "<h3 class='req'>Вы не заполнили один или несколько пунктов</h3>";
				exit;
			}
		}
		$img = array(
					'name' => cyrillic2latin($_FILES['image']['name']),
					'tmp_name' => $_FILES['image']['tmp_name'],
					'ext' => strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) ),
					'mime' => strtolower($_FILES['image']['type']),
					'path' => 'img/news'
				);
		$path_to_img = $img['path'].'/'.time().'-'.$img['name'];

		if( !in_array($img['mime'], $allowed_mime) or !in_array($img['ext'], $allowed_ext) ){
			echo "<h3 class='req'>Данный тип файла запрещен к загрузке<h3>";
			exit;
		}
		if(!file_exists($img['path'])){
			echo "<h3 class='req'>Загрузка файла не удалась<h3>";
			exit;
		}
		if( !img_resize($img['tmp_name'], $path_to_img, 120, 90) ){
			echo "<h3 class='req'>Загрузка файла не удалась<h3>";
			exit;
		}
		try{
			$sql =  "INSERT INTO intcenter_news(img, date, name, annotation, content, isSummer) VALUES (?, ?, ?, ?, ?, ?)";
			$params = array('../'.$path_to_img, time(), $_POST['title'], $_POST['annotation'], $_POST['news_content'], $isSummer);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo "<h3 class='req'>Добавление новости не удалось<h3>";
			if('' !== $path_to_img){
				unlink($path_to_img);
			}
			exit;
		}
		$action = "Добавление";
	}
	elseif('/admin-update/' === $_GET['page']){
		if('' === $_POST['news_id']){
			echo "<h3 class='req'>Вы не выбрали новость для редактирования</h3>";
			exit;
		}
		$isSummer = 0;
		if(isset($_POST['isSummer'])){
			$isSummer = 1;
			unset($_POST['isSummer']);
		}
		try{
			$sql =  "SELECT img FROM intcenter_news WHERE id=?";
			$query = $db->prepare($sql);
			$query->execute(array($_POST['news_id']));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$old_path_to_img = str_replace('../', '', $row['img']);
		}
		catch(PDOException $e){
			echo "<h3 class='req'>Редактирование новости не удалось<h3>";
			exit;
		}
		if('' !== $_FILES['image']['name']){
			print_r($_FILES);
			$img = array(
						'name' => cyrillic2latin($_FILES['image']['name']),
						'tmp_name' => $_FILES['image']['tmp_name'],
						'ext' => strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) ),
						'mime' => strtolower($_FILES['image']['type']),
						'path' => 'img/news'
					);
			$path_to_img = $img['path'].'/'.time().'-'.$img['name'];

			if( !in_array($img['mime'], $allowed_mime) or !in_array($img['ext'], $allowed_ext) ){
				echo "<h3 class='req'>Данный тип файла запрещен к загрузке<h3>";
				exit;
			}
			if(!file_exists($img['path'])){
				echo "<h3 class='req'>Загрузка файла не удалась<h3>";
				exit;
			}
			if( !img_resize($img['tmp_name'], $path_to_img, 120, 90) ){
				echo "<h3 class='req'>Загрузка файла не удалась<h3>";
				exit;
			}
			else{
				if(file_exists($old_path_to_img)){
					unlink($old_path_to_img);
				}
			}
		}
		else{
			$path_to_img = $old_path_to_img;
		}
		try{
			$sql =  "UPDATE intcenter_news SET img=?, name=?, annotation=?, content=?, isSummer=? WHERE id=?";
			$params = array('../'.$path_to_img, $_POST['title'], $_POST['annotation'], $_POST['news_content'], $isSummer, $_POST['news_id']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			echo "<h3 class='req'>Редактирование новости не удалось<h3>";
			exit;
		}
		$action = "Редактирование";
	}
	elseif('/admin-delete/' === $_GET['page']){
		if('' === $_POST['news_id']){
			echo "<h3 class='req'>Вы не выбрали новость для удаления</h3>";
			exit;
		}
		try{
			$sql =  "SELECT img FROM intcenter_news WHERE id=?";
			$query = $db->prepare($sql);
			$query->execute(array($_POST['news_id']));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$old_path_to_img = str_replace('../', '', $row['img']);
		}
		catch(PDOException $e){
			echo "<h3 class='req'>Удаление новости не удалось<h3>";
			exit;
		}
		if(file_exists($old_path_to_img)){
			unlink($old_path_to_img);
		}
		try{
			$sql =  "DELETE FROM intcenter_news WHERE id=?";
			$params = array($_POST['news_id']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo "<h3 class='req'>Удаление новости не удалось<h3>";
			exit;
		}
		$action = "Удаление";
	}
	else{
		echo 'Что-то пошло не так';
		exit;
	}
	$result = "<h3>$action новости прошло успешно</h3>";
}
elseif(isset($_POST['sendProgram'])){
	if('/admin/' === $_GET['page']){
		array_pop($_POST);
		foreach ($_POST as $item) {
			if('' === $item){
				echo "<h3 class='req'>Вы не заполнили один или несколько пунктов</h3>";
				exit;
			}
		}
		try{
			$sql = "INSERT INTO intcenter_programs(cat_id, name, target_audience, content, link) VALUES (?, ?, ?, ?, ?)";
			$params = array($_POST['prog_cat_id'], $_POST['title'], $_POST['target_audience'], $_POST['program_content'], '/learn-language/#'.time());
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			echo "<h3 class='req'>Добввление программы обучения не удалось<h3>";
			exit;
		}
		$action = 'Добавление';
	}
	elseif('/admin-update/' === $_GET['page']){
		if('' === $_POST['program_id'] or '' === $_POST['prog_cat_id']){
			echo '<h3 class="req">Вы не заполнили один или несколько обязательных пунктов</h3>';
			exit;
		}
		try{
			$sql = "UPDATE intcenter_programs SET cat_id=?, name=?, target_audience=?, content=? WHERE id=?";
			$params = array($_POST['prog_cat_id'], $_POST['title'], $_POST['target_audience'], $_POST['program_content'], $_POST['program_id']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo '<h3 class="req">Редактирование программы обучения не удалось</h3>';
			exit;
		}
		$action = 'Редактирование';
	}
	elseif('/admin-delete/' === $_GET['page']){
		if('' === $_POST['program_id']){
			echo '<h3 class="req">Вы не выбрали программу обучения для удаления</h3>';
			exit;
		}
		try{
			$sql = "DELETE FROM intcenter_programs WHERE id=?";
			$query = $db->prepare($sql);
			$query->execute(array($_POST['program_id']));
		}
		catch(PDOException $e){
			echo '<h3 class="req">Удаление программы обучения не удалось</h3>';
			exit;
		}
		$action = 'Удаление';
	}
	else{
		echo '<h3 class="req">Что-то пошло не так</h3>';
		exit;
	}
	$result = "<h3>$action программы обучения прошло успешно</h3>";
}


switch($_GET['page']):
	case '/admin/':
		require_once 'pages/adminAdd.php';
		break;
	case '/admin-update/':
		require_once 'pages/adminUpdate.php';
		break;
	case '/admin-delete/':
		require_once 'pages/adminDelete.php';
		break;
endswitch;


/*elseif('/admin-update/' === $_GET['page']){
	if(isset($_POST['sendPage'])){
		$page_id = $_POST['page_id'];
		$content = $_POST['page_content'];

		if('' === $page_id){
			$error[] = "<h3 class='req'>Вы не выбрали страницу для редактирования<h3>";
		}
		else{
			$sql = "UPDATE intcenter_pages SET content=? WHERE id=?";
			try{
				$query = $db->prepare($sql);
				$query->execute(array($content, $page_id));
			}
			catch(PDOException $e){
				$error[] = "<h3 class='req'>Не удалось отредактировать страницу<h3>";
				echo $e->getMessage();
			}			
			$result = "<h3>Редактирование страницы прошло успешно</h3>";
		}
	}
	elseif(isset($_POST['sendNews'])){
		$news_id = $_POST['news_id'];
		$title = $_POST['title'];
		$annotation = $_POST['annotation'];
		$news_content = $_POST['news_content'];
		$img = array(
					'name' => $_FILES['image']['name'],
					'tmp_name' => $_FILES['image']['tmp_name'],
					'ext' => pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION),
					'mime' => $_FILES['image']['type'],
					'path' => 'img/news'
				);
		$name = $_FILES['image']['name'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$type = $_FILES['image']['type'];
	}
	require_once 'pages/adminUpdate.php';	
}*/
?>