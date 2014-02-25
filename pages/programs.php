<div class="container">
	<?php
	echo '<h2>Программы</h2>';

	try{
		$sql = "SELECT * 
						FROM intcenter_programs p 
						LEFT JOIN intcenter_prog_categories pc
						ON p.cat_id=pc.id";
		$query = $db->prepare($sql);
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$i = 0;
	foreach ($row as $program) {
		++$i;
		$date = substr($program['link'], 17);
		$prog_name = $i.'. '.$program['language'].' '.$program['target_audience'].' "'.$program['name'].'"';
		?>
		<div class="program">
			<span id="<?=$date;?>"><?=$prog_name;?></span>
			<img src="<?=$program['img'];?>" alt="pic">
			<?=$program['content'];?>
		</div>
		<hr>
		<?php
	}
	?>
</div>