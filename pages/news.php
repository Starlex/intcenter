<?php
$news = explode('-', $_GET['page']);
try{
	$query = $db->prepare("SELECT * FROM intcenter_news WHERE date='$news[1]'");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
}
catch(PDOException $e){
	header('Location: /error/');
}
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$crumbs = explode('/', $url);
$count = count($crumbs)-1;

echo '<div class="breadcrumbs">';

for ($i=0; $i < $count; $i++) { 
	if(0 === $i){
		echo '<a href="/">Главная</a> ';
		echo '<span>&gt;</span>';
	}
	elseif($count-1 === $i){
		echo date("d.m.Y", $data['date']);
	}
	else{
		echo $crumbs[$i];
		echo '<span>&gt;</span>';
	}
}

echo '</div>';
?>

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