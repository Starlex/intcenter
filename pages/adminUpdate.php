<div class='container'>
	<fieldset>
		<legend>Форма редактирования контента</legend>
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
				<input type='radio' name='rbtn' id='updatePage'> Редактировать страницу
			</label>
			<label>
				<input type='radio' name='rbtn' id='updateNews'> Редактировать новость
			</label>
			<label>
				<input type='radio' name='rbtn' id='updatePartner'> Редактировать партнера
			</label>
			<label>
				<input type='radio' name='rbtn' id='updateService'> Редактировать услугу
			</label>
			<label>
				<input type='radio' name='rbtn' id='updateEmployee'> Редактировать сотрудника
			</label>
		</div>
		
		<form class='hide' method='post' id='updatePageForm'>
			<label>
				<span>Выберите страницу:</span>
				<?php select($db, 'page'); ?>
			</label>
			<label>
				<span><b class="req">*</b>Основной текст страницы:</span>
				<textarea class='ckeditor' name='page_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendPage' type='submit' value='Редактировать' class='button' disabled>
			</div>
		</form>

		<form class='hide' method='post' id='updateNewsForm' enctype='multipart/form-data'>
			<label>
				<span>Выберите новость:</span>
				<?php select($db, 'news'); ?>
			</label>
			<label>
				<span>Картинка:</span>
				<input type='file' name='image'>
			</label>
			<label>
				<span><b class="req">*</b>Название:</span>
				<textarea name='title'></textarea>
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
				<input name='sendNews' type='submit' value='Редактировать' class='button' disabled>
			</div>
		</form>

		<form class='hide' method='post' id='updatePartnerForm'>
			<label>
				<span>Выберите партнера:</span>
				<?php select($db, 'partner'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendPartner' type='submit' value='Редактировать' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='updateServiceForm'>
			<label>
				<span>Выберите услугу:</span>
				<?php select($db, 'service'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendService' type='submit' value='Редактировать' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='updateEmployeeForm'>
			<label>
				<span>Выберите работника:</span>
				<?php select($db, 'employee'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendEmployee' type='submit' value='Редактировать' class='button'>
			</div>
		</form>
	</fieldset>
</div>