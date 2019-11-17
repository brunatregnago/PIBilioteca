<?php

class BibliotecaModel extends CI_Model{
 
    public function lista() {
        $data['biblioteca'] = $this->BibliotecaModel->getAll();
    }


    public function getAll() {
        $query = $this->db->get('biblioteca');
        return $query->result();
    }
    public function getOne($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
           $query = $this->db->get('biblioteca');
            return $query->row(0);
        } else {
            return false;
        }
     }

public function insert($data = array()) {
    $this->db->insert('biblioteca', $data);
    return $this->db->affected_rows();
}


    }
?>