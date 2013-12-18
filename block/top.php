<?php
try{
	$query = $db->prepare("SELECT * FROM intcenter_contacts");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$contacts = $query->fetch();	
}
catch(PDOException $e){
	showMsg('Внутренняя ошибка сервера');
}
?>
	<div class="head">
		<div class="logo">
			<a href="http://<?=$_SERVER['SERVER_NAME']?>"></a>
		</div>
	</div>
	<div class="maindiv">
		<div class="shadowleft"></div>
		<div class="shadowright"></div>

		<div class="orgname">Центр международного&nbsp;образования&nbsp;и&nbsp;туризма</div>
		<div class="contacts">
			<?=$contacts['phone_code']?>
			<span class="phone"><?=$contacts['phone']?></span>
			<address><?=$contacts['address']?></address>
		</div>
		<?php drawVerticalMenu($db); ?>
		<div class='h-menu'>
			<ul>
				<li>
					<a href=''><img src='../img/foreign_lang.png' alt='Изучение иностранных языков'></a>
					<a href=''>Изучение иностранных&nbsp;языков</a>
				</li>
				<li>
					<a href=''><img src='../img/visa_support.png' alt='Визовая поддержка'></a>
					<a href=''>Визовая поддержка</a>
				</li>
				<li>
					<a href=''><img src='../img/lang_schools.png' alt='Летние и зимние языковые школы'></a>
					<a href=''>Летние и зимние языковые школы</a>
				</li>
				<li>
					<a href=''><img src='../img/prof_internships.png' alt='Профессиональные стажеровки за рубежом'></a>
					<a href=''>Профессиональные стажировки за рубежом</a>
				</li>
				<li>
					<a href=''><img src='../img/doc_translate.png' alt='Перевод документов'></a>
					<a href=''>Перевод документов</a>
				</li>
			</ul>
		</div>
		<div class="prog-menu">
			<h3>Программы обучения</h3>
			<ul>
				<li>
					<span>
						<span class="big">Английский язык</span>
						<small>Для детей</small>
						<img src="../img/arrow_right.png" alt="Программы обучения">
					</span>
					<ul>
						<li>
							<span>1</span>
							<small>some text</small>
							<b>some bold text</b>
						</li>
						<li>as;djfapsdjfaspdfn</li>
						<li>as;djfapsdjfaspdfn</li>
					</ul>
				</li>
				<li>
					<span>Пустая ссылка</span>
					<ul>
						<li>as;djfapsdjfaspdfn</li>
						<li>as;djfapsdjfaspdfn</li>
						<li>as;djfapsdjfaspdfn</li>
					</ul>
				</li>
				<li>
					<span>Пустая ссылка</span>
					<ul>
						<li>as;djfapsdjfaspdfn</li>
						<li>as;djfapsdjfaspdfn</li>
						<li>as;djfapsdjfaspdfn</li>
					</ul>
				</li>
			</ul>
		</div>