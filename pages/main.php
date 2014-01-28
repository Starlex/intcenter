
		<div class="container">
			<?php drawProgramsMenu($db, $dontDrawProgMenu);?>
			
			<div class="content">
				<?php
				$num = showNews($db);
				pagination($num, 4);
				?>
			</div>
		</div>
