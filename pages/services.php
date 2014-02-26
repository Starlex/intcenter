<div class="container">
	<?php
	echo '<h2>Услуги центра</h2>';

	try{
		$sql = "SELECT COUNT(*) FROM intcenter_services";
		$query = $db->prepare($sql);
		$query->execute();
		$num = $query->fetchColumn();

		$sql = "SELECT * FROM intcenter_services";
		$query = $db->prepare($sql);
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$page = !isset($_GET['var1']) ? 0 : ( (int)$_GET['var1'] )-1;
	$firstShown = $page*6+1;
	$counter = 0;
	foreach ($row as $service) {
		++$counter;
		if( $counter >= $firstShown and $counter < $firstShown+6 ){
			?>
			<div class="service">
				<span><a href="<?=$service['link'];?>"><?=$service['name'];?></a></span>
				<img src="<?=$service['img'];?>" alt="pic">
				<?=$service['annotation'];?>
			</div>
			<hr>
			<?php
		}
	}
	pagination($num, 6);
	?>
</div>