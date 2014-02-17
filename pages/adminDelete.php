		<div class='radio'>
			<label>
				<input type='radio' name='rbtn' id='deleteNews'> Удалить новость
			</label>
			<label>
				<input type='radio' name='rbtn' id='deletePartner'> Удалить партнера
			</label>
			<label>
				<input type='radio' name='rbtn' id='deleteService'> Удалить услугу
			</label>
			<label>
				<input type='radio' name='rbtn' id='deleteEmployee'> Удалить сотрудника
			</label>
			<label>
				<input type='radio' name='rbtn' id='deleteProgram'> Удалить программу обучения
			</label>
		</div>

		<form class='hide' method='post' id='deleteNewsForm' enctype='multipart/form-data'>
			<label>
				<span>Выберите новость:</span>
				<?php select($db, 'news'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendNews' type='submit' value='Удалить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='deleteProgramForm' enctype='multipart/form-data'>
			<label>
				<span>Выберите программу обучения:</span>
				<?php select($db, 'program'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendProgram' type='submit' value='Удалить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='deletePartnerForm'>
			<label>
				<span>Выберите партнера:</span>
				<?php select($db, 'partner'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendPartner' type='submit' value='Удалить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='deleteServiceForm'>
			<label>
				<span>Выберите услугу:</span>
				<?php select($db, 'service'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendService' type='submit' value='Удалить' class='button'>
			</div>
		</form>

		<form class='hide' method='post' id='deleteEmployeeForm'>
			<label>
				<span>Выберите работника:</span>
				<?php select($db, 'employee'); ?>
			</label>
			<div class='button_panel'>
				<input name='sendEmployee' type='submit' value='Удалить' class='button'>
			</div>
		</form>