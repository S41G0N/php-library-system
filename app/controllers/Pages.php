<?php
class Pages extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Home'
        ];
        $this->view('index',$data);
    }

    public function about() {
        $data = [
            'title' => 'About'
        ];
        $this->view('about',$data);
    }

    public function contact() {
        $data = [
            'title' => 'Contact'
        ];
        $this->view('contact', $data);
    }

}
