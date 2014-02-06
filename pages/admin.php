<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);

$result = '';
$error = array();
if('/admin/' === $_GET['page']){
	if(isset($_POST['sendNews'])){
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
					'ext' => end(explode('.',$_FILES['image']['name'])),
					'mime' => strtolower($_FILES['image']['type']),
					'path' => 'img/news'
				);
		$allowed_mime = array('', 'image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif');

		if(!in_array($img['mime'], $allowed_mime)){
			$error[] = "<h3 class='req'>Данный тип файла запрещен к загрузке<h3>";
		}
		else{
			if(!file_exists($img['path'])){
				$error[] = "<h3 class='req'>Загрузка файла не удалась<h3>";
			}
			else{
				$path_to_img = $img['path'].'/'.$date.'-'.cyrillic2latin($_FILES['image']['name']);
				if( !img_resize($img['tmp_name'], $path_to_img, 120, 90) ){
					$error[] = "<h3 class='req'>Загрузка файла не удалась<h3>";
				}
				else{
					try{
						$sql = "INSERT INTO intcenter_news(img, date, name, annotation, news_content)
								VALUES ('../$path_to_img', $date, '$_POST[name]', '$_POST[annotation]', '$_POST[news_content]')";
						$query = $db->prepare($sql);
						$query->execute();
					}
					catch(PDOException $e){
						$error[] = "<h3 class='req'>Не удалось добавить новость<h3>";
						if('' !== $path_to_img){
							unlink($path_to_img);
						}
					}
				}
			}
			$result = "<h3>Новость успешно добавлена</h3>";
		}
	}
	require_once 'pages/adminAdd.php';	
}
elseif('/admin-update/' === $_GET['page']){
	require_once 'pages/adminUpdate.php';	
}
?>