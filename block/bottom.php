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
		<div class="bottom">
			<div class="leftpart">
				Центр международного сотрудничества и туризма &copy; <?=date('Y', time())?>
				<p>Все права защищены.</p>
			</div>
			<div class="rightpart">
				+7 (3466) 45 76 10
				<p><a href="mailto:nvsu.intercenter@gmail.com">nvsu.intercenter@gmail.com</a></p>
			</div>
		</div>