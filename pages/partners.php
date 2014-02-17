<?php
try{
	$query = $db->prepare("SELECT * FROM intcenter_partners");
	$query->execute();
	$row = $query->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	header('Location: /error/');
}

print_r($row);
?>
<div class="container"></div>