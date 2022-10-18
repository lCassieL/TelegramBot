<?php
class Router {
    static $TOKEN = '5433286804:AAFFPCWGMsjJhiR89TTRO3e2e-_lOnc-8C0';
    static function init() {
        $test = file_get_contents('php://input');
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
        //$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');
        $message = $data['text'] ? $data['text'] : $data['data'];
        switch($message) {
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
        /*$controller_name = 'main';
        $action_name = 'products';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if(!empty($routes[1])) {
            $controller_name = strtolower($routes[1]);
        }
        if(!empty($routes[2])) {
            $action_name = strtolower($routes[2]);
        }

        $controller_name = ucfirst($controller_name);
        $controller_class = $controller_name.'Controller';
        $model_class = $controller_name.'Model';
        $action = 'action_'.$action_name;
        $model_path = 'app/models/'.$model_class.'.php';
        if(file_exists($model_path)) {
            include $model_path;
        }
        $controller_path = 'app/controllers/'.$controller_class.'.php';
        if(file_exists($controller_path)) {
            include $controller_path;
        } else {
            self::ErrorPage404();
        }
        $controller = new $controller_class;
        if(method_exists($controller, $action)) {
            empty($routes[3]) ? $controller->$action() : $controller->$action($routes[3]);
        } else {
            self::ErrorPage404();
        }*/
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