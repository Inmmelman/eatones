<?php
    class Shebang_user_model extends User_model{
        protected $table_name = 'shebang';


        public function insert($data=array())
        {
            return BF_Model::insert($data);
        }

        public function find($userId){
            return BF_Model::find($userId);
        }

        public function getShebangById($userId){
            return BF_Model::find($userId);
        }
    }