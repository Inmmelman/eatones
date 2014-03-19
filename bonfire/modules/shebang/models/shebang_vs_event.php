<?php
    class Shebang_vs_event extends CI_Model{

        protected $table_name = 'shebang_vs_events';

        public function __construct(){
            parent::__construct();
        }


        public function insert($eventId,$shebangId){

            $status = $this->db->insert($this->table_name, array(
                                                            'id_shebang'=> $shebangId,
                                                            'id_events' => $eventId
                                                           ));
            return $status;
        }
    }