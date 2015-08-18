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

	try{
		$accessToken = $helper->getAccessToken();
	}catch(Facebook\Exceptions\FacebookResponseException $e){
		echo 'O Graph retornou um erro: ' . $e->getMessage();
		exit;
	}catch(Facebook\Exceptions\FacebookSDKException $e){
		echo 'O SDK do Facebook retornou um erro: ' . $e->getMessage();
		exit;
	}

	if(!isset($accessToken)){
		if($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Erro: "              . $helper->getError()            . "\n";
			echo "Código do Erro: "    . $helper->getErrorCode()        . "\n";
			echo "Motivo do Erro: "    . $helper->getErrorReason()      . "\n";
			echo "Descrição do Erro: " . $helper->getErrorDescription() . "\n";
		}
		else{
			header('HTTP/1.0 400 Bad Request');
			echo 'Não foi possível gerar os dados corretamente. Requisição Inválida.';
		}
		exit;
	}

	$oAuth2Client  = $fb->getOAuth2Client();
	$tokenMetadata = $oAuth2Client->debugToken($accessToken);
	$tokenMetadata->validateAppId(Configs::$configs['FB']['APP_ID']);
	$tokenMetadata->validateExpiration();

	if(!$accessToken->isLongLived()){
		try{
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo "Erro ao recuperar o acess token: " . $helper->getMessage();
			exit;
		}
	}

	$_SESSION['fb_access_token'] = (string) $accessToken;

	try {
		$response = $fb->get('/me?fields=name', $accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'O Graph retornou um erro: ' . $e->getMessage();
		exit;
	exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'O SDK do Facebook retornou um erro: ' . $e->getMessage();
		exit;
	}

	$gn = $response->getGraphNode();
	$name = $gn['name'];
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
					<h1>Bem vindo <strong><?php echo $name ?></strong></h1>
					<p>Suas informações do facebook foram resgatadas com sucesso, acessa a próxima página para ter acesso mais informações.</p>
				</div>
				<div class="col-lg-offset-4 col-lg-4">
					<a href="get_infos.php"><button class="btn btn-block btn-primary">Ver informações</button></a>
				</div>
			</div>
		</div>
	</body>
</html>