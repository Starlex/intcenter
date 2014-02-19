<?php
try{
	$query = $db->prepare("SELECT * FROM intcenter_contacts");
	$query->execute();
	$contacts = $query->fetch(PDO::FETCH_ASSOC);	
}
catch(PDOException $e){
	header('Location: /error/');
}
?>

	<div title="Наверх" class="up-btn"></div>
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
		<div class="empty"></div>
		<?php
		drawVerticalMenu($db);
		drawHorizontalMenu();
		breadcrumbs($db);
		
		?>