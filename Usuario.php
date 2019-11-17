<?php

/** 
 * Implementação da API rest usando a biblioteca do link abaixo
 * Essa biblioteca possui quatro arquivos distintos.
 * 1 - REST_Controller na pasta libraries, que altera o comportamento padrão
 *      dos controllers padrões do CodeIgniter.
 * 2 - Rest_Controller_Definitions na pasta libraries, que tras algumas definições para
 *      o REST_Controller, trabalha como um arquivo de padrões auxiliando o controller principal.
 * 3 - Format na pasta libraries, que faz o parsing (conversao) dos diferentes tipos de dados
 *      (JSON, XML, CSV e etc).
 * 4 - rest.php na pasta config, para as configurações desta biblioteca
 * 
 * @author Aluno: Felipe Kossmann
 * @link https://github.com/chriskacerguis/codeigniter-restserver
 */ 
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\Rest_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Rest_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Usuario extends REST_Controller{
    
    public function __construct(){
        parent::__construct();

    }

    public function index_get(){
        
        $id = (int) $this->get('id');
        $this->load->model('Usuario_model');
        if ($id > 0){
            $retorno = $this->Usuario_model->getOne($id);   
        }else{
            $retorno = $this->Usuario_model->getUsuario();
        }
      
        
        $this->set_response($retorno, Rest_Controller_Definitions::HTTP_OK);

    }

    public function index_post(){

        if((!$this->post('nome')) || (!$this->post('senha')) || (!$this->post('nivel')) || (!$this->post('apikey'))){
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], Rest_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $this->load->model('Usuario_model');


        $data = array (
            'nome' => $this->post('nome'),
            'senha' => $this->post('senha'),
            'nivel' => $this->post('nivel'),
            'apikey' => $this->post('apikey'),
        );

      
        if($this->Usuario_model->insert($data)){   
            $this->set_response(['status' => true, 'message' => 'Usuario inserida com sucesso!'], Rest_Controller_Definitions::HTTP_OK);
        }else{    
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], Rest_Controller_Definitions::HTTP_BAD_REQUEST);
        } 
    }
    

    public function index_put(){

    $id = (int) $this->get('id');

    $this->load->model('Usuario_model');
    if((!$this->put('nome')) || (!$this->put('nome')) || (!$this->put('senha')) || (!$this->put('nivel')) || (!$this->put('apikey')) || ($id <=0)){
        $this->set_response([
            'status' => false,
            'error' => 'Campos não preenchidos'
        ],Rest_Controller_Definitions::HTTP_BAD_REQUEST);
        return;
    }


    $data = array (
        'nome' => $this->put('nome'),
        'senha' => $this->put('senha'),
        'nivel' => $this->put('nivel'),
        'apikey' => $this->put('apikey'),
    );

    if($this->Usuario_model->update($id,$data)){
        $this->set_response([
            'status' => true,
            'message' => 'Usuario alterado com sucesso!'
        ],Rest_Controller_Definitions::HTTP_OK);
    }else{
        $this->set_response([
            'status' => false,
            'error' => 'Usuario não foi alterada!'
        ],Rest_Controller_Definitions::HTTP_BAD_REQUEST);
    }
}

public function index_delete(){


    $id = (int) $this->get('id');

    $this->load->model('Usuario_model');

    if($id <= 0){
        $this->set_response([
            'status' => false,
            'error' => 'Campos não preenchidos'
        ],Rest_Controller_Definitions::HTTP_BAD_REQUEST);
        return;
    }
 
    if($this->Usuario_model->delete($id)){
        $this->set_response([
            'status' => true,
            'message' => 'Usuario deletada com sucesso!'
        ],Rest_Controller_Definitions::HTTP_OK);
    }else{
        $this->set_response([
            'status' => false,
            'error' => 'Usuario não foi deletada!'
        ],Rest_Controller_Definitions::HTTP_BAD_REQUEST);
    }   
}
    } 


?>