<?php
class View {
    public $template;
    public $page;

    public function __construct() {
        $this->template = 'template_main_view';
    }

    public function render() {
        include_once 'app/views/'.$this->template.'.php';
    }

    public function getStringPriority($priority_number) {
        switch($priority_number) {
            case '1':
                return 'High';
                break;
            case '2':
                return 'Medium';
                break;
            case '3':
                return 'Low';
                break;
        }
        return false;
        
    }

    public function getArrowClassPriority($priority_number) {
        switch($priority_number) {
            case '1':
                return 'fa fa-arrow-up text-danger';
                break;
            case '2':
                return 'fa fa-arrow-up text-warning';
                break;
            case '3':
                return 'fa fa-arrow-down text-primary';
                break;
        }
        return false;
        
    }

    public function getCheckClassCompleted($completed) {
        switch($completed) {
            case '0':
                return 'text-muted';
                break;
            case '1':
                return 'text-success';
                break;
        }
        return false;
    }
}