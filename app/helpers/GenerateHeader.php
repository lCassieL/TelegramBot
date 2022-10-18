<?php
class GenerateHeader {
    public static function generateHeader($status, $status_code, $message, $content_name = null, $content = null){
        $answer = [];
        $answer["status"] = $status;
        $answer['message'] = $message;
        if($content_name && $content){
            $answer[$content_name] = $content;
        }
        $json = json_encode($answer);
        header('Content-type: application/json; charset=utf-8');
        http_response_code($status_code);
        echo $json;
    }
}