		<?php
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		breadcrumbs($db, $url);
		?>
		<div class="container">
			<?php
			echo '<h2>'.getPageName($db, $_GET['page']).'</h2>';
			echo getPageContent($db, $_GET['page']);
			drawProgramsMenu($db, $drawProgMenu);
			?>
			<div class="content">
				
			</div>
		</div>