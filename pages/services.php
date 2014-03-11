<div class="container">
	<h2>Услуги центра</h2>
	<p class="menuName">Программы обучения по английскому языку</p>
	<div class="serviceMenu">
		<ul>
			<li>
				<a href="../../learn-language/">Программа изучения английского языка для школьников 9-11 классы <span>(Подготовка к ЕГЭ)</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Программа изучения английского языка для школьников 6-8 классы <span>"Funny conversational English/English for kids" Веселый разговорный английский</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Программа изучения английского языка для студентов НВГУ <span>"Intensive English Language Course"</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Программа изучения английского языка <span>"Business English for Career Purposes" совместно с Кингстонским Университетом (Лондон, Великобритания) с возможностью последующего обучения в летней школе Кингстонского университета "Summer business school"</span></a>
			</li>
		</ul>
		<ul>
			<li>
				<a href="../../learn-language/">Английский для взрослых	<span>"English for Travelling" (Английский для путешествий)</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Английский для взрослых	<span>"English for beginners" (Английский для начинающих)</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Английский для преподавателей НВГУ	<span>"English for university teachers"</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Программа подготовки к сдаче международного экзамена	<span>CAE, TOEFL по английскому языку</span></a>
			</li>
			<li>
				<a href="../../learn-language/">Индивидуальные занятия по английскому языку (любой уровень)</a>
			</li>
		</ul>
	</div>
	<?php
	try{
		$query = $db->prepare("SELECT COUNT(*) FROM intcenter_services");
		$query->execute();
		$num = $query->fetchColumn();

		$query = $db->prepare("SELECT name, link FROM intcenter_pages");
		$query->execute();
		$pages = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $db->prepare("SELECT * FROM intcenter_services");
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$page = !isset($_GET['var1']) ? 0 : ( (int)$_GET['var1'] )-1;
	$numberShown = 7;
	$firstShown = $page*$numberShown+1;
	$counter = 0;
	foreach ($row as $service) {
		++$counter;
		if( $counter >= $firstShown and $counter < $firstShown+$numberShown ){
			foreach ($pages as $page) {
				if( mb_strtolower($service['name'], 'UTF-8') === mb_strtolower($page['name'] , 'UTF-8') ){
					$title = '<span><a href="'.$page['link'].'">'.$service['name'].'</a></span>';
					break;
				}
				else{
					$title = '<span>'.$service['name'].'</span>';
				}
			}
			echo'
			<div class="service">'.$title;
				?>
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