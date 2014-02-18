<?php
try{
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
	echo '<h2>'.getPageName($db).'</h2>';
	foreach ($row as $partner) {
		echo "<div class='partner'>
			<img src='$partner[img]' alt='pic'>
			<div>
				$partner[name]
				<p>$partner[location]</p>
				<a href='http://$partner[site]'>$partner[site]</a>
			</div>
		</div>";
	}
	// pagination($num, 6);
	?>
</div>