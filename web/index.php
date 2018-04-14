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
            $message_param = "";
			$user_id = $data->object->user_id;
			$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.73"));
			$user_name = $user_info->response[0]->first_name;
			$text = mb_strtolower($data->object->body);

			if ($text == 'list')
			{
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://translate.yandex.net/api/v1.5/tr.json/getLangs',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => "key=trnsl.1.1.20180413T172147Z.6f22e4dfc88bc4ec.4267b106cc2103bc4ebabcf61fc464463f970087&ui=ru"
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $response = json_decode($response);
                $str = '';
                foreach ($response->langs as $key => $val){
                    $str .= $key . ':' . $val;
                    $str .= '/n';
                }
                $message_param = $str;
			}
			else
			{
                $arr = explode(' ', $text);
                $lang = $arr[count($arr)-1];
                if(strlen($lang) > 2){
                    $message_param = 'Укажите язык';
                } else {
                    array_pop($arr);
                    $text = implode(' ', $arr);
                    $myCurl = curl_init();
                    curl_setopt_array($myCurl, array(
                        CURLOPT_URL => 'https://translate.yandex.net/api/v1.5/tr.json/translate',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => "key=trnsl.1.1.20180413T172147Z.6f22e4dfc88bc4ec.4267b106cc2103bc4ebabcf61fc464463f970087&text=" . $text . "&lang=" . $lang
                    ));
                    $response = curl_exec($myCurl);
                    curl_close($myCurl);
                    $response = json_decode($response);
                    $message_param = $response->text[0];
                }
			}


			$request_params = [
				'user_id' => $data->object->user_id,
				'message' => $message_param . ' ' . $user_name . ' написал: ' . $text,
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
