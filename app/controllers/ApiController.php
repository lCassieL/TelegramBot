<?php
class ApiController extends Controller {
    public function action_start($data) {
        $this->model = new ApiModel();
        $user = $this->model->getUser($data['from']['id']);
        $user ? $user : $this->model->saveUser($data);
        $send_data = [
            'method' => 'sendMessage',
            'text' => /*'just answer '.$message*/'Hello '.$data['from']['first_name'].' '.$data['from']['last_name'],
            'chat_id' => $data['chat']['id']
        ];
        Router::sendTelegram($send_data['method'], $send_data);
    }
}