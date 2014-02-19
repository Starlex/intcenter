<?php
$date = (int)$_GET['var1'];
try{
	$query = $db->prepare("SELECT * FROM intcenter_news WHERE date=?");
	$query->execute(array($date));
	$data = $query->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	header('Location: /error/');
}
?>

<div class="container">
	<?php drawProgramsMenu($db, $drawProgMenu)?>
	<div class="content">
		<h2><?=$data['name'];?></h2>
		<span class="date"><?=date("d.m.Y", $data['date']);?></span>
		<span class="annotation"><?=$data['annotation'];?></span>
		<div class="news-content">
			<?=$data['content'];?>
		</div>
	</div>
</div>