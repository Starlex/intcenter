<?php
try{
	$query = $db->prepare("SELECT COUNT(*) FROM intcenter_partners");
	$query->execute();
	$num = $query->fetchColumn();

	$query = $db->prepare("SELECT * FROM intcenter_partners");
	$query->execute();
	$row = $query->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	header('Location: /error/');
}

?>
<div class="container">
	<?php
	$pageNum = !isset($_GET['var1']) ? 0 : str_replace('/', '', $_GET['var1'])-1;
	$numberShown = 6;
	$firstShown = $pageNum*$numberShown+1;
	$counter = 0;
	echo '<h2>'.getPageName($db).'</h2>';
	foreach ($row as $partner) {
		++$counter;
		if($partnerCounter >= $firstShown and $partnerCounter < $firstShown+$numberShown){
			echo "<div class='partner'>
				<img src='$partner[img]' alt='pic'>
				<div>
					$partner[name]
					<p>$partner[location]</p>
					<a href='http://$partner[site]' target='_blank'>$partner[site]</a>
				</div>
			</div>";
		}
	}
	pagination($num, $numberShown);
	?>
</div>