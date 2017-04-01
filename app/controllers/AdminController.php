<?php

class AdminController extends BaseController {

	public function getIndex(){

		return View::make('wolgest.dashboard.index');

	}

	/*
	*********************************************************************
	**************** METODOS REFERENTE A USUARIO ************************
	*********************************************************************
	*/

	//Método que faz a busca do usuário logado
	public function getUserInfo($id){
		if($id == 0){
			$id = Auth::id();
			$user = User::find($id);
		}
		else{
			$user = User::find($id);
		}
		
		return Response::json(array('user' => $user));
	}

	//Metodo que cria e atualiza um usuário. Se vier com o campo id, atualiza, senao cria um novo
	public function postUsuario(){

		if(Input::has('func_id')){
			$id = Input::get('func_id');
			$user = User::find($id);
			$mensagem = "Usuário alterado com sucesso!";
		}
		else{
			$result = $this->verificaLogin(Input::get('func_login'));
			if($result){
				return Response::json(array('sucesso' => false, 'mensagem' => 'Já existe um usuário cadastrado com esse login.'));
			}
			$user = new User();
			$mensagem = 'Usuário criado com sucesso!';
		}
		
		$user->func_login = Input::get('func_login');
		$user->func_senha = Hash::make(Input::get('func_senha'));
		$user->func_departamento = Input::get('func_departamento');
		$user->func_nome = Input::get('func_nome');
		$user->func_email = Input::get('func_email');

		try{
			$user->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	// Método que pega todos os usuários, exceto o que está logado
	public function getTodosUsuarios(){
		$user = User::where('func_id', '<>', Auth::id())->get();
		return Response::json(array('user' => $user));
	}

	// Método que verifica se já existe o login na hora de cadastrar um novo usuário
	private function verificaLogin($login){
		$result = DB::table('funcionario')->where('func_login', $login)->pluck('func_login');
		return $result;
	}


	/*
	*********************************************************************
	**************** METODOS REFERENTE A PERMISSÕES *********************
	*********************************************************************
	*/

	public function postPermissao(){

	}

	public function getMontaMenuPermissoes(){
		
	}

	public function getArtigo($id = null){

		if($id === null){
			$artigo = Artigo::orderBy('id', 'DESC')->get();
		}
		else{
			$artigo = Artigo::find($id);
		}
		return Response::json(array('artigo' => $artigo));
	}

/*	public function postImagem(){

		$file = Input::file('file');
		$destino = 'app/assets/imagem';
		$filename = $file->getClientOriginalName();
		$filename = uniqid() . $filename;
		$extension = $file->getClientOriginalExtension();
		$sucesso = Input::file('file')->move($destino, $filename);

		if($sucesso){
			return $filename;
		}
	}*/

	public function postArtigo(){

		$id = Input::get('id');

		if($id == null){
			$artigo = new Artigo();
			$mensagem = 'Artigo salvo com sucesso!';
		}
		else{
			$artigo = Artigo::find($id);
			$mensagem = 'Artigo atualizado com sucesso!';
		}
		$artigo->titulo = Input::get('titulo');
		$artigo->imagem = Input::get('imagem');
		$artigo->conteudo = Input::get('conteudo');
		$artigo->data = date('Y:m:d');

		try{
			$artigo->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	public function postRemoverArtigo($id){

		$artigo = Artigo::find($id);

		if($artigo->ativo == 0){
			$artigo->ativo = 1;
		}
		else{
			$artigo->ativo = 0;
		}

		try{
			if($artigo->ativo == 0){
				$mensagem = 'Artigo inativado com sucesso!';
			}
			else{
				$mensagem = 'Artigo ativado com sucesso!';
			}
			$artigo->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao remover o artigo: ' . $e->getMessage()));
		}
	}

	// public function getEditarPost($id){

	// 	$usuario = User::find($id);
	// 	return View::make('web.dashboard.editar', compact('usuario'));
	// }

	// public function postEditarPost(){

	// 	$usuario = User::find(Input::get('id'));
	// 	$usuario->nome = Input::get('nome');
	// 	$usuario->email = Input::get('email');
	// 	$usuario->password = Hash::make(Input::get('password'));

	// 	if($this->verificaEmail($usuario->email, Input::get('id'))){
	// 		return Redirect::to('administrador/dashboard/editar/'.$usuario->id)->with('message', 'Já existe um usuário cadastrado com esse email!');
	// 	}
	// 	else{
	// 		try{
	// 			$usuario->save();
	// 			return Redirect::to('administrador/dashboard/editar/'.$usuario->id)->with('message', 'Usuário alterado com sucesso!');
	// 		}
	// 		catch(\Exception $e){
	// 			$e->getMessage();
	// 		}
	// 	}
	// }

	// public function getListar(){

	// 	$usuarios = User::where('tipo', '<>', 1)->where('ativo', '=', 0)->get();

	// 	return View::make('web.dashboard.listar', compact('usuarios'));
	// }

	// public function getDeletar($id){

	// 	$usuario = User::find($id);

	// 	$usuario->ativo = 0;

	// 	try{
	// 		$usuario->save();
	// 		return Redirect::to('administrador/dashboard')->with('delete', 'Usuário removido com sucesso!');
	// 	}
	// 	catch(\Exception $e){
	// 		$e->getMessage();
	// 	}
	// }

	// public function getAtivar($id){

	// 	$usuario = User::find($id);

	// 	$usuario->ativo = 1;

	// 	try{
	// 		$usuario->save();
	// 		return Redirect::to('administrador/dashboard')->with('ativar', 'Usuário ativado com sucesso!');
	// 	}
	// 	catch(\Exception $e){
	// 		$e->getMessage();
	// 	}
	// }

	public function getSair(){
		Auth::logout();
		return Redirect::to('/');
	}

	// private function verificaEmail($email, $id){
	// 	$email = User::where('email', '=', $email)->where('id', '<>', $id)->pluck('email');
	// 	return ($email) ? true : false;
	// }
}