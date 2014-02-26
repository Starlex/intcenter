<div class="container">
	<?php
	echo '<h2>Услуги центра</h2>';

	try{
		$sql = "SELECT * FROM intcenter_services";
		$query = $db->prepare($sql);
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$i = 0;
	foreach ($row as $service) {
		++$i;
		?>
		<div class="service">
			<span><a href="<?=$service['link'];?>"><?=$service['name'];?></a></span>
			<img src="<?=$service['img'];?>" alt="pic">
			<?=$service['annotation'];?>
		</div>
		<hr>
		<?php
	}
	?>
</div>