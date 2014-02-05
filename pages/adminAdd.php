<div class='container'>
	<fieldset>
		<legend>Форма добавления контента</legend>
		<?php
		if(!empty($error)){
			foreach ($error as $err) {
				echo $err;
			}
			exit;
		}
		else{
			echo $result;
		}
		?>
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

		<form class='hide' method='post' id='addPartnerForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendPartner' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addServiceForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendService' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addEmployeeForm'>
			<input type='text' name=' id='>
			<div class='button_panel'>
				<input name='sendEmployee' type='submit' value='Добавить' class='button'>
			</div>
		</form>
	</fieldset>
</div>