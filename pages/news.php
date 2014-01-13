<?php
$news_id = (int)$_GET['var1'];
try{
	$query = $db->prepare("SELECT * FROM intcenter_news WHERE id='$news_id'");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
}
catch(PDOException $e){
	$e->getMessage();
}
?>
<div class="container">
	<h2><?=$data['name'];?></h2>
	<span class="date"><?=date("d.m.Y", $data['date']);?></span>
	<span class="annotation"><?=$data['annotation'];?></span>
	<div class="news-content">
		<?=$data['news_content'];?>
	</div>
</div>