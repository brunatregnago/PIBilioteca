<?php

class AutorModel extends CI_Model{
 
    public function lista() {
        $data['autor'] = $this->AutorModel->getAll();
    }

public function getAll(){
   $query =  $this->db->get('autor');
   return $query->result();
}

public function getOne($id){
  if($id > 0){
    $this->db->where('id', $id);
    $query = $this->db->get('autor');

    return $query->row(0);
  }else{
      return false;
    }
}

public function insert($data = array()) {
    $this->db->insert('autor', $data);
    return $this->db->affected_rows();
}

public function delete($id) {
    if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->delete('autor');
        return $this->db->affected_rows();
    } else {
        return false;
    }
}
    public function alterar($id, $data = array()){
        if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->update('autor', $data);
        return $this->db->affected_rows();
        }else{
            return false;
        }
    }


    }
?>