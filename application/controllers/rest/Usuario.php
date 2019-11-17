<?php

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Usuario extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('UsuarioModel');
        $this->load->model('LoginModel', 'usuario');
    }

    //nome dos métodos sempre vem acompanhados do tipo de requisição
    //ou seja, contato_get significa que é uma requisição do tipo GET
    //e o usuário vai requisitar (url) apenas /contato
        
    
    public function login() {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post->cpf) || empty($post->senha)) {
            $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $login = $this->usuario->get(array('cpf' => $post->cpf, 'senha' => $post->senha));
            if ($login) {
                $this->output
                        ->set_status_header(200)
                        ->set_output(json_encode(array('id' => $login->id, 'nome' => $login->nome, 'cpf' => $login->cpf,'token'=>$login->apikey), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                $this->output
                        ->set_status_header(400)
                        ->set_output(json_encode(array('status' => false, 'error' => 'Usuário não encontrado'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }
    
    
    public function cadastro() {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post->cpf) || empty($post->senha) || empty($post->nome)) {
            $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $insert = $this->usuario->insert(array('email' => $post->email,'telefone' => $post->telefone,'rua' => $post->rua,'numero' => $post->numero,'bairro' => $post->bairro,'id_cidade' => $post->id_cidade, 'senha' => $post->senha, 'nome' => $post->nome));
            if ($insert > 0) {
                $newToken = md5('salt'.$insert);
                $this->usuario->insertApiKey(array('usuario_id' => $insert, 'apikey' =>$newToken));
                $this->output
                        ->set_status_header(200)
                        ->set_output(json_encode(
                                array(
                                    'id' => "$insert",
                                    'email' => $post->email,
                                    'cpf' => $post->cpf,
                                    'telefone' => $post->telefone,
                                    'nome' => $post->nome,
                                    'rua' => $post->rua,
                                    'numero' => $post->numero,
                                    'bairro' => $post->bairro,
                                    'id_cidade' => $post->id_cidade,
                                    'senha' => $post->senha,
                                    'token' =>$newToken
                        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                $this->output
                        ->set_status_header(400)
                        ->set_output(json_encode(array('status' => false, 'error' => 'Falha no cadastro'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }
    
/*
    public function index_get(){
        $id = (int) $this->get('id');
        $this->load->model('UsuarioModel','em');
        if($id<=0){
            $retorno = $this->em->getAll();
        }else{
            $retorno = $this->UsuarioModel->getOne($id);
        }

        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }

    public function login_post(){
        //validação para verificar o preenchimentos dos campos

        if((!$this->post('senha'))|| (!$this->post('cpf'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'cpf' => $this->post('cpf'),
            'senha' => $this->post('senha')
        );

        //model carregado e enviado para inserir no DB os dados recebidos no POST
        $this->load->model('UsuarioModel','em');

        if($this->em->insert($data)){
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

    //usuario_post significa que este método será executaedo quando
    //o ws (web-service) receber uma requisição do tipo POST na url usuario
    public function index_post(){
        //validação para verificar o preenchimentos dos campos

        if((!$this->post('nome')) || (!$this->post('senha')) 
        || (!$this->post('cpf')) || (!$this->post('telefone')) || (!$this->post('id_cidade'))){//caso um dos dois esteja vazio
            $this->set_response([
                'status' => false,
                'error' => 'Campos não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'nome' => $this->post('nome'),
            'cpf' => $this->post('cpf'),
            'email' => $this->post('email'),
            'telefone' => $this->post('telefone'),
            'rua' => $this->post('rua'),
            'numero' => $this->post('numero'),
            'bairro' => $this->post('bairro'),
            'id_cidade' => $this->post('id_cidade'),
            'senha' => $this->post('senha')
        );

        //model carregado e enviado para inserir no DB os dados recebidos no POST
        $this->load->model('UsuarioModel','em');

        if($this->em->insert($data)){
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

*/
public function index_put(){
    $id = (int) $this->get('id');
    if((!$this->put('nome')) || (!$this->put('senha')) || (!$this->put('cpf')) 
    || (!$this->put('telefone')) || (!$this->put('id_cidade')) || ($id <= 0)){
            $this->set_response([
                'status' => false,
                'error' => 'Preencha os campos.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        
            $data = array(
                'nome' => $this->put('nome'),
                'cpf' => $this->put('cpf'),
                'email' => $this->put('email'),
                'telefone' => $this->put('telefone'),
                'rua' => $this->put('rua'),
                'numero' => $this->put('numero'),
                'bairro' => $this->put('bairro'),
                'id_cidade' => $this->put('id_cidade'),
                'senha' => $this->put('senha')
            );
        
        $this->load->model('UsuarioModel');

        if($this->UsuarioModel->alterar($id, $data)){
            $this->set_response([
                'status' => true, 
                'message' => 'Alterado com sucesso.'
            ], REST_Controller_Definitions::HTTP_OK);
        }else{
            $this->set_response([
                'status' =>true,
                'message' => 'Falha ao alterar.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}

public function index_delete(){
    $id = (int) $this->get('id');

    if($id <= 0){
        $this->set_response([
            'status' => false,
            'message' => 'Parametros obrigatorios não fornecidos'
        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        return;
    }
        $this->load->model('UsuarioModel');
        if($this->UsuarioModel->delete($id)){
            $this->set_response([
                'status' => true, 
                'message' => 'Deletado com sucesso.'
            ], REST_Controller_Definitions::HTTP_OK);
        }else{
            $this->set_response([
                'status' => false, 
                'message' => 'Falha ao deletar.'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
    }
}