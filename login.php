<?php
error_reporting(0);
	require 'db.php';

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ( password_verify($data['password'], $user->password) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				echo '<div class="error" style="color:green;">Вы авторизованы!<br/> Можете перейти на <a href="http://localhost/Myfutire%20website/index.php">главную</a> страницу.</div><hr>';
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}

		if ( ! empty($errors) )
		{
			//выводим ошибки авторизации
			echo '<div id="error" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}

?>






<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Regestration</title>
    <link rel="stylesheet" href="logsig/css/style.css" media="screen" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div id="login">
<form action="login.php" method="POST">
    <fieldset class="clearfix">
        <p><span class="fontawesome-user"></span><input type="text" name="login" value="<?php echo @$data['login']; ?>"></p>
        <p><span class="fontawesome-lock"></span><input type="password"  name="password" value="<?php echo @$data['password']; ?>"></p>
        <p><input type="submit" name="do_login" value="Login">
    </fieldset>
    </form>
    <p class="panel">
        <i class="fab fa-facebook-square"></i>
        <i class="fab fa-twitter-square"></i>
        <i class="fab fa-linkedin"></i>
        <i class="fab fa-pinterest-square"></i>
        <i class="fab fa-google-plus-square"></i>
        <i class="fab fa-instagram"></i>
    </p>
    <p>No account ? &nbsp;&nbsp;<a href="signup.php">Regestration</a><span class="fontawesome-arrow-right"></span></p>
</div>
</body>
</html>
