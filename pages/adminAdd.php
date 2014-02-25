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
				<input type='radio' name='rbtn' id='addProgram'> Добавить программу обучения
			</label>
		</div>
		<div class="note">Поля, обозначенные <b class="req">*</b>, обязательны к заполнению.</div>

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

		<form class='hide' method='post' id='addPartnerForm' enctype='multipart/form-data'>
			<label>
				<span><b class="req">*</b>Выберите картинку с логотипом:</span>
				<input type="file" name="image">
			</label>
			<label>
				<span><b class="req">*</b>Название:</span>
				<input type="text" name="title">
			</label>
			<label>
				<span><b class="req">*</b>Расположение:</span>
				<input type="text" name="location">
			</label>
			<label>
				<span><b class="req">*</b>Адрес сайта:</span>
				<input type="text" name="site">
			</label>
			<div class='button_panel'>
				<input name='sendPartner' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addServiceForm' enctype='multipart/form-data'>
			<label>
				<span><b class="req">*</b>Название услуги:</span>
				<input type="text" name="title">
			</label>
			<label>
				<span><b class="req">*</b>Картинка:</span>
				<input type="file" name="image">
			</label>
			<label>
				<span><b class="req">*</b>Аннотация:</span>
				<textarea name="annotation" rows="5"></textarea>
			</label>
			<label>
				<span><b class="req">*</b>Основной контент услуги:</span>
				<textarea class="ckeditor" name="service_content" rows="20"></textarea>
			</label>
			<div class='button_panel'>
				<input name='sendService' type='submit' value='Добавить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='addProgramForm' enctype='multipart/form-data'>
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
				<span><b class="req">*</b>Картинка отображаемая в описании программы:</span>
				<input type="file" name="image">
			</label>
			<label>
				<span><b class="req">*</b>Целевая аудитория:</span>
				<input type="text" name="target_audience">
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