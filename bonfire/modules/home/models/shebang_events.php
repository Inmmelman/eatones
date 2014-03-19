<?php
    class Shebang_events extends MY_Model{
        protected $table_name = 'shebang_events';

        public function getNewEvents(){

            $this->db->select("*,bf_shebang.id,$this->table_name.title as event_title,$this->table_name.description as event_description");
            $this->db->from($this->table_name);
            $this->db->join('bf_shebang_vs_events',"bf_shebang_vs_events.id_events = $this->table_name.id_event ");
            $this->db->join('bf_shebang',"bf_shebang.id = bf_shebang_vs_events.id_shebang",'left');
            $this->db->where("$this->table_name.status = '-1' AND bf_shebang.visible = 1");
            $query = $this->db->get();
            $return = $query->{$this->_return_type(true)}();
            $this->temp_return_type = $this->return_type;
            return $return;

        }
    }