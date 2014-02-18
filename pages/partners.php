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

breadcrumbs($db);
?>
<div class="container">
	<?php
	$pageNum = !isset($_GET['vari']) ? 0 : str_replace('/', '', $_GET['var1']);
	$startNumPartner = $pageNum*6+1;
	$partnerCounter = 0;
	echo '<h2>'.getPageName($db).'</h2>';
	foreach ($row as $partner) {
		++$partnerCounter;
		if($partnerCounter){}
		echo "<div class='partner'>
			<img src='../$partner[img]' alt='pic'>
			<div>
				$partner[name]
				<p>$partner[location]</p>
				<a href='http://$partner[site]' target='_blank'>$partner[site]</a>
			</div>
		</div>";
	}
	// echo $partnerCounter;
	pagination($num, 6);
	?>
</div>