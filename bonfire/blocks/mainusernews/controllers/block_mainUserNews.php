<?php
    class Block_MainUserNews extends BaseBlocks{

        public function __construct(){
            parent::__construct();
            //$this->load->block_model('mainusernews_model',get_class($this));
            $this->load->model('mainusernews_model');
        }

        public function run(){
            $shebangNews = $this->mainusernews_model->getShebangsNewsByUserId($this->current_user->id);
            var_dump($shebangNews);die;
            Template::set('shebangNews', $shebangNews);
        }
    }