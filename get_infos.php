<?php
	session_start();
	require_once('./app/vendor/autoload.php');
	require_once('./app/config/Config.php');
	$fb = new Facebook\Facebook([
		'app_id'                => Configs::$configs['FB']['APP_ID'],
		'app_secret'            => Configs::$configs['FB']['APP_SECRET'],
		'default_graph_version' => Configs::$configs['FB']['GRAP_VERSION'],
	]);

	$helper      = $fb->getRedirectLoginHelper();
	$accessToken = $_SESSION['fb_access_token'];

	try {
		$gets = array('name','email','bio','birthday','cover','website','locale','gender','hometown','location');
		$res = $fb->get('/me?fields=' . join($gets, ',')       , $accessToken);
		$pic = $fb->get('/me/picture?type=large&redirect=false', $accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'O Graph retornou um erro: ' . $e->getMessage();
		exit;
	exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'O SDK do Facebook retornou um erro: ' . $e->getMessage();
		exit;
	}

	$gn_res = $res->getGraphNode();
	$gn_pic = $pic->getGraphNode();

	$date = $gn_res->getProperty('birthday');
	$date = date_format($date, 'd/m/Y');
?>

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
					<h1>Bem vindo <strong><?php echo $gn_res['name'] ?></strong></h1>
					<h2>Aqui estão mais algumas informações suas:</h2>
				</div>
				<div class="col-lg-3">
					<img src="<?php echo $gn_pic['url']; ?>" class="img-responsive center">
				</div>
				<div class="col-lg-9">
					<ul>
						<li><strong>Nome:</strong> <?php echo $gn_res['name']; ?></li>
						<li><strong>Email:</strong> <?php echo $gn_res['email']; ?></li>
						<li><strong>Biografia:</strong> <?php echo $gn_res['bio']; ?></li>
						<li><strong>Aniversário:</strong> <?php echo $date; ?></li>
						<li><strong>Website:</strong> <?php echo $gn_res['website']; ?></li>
						<li><strong>Gênero:</strong> <?php echo $gn_res['gender']; ?></li>
						<li><strong>Local:</strong> <?php echo $gn_res['location']['name']; ?></li>
					</ul>
				</div>
				<hr>
				<div class="col-lg-12">
					<img src="<?php echo $gn_res['cover']['source']; ?>" class="img-responsive center">
				</div>
			</div>
		</div>
	</body>
</html>