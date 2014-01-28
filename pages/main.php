
		<div class="container">
			<?php drawProgramsMenu($db, $drawProgMenu);?>
			<div class="content">
				<?php
				$num = showNews($db);
				pagination($num, 4);
				?>
			</div>
		</div>
