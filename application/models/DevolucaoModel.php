<?php

class DevolucaoModel extends CI_Model{
 
    public function lista() {
        $data['devolucao'] = $this->DevolucaoModel->getAll();
    }

public function getAll(){
   $query =  $this->db->get('devolucao');
   return $query->result();
}
/*
public function getOne($id){
  if($id > 0){
    $this->db->where('id', $id);
    $query = $this->db->get('devolucao');

    return $query->row(0);
  }else{
      return false;
    }
}
*/
public function insert($data = array()) {
    $this->db->insert('devolucao', $data);
    return $this->db->affected_rows();
}

    }
?>