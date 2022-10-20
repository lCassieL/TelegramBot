<?php
class Router {
    static function init() {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $param = '';
        if(!empty($routes[1])) {
            $param = strtolower($routes[1]);
        }
        switch($param) {
            case 'trello':
                include 'app/models/ApiModel.php';
                include 'app/controllers/ApiController.php';
                $controller = new ApiController();
                $controller->action_trello();
                break;
            case 'telegram':
                $data = json_decode(file_get_contents('php://input'), TRUE);
                $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
                $message = strtolower($data['text'] ? $data['text'] : $data['data']);
                $message = explode(' ', $message);
                include 'app/models/ApiModel.php';
                include 'app/controllers/ApiController.php';
                $controller = new ApiController();
                switch($message[0]) {
                    case '/start':
                        $controller->action_start($data);
                        break;
                    case '/connect':
                        $controller->action_connect($data, $message[1]);
                        break;
                    case '/report':
                        $controller->action_report($data);
                        break;
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
            CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/' . $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
        ]);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public static function sendTrello($user_id) {
            $method = 'GET';
            $url = 'https://api.trello.com/1/members/'.$user_id.'/cards';
            $data = array(
                'key' => TRELLO_KEY,
                'token' => TRELLO_TOKEN
            );
            $curl = curl_init();
            switch ($method)
            {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_PUT, 1);
                    break;
                default:
                    if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "username:password");
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
    }
}