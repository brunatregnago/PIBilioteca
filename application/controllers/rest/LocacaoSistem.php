<?php
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

    

class LocacaoSistem extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('LocacaoSistemModel');
        
        date_default_timezone_set('America/Sao_Paulo');
    }


    public function index_get() {
        $id = (int) $this->get('id');
        $this->load->model('LocacaoSistemModel');
        if($id<=0){
            $retorno = $this->LocacaoSistemModel->getAll();
        } else {
            $retorno = $this->LocacaoSistemModel->getOne($id);
        }
        $this->set_response($retorno,REST_Controller_Definitions::HTTP_OK);
    }

    public function index_post(){
        //validação para verificar o preenchimentos dos campos
        
        $this->load->model('LocacaoSistemModel','ls');

        if((!$this->post('id_usuario')) || (!$this->post('id_livro')) || (!$this->post('data_devolucao'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_usuario' => $this->post('id_usuario'),
            'id_livro' => $this->post('id_livro'),
            'data_devolucao' => /*date('Y-m-d H:i:s')*/ $this->post('data_devolucao')
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

    public function index_put() {
        $id = (int) $this->get('id');
        if ((!$this->put('id_livro')) || (!$this->put('id_usuario')) || (!$this->put('data_devolucao')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_usuario' => $this->put('id_usuario'),
            'id_livro' => $this->put('id_livro'),
            'data_devolucao' => $this->put('data_devolucao')
        );
        $this->load->model('LocacaoSistemModel', 'ls');
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
        $this->load->model('LocacaoSistemModel', 'ls');
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