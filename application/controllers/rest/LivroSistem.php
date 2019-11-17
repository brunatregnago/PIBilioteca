<?php
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

    

class LivroSistem extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('LivroSistemModel');

    }
    public function index_get() {
        $id = (int) $this->get('id');
        $this->load->model('LivroSistemModel');
        if($id<=0){
            $retorno = $this->LivroSistemModel->getAll();
        } else {
            $retorno = $this->LivroSistemModel->getOne($id);
        }
        $this->set_response($retorno,REST_Controller_Definitions::HTTP_OK);
    }

    public function index_post(){
        //validação para verificar o preenchimentos dos campos
        
        $this->load->model('LivroSistemModel','ls');

        if((!$this->post('titulo'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
        $data = array(
            'titulo' => $this->post('titulo'),
            'subtitulo' => $this->post('subtitulo'),
            'edicao' => $this->post('edicao'),
            'exemplar' => $this->post('exemplar'),
            'autor' => $this->post('autor'),
            'id_categoria' => $this->post('id_categoria')
        );
        //model carregado e enviado para inserir no DB os dados recebidos no POST
        if($this->ls->insert($data)){
            //OK
            $this->set_response([
                'status' => true,
                'message' => 'Inserida com sucesso!'
        ], REST_Controller_Definitions::HTTP_OK);

        }else{
            //ERRO
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir!'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
        }
    }

    public function index_put() {
        $id = (int) $this->get('id');
        if ((!$this->put('titulo')) || (!$this->post('subtitulo')) || (!$this->post('edicao')) || 
        (!$this->post('id_autor')) || (!$this->post('id_categoria')) ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'titulo' => $this->put('titulo'),
            'subtitulo' => $this->put('subtitulo'),
            'edicao' => $this->put('edicao'),
            'id_autor' => $this->put('id_autor'),
            'id_categoria' => $this->put('id_categoria')
        );
        $this->load->model('LivroSistemModel', 'ls');
        if ($this->ls->alterar($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Alterado com sucesso.'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    
    public function index_delete() {
        $id=(int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'message' => 'Erro.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $this->load->model('LivroSistemModel', 'ls');
        if($this->ls->delete($id)){
            $this->set_response([
                'status' => true,
                'message' => 'Deletado com sucesso.'
            ], REST_Controller_Definitions::HTTP_OK);
        } else{
            $this->set_response([
                'status' => FALSE,
                'message' =>'Falha ao deletar.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}