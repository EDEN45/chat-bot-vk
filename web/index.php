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

	if ($data->secret !== getenv('VK_TOKEN') && $data->type !== 'confirmation')
	{
		return "bot-math-1155";
	}

	switch ($data->type) {
		case 'confirmation':
			return getenv('VK_RETURN_KEY');
			break;
		
		default:
			# code...
			break;
	}
  return "bot-math-1155" ;
});

$app->run();
