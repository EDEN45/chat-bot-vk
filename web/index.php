<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Our web handlers
$app->get('/', function() use($app) {
  return "bot-math-1155";
});

// Our web handlers
$app->post('/bot', function() use($app) {

	$data = json_decode(file_get_contents('php://input'));

	if (!$data)
	{
		return "bot-math-1155";
	}

	if ($data->secret !== getenv('VK_SECRET_KEY') && $data->type !== 'confirmation')
	{
		return "bot-math-1155";
	}

	switch ($data->type) {
		case 'confirmation':
			return getenv('VK_RETURN_KEY');
			break;
		
		case 'message_new':
			$request_params = [
				'user_id' => $data->object->user_id,
				'message' => 'Ты живешь в '.$data->object->geo->type .'? Значит ты мудак!',
				'access_token' => getenv('VK_TOKEN'),
				'v' => '5.73'
			];

			file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
			return 'ok';
			break;
		default:
			# code...
			break;
	}
  return "bot-math-1155" ;
});

$app->run();
