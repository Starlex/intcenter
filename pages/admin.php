<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);

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
	$action = 'Редактирование';
	$type = 'страницы';
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
		$path_to_img = fileUpload($_FILES['image'], 'news', 120, 90);
		if(!$path_to_img){
			exit;
		}
		try{
			$sql =  "INSERT INTO intcenter_news(img, date, name, annotation, content, isSummer) VALUES (?, ?, ?, ?, ?, ?)";
			$params = array('../../'.$path_to_img, time(), $_POST['title'], $_POST['annotation'], $_POST['news_content'], $isSummer);
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
		$path_to_img = '';
		$old_path_to_img = '';
		$isSummer = 0;
		if(isset($_POST['isSummer'])){
			$isSummer = 1;
			unset($_POST['isSummer']);
		}
		$old_path_to_img = str_replace('../../', '', $_POST['img']);
		if('' !== $_FILES['image']['name']){
			$path_to_img = fileUpload($_FILES['image'], 'news', 120, 90);
			if(!$path_to_img){
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
			$params = array('../../'.$path_to_img, $_POST['title'], $_POST['annotation'], $_POST['news_content'], $isSummer, $_POST['news_id']);
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
			$old_path_to_img = str_replace('../../', '', $row['img']);
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
	$type = 'новости';
}
elseif(isset($_POST['sendProgram'])){
	if('/admin/' === $_GET['page']){
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
		$target_audience = mb_strtolower($_POST['target_audience'], "UTF-8");
		$path_to_img = fileUpload($_FILES['image'], 'programs', 200, 150);
		if(!$path_to_img){
			exit;
		}
		try{
			$sql = "INSERT INTO intcenter_programs(img, cat_id, name, target_audience, content, link) VALUES (?, ?, ?, ?, ?, ?)";
			$params = array('../../'.$path_to_img, $_POST['prog_cat_id'], $_POST['title'], $target_audience, $_POST['program_content'], '/learn-language/#'.time());
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			echo "<h3 class='req'>Добавление программы обучения не удалось<h3>";
			if('' !== $path_to_img){
				unlink($path_to_img);
			}
			exit;
		}
		$action = 'Добавление';
	}
	elseif('/admin-update/' === $_GET['page']){
		if('' === $_POST['program_id'] or '' === $_POST['prog_cat_id']){
			echo '<h3 class="req">Вы не заполнили один или несколько обязательных пунктов</h3>';
			exit;
		}
		$target_audience = mb_strtolower($_POST['target_audience'], "UTF-8");
		$path_to_img = '';
		$old_path_to_img = '';
		$old_path_to_img = str_replace('../../', '', $_POST['img']);
		if('' !== $_FILES['image']['name']){
			$path_to_img = fileUpload($_FILES['image'], 'programs', 200, 150);
			if(!$path_to_img){
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
			$sql = "UPDATE intcenter_programs SET img=?, cat_id=?, name=?, target_audience=?, content=? WHERE id=?";
			$params = array('../../'.$path_to_img, $_POST['prog_cat_id'], $_POST['title'], $target_audience, $_POST['program_content'], $_POST['program_id']);
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
			$sql =  "SELECT img FROM intcenter_programs WHERE id=?";
			$query = $db->prepare($sql);
			$query->execute(array($_POST['program_id']));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$old_path_to_img = str_replace('../../', '', $row['img']);
		}
		catch(PDOException $e){
			echo "<h3 class='req'>Удаление программы не удалось<h3>";
			exit;
		}
		if(file_exists($old_path_to_img)){
			unlink($old_path_to_img);
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
	$type = 'программы обучения';
}
elseif(isset($_POST['sendPartner'])){
	if('/admin/' === $_GET['page']){
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
		$path_to_img = fileUpload($_FILES['image'], 'partners', 200, 130);
		if(!$path_to_img){
			exit;
		}
		$site = preg_replace('/((http|https)\:\/\/)/', '', $_POST['site']);
		try{
			$sql = "INSERT INTO intcenter_partners(img, name, location, site) VALUES (?,?,?,?)";
			$params = array('../../'.$path_to_img, $_POST['title'], $_POST['location'], $site);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			echo "<h3 class='req'>Добавление партнера не удалось</h3>";
			exit;
		}
		$action = 'Добавление';
	}
	elseif('/admin-update/' === $_GET['page']){
		if( '' === $_POST['partner_id'] ){
			echo '<h3 class="req">Вы не выбрали партнера для редактирования</h2>';
			exit;
		}
		$old_path_to_img = str_replace('../../', '', $_POST['img']);
		if('' !== $_FILES['image']['name']){
			$path_to_img = fileUpload($_FILES['image'], 'partners', 200, 130);
			if(!$path_to_img){
				exit;
			}
			else{
				if(file_exists($old_path_to_img)){
					unlink($old_path_to_img);
				}
			}
		}
		try{
			$sql = "UPDATE intcenter_partners SET img=?, name=?, location=?, site=? WHERE id=?";
			$params = array('../../'.$path_to_img, $_POST['title'], $_POST['location'], $_POST['site'], $_POST['partner_id']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo '<h3 class="req">Редактирование партнера не удалось</h3>';
			exit;
		}
		$action = 'Редактирование';
	}
	elseif('/admin-delete/' === $_GET['page']){
		if('' === $_POST['partner_id']){
			echo '<h3 class="req">Вы не выбрали партнера для удаления</h3>';
			exit;
		}
		try{
			$query = $db->prepare("SELECT img FROM intcenter_partners WHERE id=?");
			$query->execute(array($_POST['partner_id']));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$path_to_img = str_replace('../../', '', $row['img']);

			$query = $db->prepare("DELETE FROM intcenter_partners WHERE id=?");
			$query->execute(array($_POST['partner_id']));

		}
		catch(PDOException $e){
			echo '<h3 class="req">Удаление партнера не удалось</h3>';
			exit;
		}
		if( file_exists($path_to_img) ){
			unlink($path_to_img);
		}
		$action = 'Удаление';
	}
	$type = 'партнера';
}
elseif(isset($_POST['sendService'])){
	if('/admin/' === $_GET['page']){
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
		$path_to_img = fileUpload($_FILES['image'], 'services', 200, 150);
		if(!$path_to_img){
			exit;
		}
		try{
			$sql = "INSERT INTO intcenter_services(img, link, name, annotation, content) VALUES (?,?,?,?)";
			$params = array('../../'.$path_to_img, time().'/', $_POST['title'], $_POST['annotation'], $_POST['service_content']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			echo "<h3 class='req'>Добавление услуги не удалось</h3>";
			exit;
		}
		$action = 'Добавление';
	}
	elseif('/admin-update/' === $_GET['page']){
		if( '' === $_POST['service_id'] ){
			echo '<h3 class="req">Вы не выбрали услугу для редактирования</h2>';
			exit;
		}
		$old_path_to_img = str_replace('../../', '', $_POST['img']);
		if('' !== $_FILES['image']['name']){
			$path_to_img = fileUpload($_FILES['image'], 'services', 200, 150);
			if(!$path_to_img){
				exit;
			}
			else{
				if(file_exists($old_path_to_img)){
					unlink($old_path_to_img);
				}
			}
		}
		try{
			$sql = "UPDATE intcenter_services SET img=?, name=?, annotation=?, content=? WHERE id=?";
			$params = array('../../'.$path_to_img, $_POST['title'], $_POST['annotation'], $_POST['service_content'], $_POST['service_id']);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(PDOException $e){
			echo '<h3 class="req">Редактирование услуги не удалось</h3>';
			exit;
		}
		$action = 'Редактирование';
	}
	elseif('/admin-delete/' === $_GET['page']){
		if( '' === $_POST['service_id'] ){
			echo '<h3 class="req">Вы не выбрали услугу для удаления</h2>';
			exit;
		}
		try{
			$query = $db->prepare("SELECT img FROM intcenter_services WHERE id=?");
			$query->execute(array($_POST['service_id']));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$path_to_img = str_replace('../../', '', $row['img']);

			$query = $db->prepare("DELETE FROM intcenter_services WHERE id=?");
			$query->execute(array($_POST['service_id']));

		}
		catch(PDOException $e){
			echo '<h3 class="req">Удаление услуги не удалось</h3>';
			exit;
		}
		if( file_exists($path_to_img) ){
			unlink($path_to_img);
		}
		$action = 'Удаление';
	}
	$type = 'услуги';
}
?>

<div class='container'>
	<fieldset>
		<legend><?=getPageName($db);?> контент</legend>
		<?php
		if( isset($action) and isset($type) ){
			echo "<h3>$action $type прошло успешно</h3>";
			exit;
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
?>
	</fieldset>