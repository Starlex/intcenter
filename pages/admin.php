<h1 class='center'><?=getPageName($db);?></h1>
<?php
drawVerticalMenu($db, 1);
?>

<div class="container">
	<fieldset>
		<legend>Форма добавления контента</legend>
		<label>
			<input type="radio" name="add" id="addNews"> Добавить новость
		</label>
		<label>
			<input type="radio" name="add" id="addPartner"> Добавить партнера
		</label>
		<label>
			<input type="radio" name="add" id="addService"> Добавить услугу
		</label>
		<label>
			<input type="radio" name="add" id="addEmployee"> Добавить сотрудника
		</label>

		<form class="hide" action="" method="post" id='addNewsForm'>
			<input type="text" name="" id="">
			<div class="button_panel">
				<input name="sendNews" type="submit" value="Добавить" class="button">
			</div>
		</form>
		<form class="hide" action="" method="post" id='addPartnerForm'>
			<input type="text" name="" id="">
			<div class="button_panel">
				<input name="sendPartner" type="submit" value="Добавить" class="button">
			</div>
		</form>
		<form class="hide" action="" method="post" id='addServiceForm'>
			<input type="text" name="" id="">
			<div class="button_panel">
				<input name="sendService" type="submit" value="Добавить" class="button">
			</div>
		</form>
		<form class="hide" action="" method="post" id='addEmployeeForm'>
			<input type="text" name="" id="">
			<div class="button_panel">
				<input name="sendEmployee" type="submit" value="Добавить" class="button">
			</div>
		</form>
	</fieldset>
</div>