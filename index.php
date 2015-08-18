<?php
	session_start();
	require_once('./app/vendor/autoload.php');
	require_once('./app/config/Config.php');
	$fb = new Facebook\Facebook([
		'app_id'                => Configs::$configs['FB']['APP_ID'],
		'app_secret'            => Configs::$configs['FB']['APP_SECRET'],
		'default_graph_version' => Configs::$configs['FB']['GRAP_VERSION'],
	]);
	$helper = $fb->getRedirectLoginHelper();
	$url    = $helper->getLoginUrl(Configs::$configs['FB']['CALLBACK'], Configs::$configs['FB']['PERMISSIONS']);
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Login com Facebook</title>
		<meta charset="utf-8">
		<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="css/libs/font-awesome/font-awesome.css" rel="stylesheet">
		<link href="css/public/style.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="js/bootstrap/ie.fix/ie8.responsive.file.warning.js"></script><![endif]-->
		<script src="js/bootstrap/ie.fix/ie.emulation.modes.warning.js"></script>
		<script src="js/bootstrap/ie.fix/ie10.viewport.bug.workaround.js"></script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>Teste de Login com Facebook</h1>
					<p>Script de testes para o login com o facebook</p>
				</div>
				<div class="col-lg-offset-4 col-lg-4">
					<a class="btn btn-block btn-social btn-facebook" href="<?php echo $url ?>">
						<i class="fa fa-facebook"></i> Entrar com o Facebook
					</a>
				</div>
			</div>
		</div>
	</body>
</html>