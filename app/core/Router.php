<?php
class Router {
    static $TOKEN = '5433286804:AAFFPCWGMsjJhiR89TTRO3e2e-_lOnc-8C0';
    static function init() {
        $test = file_get_contents('php://input');
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
        $message = strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');
        switch($message) {
            case '/старт':
            case 'старт':
            case 'start':
            case '/start':
                include 'app/models/ApiModel.php';
                include 'app/controllers/ApiController.php';
                $controller = new ApiController();
                $controller->action_start($data);
                break;
            default:
                $send_data = [
                    'method' => 'sendMessage',
                    'text' => 'command does not exsit',
                    'chat_id' => $data['chat']['id']
                ];
                $res = Router::sendTelegram($send_data['method'], $send_data);
                break;
        }
    }

    public static function sendTelegram($method, $data, $headers = []) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.telegram.org/bot' . Router::$TOKEN . '/' . $method,
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