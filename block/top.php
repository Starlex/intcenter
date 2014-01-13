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
					<a href=''><img src='../../../../img/foreign_lang.png' alt='Изучение иностранных языков'>
					Изучение иностранных&nbsp;языков</a>
				</li>
				<li>
					<a href=''><img src='../../../../img/visa_support.png' alt='Визовая поддержка'>Визовая поддержка</a>
				</li>
				<li>
					<a href=''><img src='../../../../img/lang_schools.png' alt='Летние и зимние языковые школы'>Летние и зимние языковые школы</a>
				</li>
				<li>
					<a href=''><img src='../../../../img/prof_internships.png' alt='Профессиональные стажеровки за рубежом'>Профессиональные стажировки за рубежом</a>
				</li>
				<li>
					<a href=''><img src='../../../../img/doc_translate.png' alt='Перевод документов'>Перевод документов</a>
				</li>
			</ul>
		</div>
		<?php drawProgramsMenu($db);?>