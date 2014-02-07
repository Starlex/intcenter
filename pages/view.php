		<div class="container">
			<?= '<h2>'.getPageName($db, $_GET['page']).'</h2>'; ?>
			<?= getPageContent($db, $_GET['page']); ?>
			<?php drawProgramsMenu($db, $drawProgMenu);?>
			<div class="content">
				
			</div>
		</div>