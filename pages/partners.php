<?php
try{
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
	echo '<h2>'.getPageName($db).'</h2>';
	foreach ($row as $partner) {
		echo '<div class="partner">';
		echo '<img src="'.$partner['img'].'" alt="pic">';
		echo $partner['name'];
		echo $partner['location'];
		echo '<a href="http://'.$partner['site'].'">'.$partner['site'].'</a>';
		echo '</div>';
	}
	// print_r($row);
	?>
</div>