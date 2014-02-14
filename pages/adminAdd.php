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
			if(isset($action)){
				echo $result;
				exit;
			}
		}
		?>
		<div class='radio'>
			<label>
				<input type='radio' name='rbtn' id='addNews'> Добавить новость
			</label>
			<label>
				<input type='radio' name='rbtn' id='addPartner'> Добавить партнера
			</label>
			<label>
				<input type='radio' name='rbtn' id='addService'> Добавить услугу
			</label>
			<label>
				<input type='radio' name='rbtn' id='addEmployee'> Добавить сотрудника
			</label>
			<label>
				<input type='radio' name='rbtn' id='addProgram'> Добавить программу обучения
			</label>
		</div>

		<form class='hide' method='post' id='addNewsForm' enctype='multipart/form-data'>
			<label>
				<span><b class="req">*</b>Картинка:</span>
				<input type='file' name='image'>
			</label>
			<label class="iblock">
				<input type="checkbox" name="isSummer"> Новость для летних и зимних языковых школ
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
				<input name='sendNews' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addProgramForm'>
			<label>
				<span><b class="req">*</b>Выберите язык и категорию:</span>
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
				<span><b class="req">*</b>Целевая аудитория:</span>
				<textarea name='target_audience' rows='1'></textarea>
			</label>
			<label>
				<span><b class="req">*</b>Название:</span>
				<textarea name='title'></textarea>
			</label>
			<label>
				<span><b class="req">*</b>Содержание прораммы:</span>
				<textarea class='ckeditor' name='program_content' rows='20'></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendProgram' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addPartnerForm'>
			<label>
				<span><b class="req">*</b>Выберите картинку с логотипом партнера:</span>
				<input type="file" name="image">
			</label>
			<label>
				<span><b class="req">*</b>Название партнера:</span>
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