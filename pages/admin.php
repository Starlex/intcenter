<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);

if(isset($_POST['sendNews'])){
	$error = array();
	array_pop($_POST);
	array_pop($_FILES['image']);
	array_pop($_FILES['image']);
	foreach(array_merge($_POST, $_FILES) as $item){
		if('' === $item){
			$error[] = "<h3 class='req'>Вы не заполнили один или несколько пунктов</h3>";
			break;
		}
	}
	$date = time();
	$img = array(
				'name' => cyrillic2latin($_FILES['image']['name']),
				'tmp_name' => $_FILES['image']['tmp_name'],
				'mime' => strtolower($_FILES['image']['type']),
				'path' => 'img/news'.cyrillic2latin($_FILES['image']['name'])
			);
	$allowed_mime = array('', 'image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif');

	if(!in_array($img['mime'], $allowed_mime)){
		$error[] = "<h3 class='req'>Данный тип файла запрещен к загрузке<h3>";
	}
	else{
		if(!move_uploaded_file($img['tmp_name'], $img['patn'])){
			$error[] = "<h3 class='req'>Загрузка файла не удалась<h3>";
		}
		else{
			try{
				/*$sql = "INSERT INTO intcenter_news(img, date, name, annotation, news_content)
						VALUES $img[path], $date, $_POST[name], $_POST[annotation], $_POST[news_content]";
				$query = $db->prepare($sql);*/
			}
			catch(PDOExpression $e){
				echo $e-getMessage();
			}
		}
	}
}

require_once 'pages/adminAdd.php';
?>