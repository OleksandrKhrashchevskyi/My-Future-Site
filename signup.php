<?php
error_reporting(0);
	require 'db.php';
	$data = $_POST;
	function captcha_show(){
		$questions = array(
			1 => 'Столица России',
			2 => 'Столица США',
			3 => '2 + 3',
			4 => '15 + 14',
			5 => '45 - 10',
			6 => '33 - 3',
            7 => 'Путин - Х....?'
		);
		$num = mt_rand( 1, count($questions) );
		$_SESSION['captcha'] = $num;
		echo $questions[$num];
	}

	//если кликнули на button
	if ( isset($data['do_signup']) )
	{
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин';
		}

		if ( trim($data['email']) == '' )
		{
			$errors[] = 'Введите Email';
		}

		if ( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		//проверка на существование одинакового логина
		if ( R::count('users', "login = ?", array($data['login'])) > 0)
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}

    //проверка на существование одинакового email
		if ( R::count('users', "email = ?", array($data['email'])) > 0)
		{
			$errors[] = 'Пользователь с таким Email уже существует!';
		}

		//проверка капчи
		$answers = array(
			1 => 'москва',
			2 => 'вашингтон',
			3 => '5',
			4 => '29',
			5 => '35',
			6 => '30',
            7 => 'Хуйло'
		);
		if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
		{
			$errors[] = 'Ответ на вопрос указан не верно!';
			var_dump($answers);
		}


		if ( empty($errors) )
		{
			//ошибок нет, теперь регистрируем
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
			R::store($user);
			echo '<div style="color:green;">Вы успешно зарегистрированы!</div>';
		}else
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</p><hr>';
		}

    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="logsig/css/style.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div id="login">
<form action="signup.php" method="POST">
    <fieldset class="clearfix">

        <p><span class="fontawesome-user"></span><input type="text" name="login" placeholder="Login" value="<?php echo @$data['login']; ?>"></p>
        <p><span class="far fa-envelope"></span><input type="email" name="email" placeholder="Email" value="<?php echo @$data['email']; ?>"></p>
        <p><span class="fontawesome-lock"></span><input type="password"  name="password" placeholder="Password" value="<?php echo @$data['password']; ?>"></p>
        <p><span class="fontawesome-lock"></span><input type="password"  name="password_2" placeholder="Password" value="<?php echo @$data['password_2']; ?>"></p>
        <p><span class="fas fa-key"></span><input type="text" name="captcha" placeholder="<?php captcha_show(); ?>">
        <p><input type="submit" name="do_signup" value="Register">

    </fieldset>
</form>
    <p>Have account ? &nbsp;&nbsp;<a href="login.php">Login</a><span class="fontawesome-arrow-right"></span></p>
</div>
</body>
</html>