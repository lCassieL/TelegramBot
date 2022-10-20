<?php
class ApiModel extends Model {
    public function saveUser($data) {
        if($this->db->connect_errno === 0) {
            $telegram_id = (int)$data['from']['id'];
            $first_name = $data['from']['first_name'];
            $last_name = $data['from']['last_name'];
            $first_name = mysqli_real_escape_string($this->db, $first_name);
            $last_name = mysqli_real_escape_string($this->db, $last_name);
            $query="INSERT INTO users(telegram_id, first_name, last_name) VALUES('$telegram_id', '$first_name','$last_name');";
            $this->db->query($query);
            return $this->db->insert_id;
        }
    }

    public function getUser($id) {
        if($this->db->connect_errno === 0) {
            $query = "SELECT * FROM users WHERE telegram_id=".(int)$id;
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }

    public function connectToTrelloAcc($data, $trello_id) {
        if($this->db->connect_errno === 0) {
            $telegram_id = (int)$data['from']['id'];
            $trello_id = mysqli_real_escape_string($this->db, $trello_id);
            $query = "UPDATE users SET trello_id='$trello_id' WHERE telegram_id=".$telegram_id;
            $this->db->query($query);
        }
    }
}