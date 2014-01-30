<?php
$error = '';
if(isset($_POST['send'])){
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	$sql = "SELECT count(*) FROM intcenter_admin WHERE login = ? AND password = ?";
	try{
		$result = $db->prepare($sql);
		$result->execute(array($login, $password));
		$num = $result->fetchColumn();
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	if($num > 0){
		session_start();
		$_SESSION['login'] = $login;
		header('Location:/admin/');
	}
	else{
		$error = "<b class='req'>Пользователь не найден. Проверьте логин/пароль.</b>";
	}
}

if('/login/' === $_GET['page']){
?>
	<div class="login">
		<fieldset>
			<?=$error?>
			<legend>Авторизация пользователя</legend>
			<form name="flogin" method='post' action="">
				<label for="">
					<span>Введите логин:</span>
					<input type="text" name="login" id="">
				</label>
				<label for="">
					<span>Введите пароль:</span>
					<input type="password" name="password" id="pass">
				</label>
				<div class="button_panel">
					<input class="button" name='send' type="submit" value="Войти">
					<input class="button" type="reset" value="Очистить поля">
				</div>
			</form>
		</fieldset>
	</div>
<?php
}
elseif('/logout/' === $_GET['page']){
	session_start();
	session_destroy();
	header('Location:/');
}

?>