<?php

class LocacaoSistemModel extends CI_Model{
 
    public function lista() {
        $data['locaacao'] = $this->LocacaoSistemModel->getAll();
    }

public function getAll(){
   $query =  $this->db->get('locacao');
   return $query->result();
}

public function getOne($id){
  if($id > 0){
    $this->db->where('id', $id);
    $query = $this->db->get('locacao');

    return $query->row(0);
  }else{
      return false;
    }
}

public function insert($data = array()) {
    $this->db->insert('locacao', $data);
    return $this->db->affected_rows();
}

public function delete($id) {
    if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->delete('locacao');
        return $this->db->affected_rows();
    } else {
        return false;
    }
}
    public function alterar($id, $data = array()){
        if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->update('locacao', $data);
        return $this->db->affected_rows();
        }else{
            return false;
        }
    }


    }
?>