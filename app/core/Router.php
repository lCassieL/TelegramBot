<?php
class Router {
    static $TELEGRAM_TOKEN = '5433286804:AAFFPCWGMsjJhiR89TTRO3e2e-_lOnc-8C0';
    static $TRELLO_TOKEN = 'e003cd71a46e8d386833b0d020602bbbd4d3902cdc0b566de60fbb84f9fb5002';
    static $TRELLO_KEY = '593fd8ef4b57c8d736fca2d220352a96';
    static function init() {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $param = 'telegram';
        if(!empty($routes[1])) {
            $param = strtolower($routes[1]);
        }
        switch($param) {
            case 'trello':
                $test = file_get_contents('php://input');
                $data = json_decode(file_get_contents('php://input'), TRUE);
                $send_data = [
                    'method' => 'sendMessage',
                    'text' => $test,
                    'chat_id' => $data['chat']['id']
                ];
                $res = Router::sendTelegram($send_data['method'], $send_data);
                break;
            case 'telegram':
                $data = json_decode(file_get_contents('php://input'), TRUE);
                $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
                $message = strtolower($data['text'] ? $data['text'] : $data['data']);
                switch($message) {
                    case '/старт':
                    case 'старт':
                    case 'start':
                    case '/start':
                        /*include 'app/models/ApiModel.php';
                        include 'app/controllers/ApiController.php';
                        $controller = new ApiController();
                        $controller->action_start($data);
                        break;*/
                        $send_data = [
                            'method' => 'sendMessage',
                            'text' => $data['chat']['id'],
                            'chat_id' => $data['chat']['id']
                             ];
                             $res = Router::sendTelegram($send_data['method'], $send_data);
                             break;
                    default:
                        /*$send_data = [
                        'method' => 'sendMessage',
                        'text' => $data['chat']['id'],
                        'chat_id' => $data['chat']['id']
                         ];
                         $res = Router::sendTelegram($send_data['method'], $send_data);
                         break;*/
                }
                break;

        }
    }

    public static function sendTelegram($method, $data, $headers = []) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.telegram.org/bot' . Router::$TELEGRAM_TOKEN . '/' . $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
        ]);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    
    static function ErrorPage404() {
        header($_SERVER['Server_PROTOCOL'].'404 not found');
        exit();
    }
}