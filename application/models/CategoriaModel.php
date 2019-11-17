<?php

class CategoriaModel extends CI_Model{
 
    public function lista() {
        $data['categoria'] = $this->CategoriaModel->getAll();
    }

public function getAll(){
   $query =  $this->db->get('categoria');
   return $query->result();
}

public function getOne($id){
  if($id > 0){
    $this->db->where('id', $id);
    $query = $this->db->get('categoria');

    return $query->row(0);
  }else{
      return false;
    }
}

public function insert($data = array()) {
    $this->db->insert('categoria', $data);
    return $this->db->affected_rows();
}

public function delete($id) {
    if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->delete('categoria');
        return $this->db->affected_rows();
    } else {
        return false;
    }
}
    public function alterar($id, $data = array()){
        if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->update('categoria', $data);
        return $this->db->affected_rows();
        }else{
            return false;
        }
    }


    }
?>