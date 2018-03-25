<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// array phrasers

$phrases = [
	'sit' => 'сидеть',
	'human' => 'человек',
	'woman' => 'баба',
	'smoke' => 'курить',
	'to fly' => 'летать',
	'cry' => 'плакать',
	'width' => 'ширина',
	'berry' => 'ягода',
	'session' => 'сеанс',
	'fate' => 'судьба',
	'atmosphere' => 'атмосфера',
];

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
			$text = mb_strtolower($data->object->body);
			$text_s = 0;
			foreach ($phrases as $key => $value) {
				if ($phrases[$key] == $text)
				{
					$text_s = 1;
				}
			}

			if ($text_s == 1)
			{
				 
				$message_param = 'Красава! Переведи следующее слово: ' . $phrases[rand(0, count($phrases)-1)];
			}
			else
			{
				$message_param = 'Тупица ты! Переведи слово: ' . $phrases[rand(0, count($phrases)-1)];
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
