<div class="container">
	<div></div>
	<div class="serviceMenu">
		<div>
			<ul>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
			</ul>
		</div>
		<div>
			<ul>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
				<li>sa;ldkh;fgh</li>
			</ul>
		</div>
	</div>
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
	$numberShown = 6;
	$firstShown = $page*$numberShown+1;
	$counter = 0;
	foreach ($row as $service) {
		++$counter;
		if( $counter >= $firstShown and $counter < $firstShown+$numberShown ){
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
	pagination($num, $numberShown);
	?>
</div>