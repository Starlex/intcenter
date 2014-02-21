<div class="container">
	<?php
	echo '<h2>'.getPageName($db).'</h2>';

	try{
		$query = $db->prepare("SELECT * FROM intcenter_programs");
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	
	?>
</div>