		<?php
		breadcrumbs($db);
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
					echo '<div style="height:20px"></div>';
					if('/summer-schools/' === $_GET['page']){
						showNews($db, 1);
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