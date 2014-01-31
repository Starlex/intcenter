<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);
?>

<div class="container">
	<fieldset>
		<legend>Форма добавления контента</legend>
		<form name='addForm' action="" method='post'>
			<label>
				<input type="radio" name="add" id="addNews">Добавить новость
			</label>
			<label>
				<input type="radio" name="add" id="addPartner">Добавить партнера
			</label>
			<label>
				<input type="radio" name="add" id="addService">Добавить услугу
			</label>
			<label>
				<input type="radio" name="add" id="addEmployee">Добавить сотрудника
			</label>

			<div class="hide" id="addNewsForm">
				asdfasdf
			</div>

			<div class="button_panel">
				<input type="submit" value="Добавить" class="button">
				<input type="reset" value="Очистить поля" class="button">
			</div>
		</form>
	</fieldset>
</div>