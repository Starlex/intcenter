		<div class="container">
			<?php
			if(true === $drawProgMenu){
				drawProgramsMenu($db, $drawProgMenu);
				?>
				<div class="content">
					<?php
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
				echo getPageContent($db, $_GET['page']);
			}
			?>
			
		</div>