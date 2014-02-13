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
	<div class="bottom">
		<div class="leftpart">
			Центр международного обучения и туризма &copy; <?=date('Y', time())?>
			<p>Все права защищены.</p>
		</div>
		<div class="rightpart">
			+7 <?=$contacts['phone_code']?> <?=$contacts['phone']?>
			<p><a href="mailto:<?=$contacts['email']?>"><?=$contacts['email']?></a></p>
		</div>
	</div>