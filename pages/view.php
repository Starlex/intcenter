		<?php
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		breadcrumbs($db, $url);
		?>
		<div class="container">
			<?php
			if(true === $drawProgMenu){
				drawProgramsMenu($db, $drawProgMenu);
				?>
				<div class="content">
					<?php
					echo '<h2>'.getPageName($db).'</h2>';
					echo getPageContent($db);
					if('/summer-schools/' === $_GET['page']){
						$num = showNews($db, 1);
						pagination($num, 4);
					}
					?>
				</div>
				<?php
			}
			else{
				echo '<h2>'.getPageName($db, $_GET['page']).'</h2>';
				echo getPageContent($db, $_GET['page']);
			}
			?>
			
		</div>