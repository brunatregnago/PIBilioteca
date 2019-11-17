<?php

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Biblioteca extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('BibliotecaModel');
    }

    //nome dos métodos sempre vem acompanhados do tipo de requisição
    //ou seja, contato_get significa que é uma requisição do tipo GET
    //e o usuário vai requisitar (url) apenas /contato
        
 public function biblioteca_get(){
        $retorno = [
            'status' => true,
            'login' => 'bruna',
            'senha' => 'senha',
            'error' =>''
        ];
        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }
    

    public function index_get(){
        $id = (int) $this->get('id');
        $this->load->model('BibliotecaModel','bm');
        if($id<=0){
            $retorno = $this->bm->getAll();
        }else{
            $retorno = $this->BibliotecaModel->getOne($id);
        }

        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }

    //usuario_post significa que este método será executaedo quando
    //o ws (web-service) receber uma requisição do tipo POST na url usuario
    public function index_post(){
        //validação para verificar o preenchimentos dos campos

        if((!$this->post('login')) || (!$this->post('senha'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'login' => $this->post('login'),
            'senha' => $this->post('senha')
        );

        //model carregado e enviado para inserir no DB os dados recebidos no POST
        $this->load->model('BibliotecaModel','bm');

        if($this->bm->insert($data)){
            //OK
            $this->set_response([
                'status' => true,
                'message' => 'Usuário inserido com sucesso!'
        ], REST_Controller_Definitions::HTTP_OK);

        }else{
            //ERRO
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir usuário!'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }

    }

}