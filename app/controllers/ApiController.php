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
        $action = $data['action']['display']['translationKey'];
        $card_name = $data['action']['display']['entities']['card']['text'];
        $list_before = $data['action']['display']['entities']['listBefore']['text'];
        $list_after = $data['action']['display']['entities']['listAfter']['text'];
        if($action == 'action_move_card_from_list_to_list') {
            $message = 'карточка '.$card_name.' перемещена с '.$list_before.' в '.$list_after;
            $send_data = [
                'method' => 'sendMessage',
                'text' => $message,
                'chat_id' => '-843626643'//'398498577'
            ];
            $res = Router::sendTelegram($send_data['method'], $send_data);
        }
    }
}