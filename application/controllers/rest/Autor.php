<?php
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

    

class Autor extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('AutorModel');

    }
    public function index_get() {
        $id = (int) $this->get('id');
        $this->load->model('AutorModel');
        if($id<=0){
            $retorno = $this->AutorModel->getAll();
        } else {
            $retorno = $this->AutorModel->getOne($id);
        }
        $this->set_response($retorno,REST_Controller_Definitions::HTTP_OK);
    }

    public function index_post(){
        //validação para verificar o preenchimentos dos campos
        
        $this->load->model('AutorModel','a');

        if((!$this->post('autor'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'autor' => $this->post('autor')
        );
        //model carregado e enviado para inserir no DB os dados recebidos no POST
        if($this->a->insert($data)){
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

    public function index_put() {
        $id = (int) $this->get('id');
        if ((!$this->put('autor')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'autor' => $this->put('autor')
        );
        $this->load->model('AutorModel', 'a');
        if ($this->a->alterar($id, $data)) {
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
        $this->load->model('AutorModel', 'a');
        if($this->a->delete($id)){
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