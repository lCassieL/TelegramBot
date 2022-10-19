<?php
class ApiController extends Controller {
    public function action_start($data) {
        $this->model = new ApiModel();
        $user = $this->model->getUser($data['from']['id']);
        $user ? $user : $this->model->saveUser($data);
        $send_data = [
            'method' => 'sendMessage',
            'text' => 'Hello '.$data['from']['first_name'].' '.$data['from']['last_name'],
            'chat_id' => $data['chat']['id']
        ];
        Router::sendTelegram($send_data['method'], $send_data);
    }

    public function action_trello() {
        $data = json_decode(file_get_contents('php://input'), TRUE);
        if($data['action']['display']['translationKey'] == 'action_move_card_from_list_to_list') {
            $message = 'карточка '.$data['action']['display']['entities']['card']['text'].
                       ' перемещена с '.$data['action']['display']['entities']['listBefore']['text'].
                       ' в '.$data['action']['display']['entities']['listAfter']['text'];
            $send_data = [
                'method' => 'sendMessage',
                'text' => $message,
                'chat_id' => '398498577'
            ];
            $res = Router::sendTelegram($send_data['method'], $send_data);
        }
    }
}