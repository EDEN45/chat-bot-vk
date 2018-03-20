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
		$message_param = "";
		case 'message_new':

			$user_id = $data->object->user_id;
			$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.73")); 
			$user_name = $user_info->response[0]->first_name;
			
			if ($data->object->body == "Как дела?")
			{
				$message_param = "Иди в жопу черт ебаный";
			}
			else
			{

				$message_param = 'Я не понимаю тебя ' . $user_name .' - значит ты мудак!';
			}
			

			$request_params = [
				'user_id' => $data->object->user_id,
				'message' => $message_param,
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
