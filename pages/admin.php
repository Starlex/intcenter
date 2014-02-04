<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);

if(isset($_POST['sendNews'])){
	array_pop($_POST);
	array_pop($_FILES['image']);
	array_pop($_FILES['image']);
	array_walk($_FILES, 'arrayCheck');
	array_walk($_POST, 'arrayCheck');
	$news = array(
				'name' => $_POST['name'],
				'annotation' => $_POST['annotation'],
				'content' => $_POST['news_content'],
				'date' => time()
			);
	$img = array(
				'name' => $_FILES['image']['name'],
				'tmp_name' => $_FILES['image']['tmp_name'],
				'mime' => $_FILES['image']['type'],
				'path' => 'img/news'
			);
	$allowed_mime = array('image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif');
	print_r($_POST);
	print_r($_FILES);

	if(!in_array($img['mime'], $allowed_mime)){
		// echo "<h3 class='req'>$error<h3>";
		exit;
	}
	try{
		// $query = $db->prepare("INSERT INTO ");
	}
	catch(PDOExpression $e){
		echo $e-getMessage();
	}
}

// echo getPageContent($db, $_GET['page']);
?>

<div class='container'>
	<fieldset>
		<legend>Форма добавления контента</legend>
		<div class='radio'>
			<label>
				<input type='radio' name='add' id='addNews'> Добавить новость
			</label>
			<label>
				<input type='radio' name='add' id='addPartner'> Добавить партнера
			</label>
			<label>
				<input type='radio' name='add' id='addService'> Добавить услугу
			</label>
			<label>
				<input type='radio' name='add' id='addEmployee'> Редактировать сотрудника
			</label>
		</div>

		<form class='hide' method='post' id='addNewsForm' enctype='multipart/form-data'>
			<label>
				<span><b class="req">*</b>Картинка:</span>
				<input type='file' name='image'>
			</label>
			<label>
				<span><b class="req">*</b>Название:</span>
				<textarea name='name'></textarea>
			</label>
			<label>
				<span><b class="req">*</b>Аннотация:</span>
				<textarea name='annotation' rows='5'></textarea>
			</label>
			<label>
				<span><b class="req">*</b>Основной текст новости:</span>
				<textarea class='ckeditor' name='news_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendNews' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' action='' method='post' id='addPartnerForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendPartner' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' action='' method='post' id='addServiceForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendService' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' action=' method='post' id='addEmployeeForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendEmployee' type='submit' value='Добавить' class='button'>
			</div>
		</form>
	</fieldset>
</div>