<?php
    class MainUserNews_model extends MY_Model{
        protected $table_name = 'users';


        public function getNewShebangs(){
            $query = $this->db->get_where($this->table_name,'visible = 1');
            $return = $query->{$this->_return_type(true)}();
            $this->temp_return_type = $this->return_type;
            return $return;
        }


        public function getShebangsNewsByUserId($userId){

            $userId = (int)$userId;
            $this->db->select(' bf_shebang_events.*, bf_shebang.title as shebang_title');
            $this->db->from($this->table_name);
            $this->db->join('bf_user_subscribe',"bf_users.id = bf_user_subscribe.user_id");
            $this->db->join('bf_shebang',"bf_user_subscribe.shebang_id = bf_shebang.id");
            $this->db->join('bf_shebang_vs_events',"bf_shebang.id = bf_shebang_vs_events.id_shebang");
            $this->db->join('bf_shebang_events',"bf_shebang_vs_events.id_events = bf_shebang_vs_events.id_events");
            $this->db->where("bf_users.id = $userId AND bf_shebang_events.`status` = '-1' AND bf_shebang.visible = 1");
            $this->db->group_by('bf_shebang_events.id_event');
            $query = $this->db->get();
            $return = $query->{$this->_return_type(true)}();
            $this->temp_return_type = $this->return_type;
            return $return;
        }

    }