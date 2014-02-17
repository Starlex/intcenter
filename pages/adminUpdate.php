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
			<label>
				<input type='radio' name='rbtn' id='updateProgram'> Редактировать программу обучения
			</label>
		</div>
		<div class="note">Поля, обозначенные <b class="req">*</b>, обязательны к заполнению.</div>
		<form class='hide' method='post' id='updatePageForm'>
			<label>
				<span><b class="req">*</b>Выберите страницу:</span>
				<?php select($db, 'page'); ?>
			</label>
			<label>
				<span>Основной текст страницы:</span>
				<textarea class='ckeditor' name='page_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendPage' type='submit' value='Редактировать' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='updateNewsForm' enctype='multipart/form-data'>
			<label>
				<span><b class="req">*</b>Выберите новость:</span>
				<?php select($db, 'news'); ?>
			</label>
			<label>
				<span>Картинка:</span>
				<input type='file' name='image'>
			</label>
			<label class="iblock">
				<input type="checkbox" name="isSummer"> Новость для летних и зимних языковых школ
			</label>
			<label>
				<span>Название:</span>
				<textarea name='title'></textarea>
			</label>
			<label>
				<span>Аннотация:</span>
				<textarea name='annotation' rows='5'></textarea>
			</label>
			<label>
				<span>Основной текст новости:</span>
				<textarea class='ckeditor' name='news_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendNews' type='submit' value='Редактировать' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='updateProgramForm'>
			<label>
				<span><b class="req">*</b>Выберите программу:</span>
				<?php select($db, 'program'); ?>
			</label>
			<label>
				<span><b class="req">*</b>Язык и категория:</span>
				<?php
				try{
					$query = $db->prepare("SELECT * FROM intcenter_prog_categories");
					$query->execute();
					$row = $query->fetchAll(PDO::FETCH_ASSOC);
				}
				catch(PDOException $e){
					header('Location: /error/');
				}
				echo "<select name='prog_cat_id'>";
				echo"\n\t\t\t\t\t<option value=''> - - - - - - - не выбрано - - - - - - - </option>";
				foreach ($row as $option) {
					echo"\n\t\t\t\t\t<option value='$option[id]'>$option[language] - - > $option[category]</option>";
				}
				echo "\n\t\t\t\t</select>\n";
				?>
			</label>
			<label>
				<span>Целевая аудитория:</span>
				<input type="text" name="target_audience">
			</label>
			<label>
				<span>Название:</span>
				<textarea name='title'></textarea>
			</label>
			<label>
				<span>Содержание прораммы:</span>
				<textarea class='ckeditor' name='program_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendProgram' type='submit' value='Редактировать' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='updatePartnerForm'>
			<label>
				<span>Выберите партнера:</span>
				<?php select($db, 'partner'); ?>
			</label>
			<label>
				<span><b class="req">*</b>Выберите картинку с логотипом:</span>
				<input type="file" name="image">
			</label>
			<label>
				<span><b class="req">*</b>Название:</span>
				<input type="text" name="site">
			</label>
			<label>
				<span><b class="req">*</b>Расположение:</span>
				<input type="text" name="site">
			</label>
			<label>
				<span><b class="req">*</b>Адрес сайта:</span>
				<input type="text" name="site">
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