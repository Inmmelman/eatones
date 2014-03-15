<?php
    class Shebang_model extends MY_Model{
        protected $table_name = 'shebang';


        public function getNewShebangs(){
            $query = $this->db->get_where($this->table_name);
            $return = $query->{$this->_return_type(true)}();
            $this->temp_return_type = $this->return_type;
            return $return;
        }


        public function getBestShebang(){

            return false;
            $this->db->select('*');
            $this->db->from($this->table_name);
            $this->db->join('bf_shebang_commercial',"bf_shebang_commercial.bf_shebang_id = $this->table_name.id ");
            $query = $this->db->get();
            $return = $query->{$this->_return_type()}();
            $this->temp_return_type = $this->return_type;
            return $return;
        }

    }