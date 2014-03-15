<?php
    class Block_Subscribers extends BaseBlocks{

        public function __construct(){
            parent::__construct();
            $this->load->model('shebang_model');
        }

        public function run(){
            $bestShebang = $this->shebang_model->getBestShebang();
            Template::set('bestShebang', $bestShebang);
        }
    }