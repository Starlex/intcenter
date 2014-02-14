
		<div class="container">
			<?php drawProgramsMenu($db, $drawProgMenu);?>
			<div class="content">
				<?php
				$num = showNews($db);
				pagination(100, 4);
				?>
		</div>
	</div>
