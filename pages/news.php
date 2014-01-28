<?php
$news = explode('-', $_GET['page']);
try{
	$query = $db->prepare("SELECT * FROM intcenter_news WHERE date='$news[1]'");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
}
catch(PDOException $e){
	$e->getMessage();
}
?>

<div class="breadcrumbs">
	Главная > 13.01.2014
</div>

<div class="container">
	<?php drawProgramsMenu($db, $drawProgMenu)?>
	<div class="content">
		<h2><?=$data['name'];?></h2>
		<span class="date"><?=date("d.m.Y", $data['date']);?></span>
		<span class="annotation"><?=$data['annotation'];?></span>
		<div class="news-content">
			<?=$data['news_content'];?>
		</div>
	</div>
</div>