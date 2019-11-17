<?php

class ReservaModel extends CI_Model{
 
    public function lista() {
        $data['reserva'] = $this->ReservaModel->getAll();
    }

public function getAll(){
   $query =  $this->db->get('reserva');
   return $query->result();
}

public function getOne($id){
  if($id > 0){
    $this->db->where('id', $id);
    $query = $this->db->get('reserva');

    return $query->row(0);
  }else{
      return false;
    }
}

public function insert($data = array()) {
    $this->db->insert('reserva', $data);
    return $this->db->affected_rows();
}

public function delete($id) {
    if ($id > 0) {
        $this->db->where('id', $id);
        $this->db->delete('reserva');
        return $this->db->affected_rows();
    } else {
        return false;
    }
}

}
?>