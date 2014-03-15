<?php
class User_subscribe_model extends CI_Model{

    protected $table_name = 'user_subscribe';


    public function insert($data=array()){

        $status = false;

        $query = $this->db->get_where($this->table_name,$data);
        if ($query->num_rows())
        {
            return -1;

        }

        if($query->num_rows() == 0 ){
            $status = $this->db->insert($this->table_name, $data);
        }

        //TODO инноБД транзакции
        /*if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
        }*/

        if ($status == false) {
            $this->error = $this->get_db_error_message();
            return 0;
        }

        return 1;
    }

    public function find($userId){
        return BF_Model::find($userId);
    }


    public function getSubscribeByUserId($userId){

        $rowCount = 0;
        $returnSubscribeArray = array();
        $this->db->select('shebang`.`title`, shebang`.`shebang_avatar`, shebang`.`id`' );
        $this->db->from('bf_shebang');
        $this->db->join( 'user_subscribe`' ,'`bf_user_subscribe.shebang_id =  bf_shebang`.`id`');
        $this->db->where('user_subscribe`.`user_id` = '.$userId);
        $this->db->limit(10);
        $query = $this->db->get();
        $rowCount = $query->num_rows();

        if (!$rowCount)
        {
            return false;
        }

        foreach($query->result() as $row){
            $returnSubscribeArray['shebangs'][] = $row;
        }

        $returnSubscribeArray['count'] = $rowCount;
        return $returnSubscribeArray;
    }
}