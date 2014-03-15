<?php
    class Social_user_model extends User_model{
        protected $table_name = 'common_users';


        public function insert($data=array())
        {
            return BF_Model::insert($data);
        }

        public function find($userId){
            return BF_Model::find($userId);
        }
    }