<?php
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

    

class Devolucao extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('DevolucaoModel');
    }

    public function index_get() {/*
        $id = (int) $this->get('id');
        $this->load->model('DevolucaoModel');
        if($id<=0){
            $retorno = $this->DevolucaoModel->getAll();
        } else {
            $retorno = $this->DevolucaoModel->getOne($id);
        }*/
        $this->load->model('DevolucaoModel');
        $retorno = $this->DevolucaoModel->getAll();
        $this->set_response($retorno,REST_Controller_Definitions::HTTP_OK);
    }

    public function index_post(){
        //validação para verificar o preenchimentos dos campos
        
        $this->load->model('DevolucaoModel','dm');

        if((!$this->post('id_usuario')) || (!$this->post('id_locacao')) || (!$this->post('id_livro')) || (!$this->post('data_devolucao'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_locacao' => $this->post('id_locacao'),
            'id_usuario' => $this->post('id_usuario'),
            'id_livro' => $this->post('id_livro'),
            'data_devolucao' => $this->post('data_devolucao')
        );
        //model carregado e enviado para inserir no DB os dados recebidos no POST
        if($this->dm->insert($data)){
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
