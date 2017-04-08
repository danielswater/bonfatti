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

		$perm = false;

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
			$perm = true;
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
			// Para o cadastro de um novo usuário, todas as permissões são definidas
			if($perm){
				$this->postPermissoes($user->func_id, 0);
			}
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	// Método que pega todos os usuários, exceto o que está logado
	public function getTodosUsuarios(){
		$user = User::all();
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

	// update == 0 vai criar novas permissoes, 1 atualiza as permissoes do usuário
	public function postPermissoes($idUsuario, $update){

		if($update == 0){
			DB::table('permissoes')->insert(array(
				array('id_usuario' => $idUsuario, 'id_canal' => 1, 'id_subcanal' => 1, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 1, 'id_subcanal' => 2, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 2, 'id_subcanal' => 3, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 3, 'id_subcanal' => 4, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 4, 'id_subcanal' => 5, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 4, 'id_subcanal' => 6, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 4, 'id_subcanal' => 7, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 4, 'id_subcanal' => 8, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 5, 'id_subcanal' => 9, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 6, 'id_subcanal' => 10, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 7, 'id_subcanal' => 11, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 8, 'id_subcanal' => 12, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 9, 'id_subcanal' => 13, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 10, 'id_subcanal' => 14, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),
				array('id_usuario' => $idUsuario, 'id_canal' => 11, 'id_subcanal' => 15, 'incluir' => 0, 'excluir' => 0, 'localizar' => 0, 'alterar' => 0),

				));
		}
		else{

			$input = Input::all();			
			$valid = true;

			$idPermissao = $input['funcionario_cadastro']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['funcionario_cadastro']['incluir'];
				$permissao->localizar = $input['funcionario_cadastro']['localizar'];
				$permissao->alterar = $input['funcionario_cadastro']['alterar'];
				$permissao->excluir = $input['funcionario_cadastro']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['funcionario_permissoes']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['funcionario_permissoes']['incluir'];
				$permissao->localizar = $input['funcionario_permissoes']['localizar'];
				$permissao->alterar = $input['funcionario_permissoes']['alterar'];
				$permissao->excluir = $input['funcionario_permissoes']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['boletim']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['boletim']['incluir'];
				$permissao->localizar = $input['boletim']['localizar'];
				$permissao->alterar = $input['boletim']['alterar'];
				$permissao->excluir = $input['boletim']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['links_uteis']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['links_uteis']['incluir'];
				$permissao->localizar = $input['links_uteis']['localizar'];
				$permissao->alterar = $input['links_uteis']['alterar'];
				$permissao->excluir = $input['links_uteis']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['processos_identificacao']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['processos_identificacao']['incluir'];
				$permissao->localizar = $input['processos_identificacao']['localizar'];
				$permissao->alterar = $input['processos_identificacao']['alterar'];
				$permissao->excluir = $input['processos_identificacao']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['processos_clientes']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['processos_clientes']['incluir'];
				$permissao->localizar = $input['processos_clientes']['localizar'];
				$permissao->alterar = $input['processos_clientes']['alterar'];
				$permissao->excluir = $input['processos_clientes']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['processos_ritos']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['processos_ritos']['incluir'];
				$permissao->localizar = $input['processos_ritos']['localizar'];
				$permissao->alterar = $input['processos_ritos']['alterar'];
				$permissao->excluir = $input['processos_ritos']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['processos_cadastros']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['processos_cadastros']['incluir'];
				$permissao->localizar = $input['processos_cadastros']['localizar'];
				$permissao->alterar = $input['processos_cadastros']['alterar'];
				$permissao->excluir = $input['processos_cadastros']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['contatos']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['contatos']['incluir'];
				$permissao->localizar = $input['contatos']['localizar'];
				$permissao->alterar = $input['contatos']['alterar'];
				$permissao->excluir = $input['contatos']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['compromissos']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['compromissos']['incluir'];
				$permissao->localizar = $input['compromissos']['localizar'];
				$permissao->alterar = $input['compromissos']['alterar'];
				$permissao->excluir = $input['compromissos']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['caixa']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['caixa']['incluir'];
				$permissao->localizar = $input['caixa']['localizar'];
				$permissao->alterar = $input['caixa']['alterar'];
				$permissao->excluir = $input['caixa']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['biblioteca']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['biblioteca']['incluir'];
				$permissao->localizar = $input['biblioteca']['localizar'];
				$permissao->alterar = $input['biblioteca']['alterar'];
				$permissao->excluir = $input['biblioteca']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['fale_conosco']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['fale_conosco']['incluir'];
				$permissao->localizar = $input['fale_conosco']['localizar'];
				$permissao->alterar = $input['fale_conosco']['alterar'];
				$permissao->excluir = $input['fale_conosco']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['curriculos']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['curriculos']['incluir'];
				$permissao->localizar = $input['curriculos']['localizar'];
				$permissao->alterar = $input['curriculos']['alterar'];
				$permissao->excluir = $input['curriculos']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}

			$idPermissao = $input['estatisticas']['id_permissao'];
			$permissao = Permissoes::find($idPermissao);

			try{
				$permissao->incluir = $input['estatisticas']['incluir'];
				$permissao->localizar = $input['estatisticas']['localizar'];
				$permissao->alterar = $input['estatisticas']['alterar'];
				$permissao->excluir = $input['estatisticas']['excluir'];
				$permissao->save();
			}
			catch(\Exception $e){
				$valid = false;
				return $e->getMessage();
			}
			if($valid){
				return Response::json(array('sucesso' => true, 'mensagem' => 'Permissões atualizadas com sucesso!'));
			}
		}
	}

	public function getTabelaPermissoes($id){

		// Método que monta a tablea de permissões com seus checkbox

		if($id == 0){
			$id = Auth::id();
		}

		$tabela['funcionario_cadastro'] = DB::select('select * from permissoes where id_canal = 1 and id_subcanal = 1 and id_usuario = ?', array($id));
		$tabela['funcionario_permissoes'] = DB::select('select * from permissoes where id_canal = 1 and id_subcanal = 2 and id_usuario = ?', array($id));
		$tabela['boletim'] = DB::select('select * from permissoes where id_canal = 2 and id_subcanal = 3 and id_usuario = ?', array($id));
		$tabela['links_uteis'] = DB::select('select * from permissoes where id_canal = 3 and id_subcanal = 4 and id_usuario = ?', array($id));
		$tabela['processos_identificacao'] = DB::select('select * from permissoes where id_canal = 4 and id_subcanal = 5 and id_usuario = ?', array($id));
		$tabela['processos_clientes'] = DB::select('select * from permissoes where id_canal = 4 and id_subcanal = 6 and id_usuario = ?', array($id));
		$tabela['processos_ritos'] = DB::select('select * from permissoes where id_canal = 4 and id_subcanal = 7 and id_usuario = ?', array($id));
		$tabela['processos_cadastros'] = DB::select('select * from permissoes where id_canal = 4 and id_subcanal = 8 and id_usuario = ?', array($id));
		$tabela['contatos'] = DB::select('select * from permissoes where id_canal = 5 and id_subcanal = 9 and id_usuario = ?', array($id));
		$tabela['compromissos'] = DB::select('select * from permissoes where id_canal = 6 and id_subcanal = 10 and id_usuario = ?', array($id));
		$tabela['caixa'] = DB::select('select * from permissoes where id_canal = 7 and id_subcanal = 11 and id_usuario = ?', array($id));
		$tabela['biblioteca'] = DB::select('select * from permissoes where id_canal = 8 and id_subcanal = 12 and id_usuario = ?', array($id));
		$tabela['fale_conosco'] = DB::select('select * from permissoes where id_canal = 9 and id_subcanal = 13 and id_usuario = ?', array($id));
		$tabela['curriculos'] = DB::select('select * from permissoes where id_canal = 10 and id_subcanal = 14 and id_usuario = ?', array($id));
		$tabela['estatisticas'] = DB::select('select * from permissoes where id_canal = 11 and id_subcanal = 15 and id_usuario = ?', array($id));

		return $tabela;
	}

	/*
	*********************************************************************
	**************** METODOS REFERENTE AS NOTÍCIAS **********************
	*********************************************************************
	*/

	public function getNoticia($id = null){

		if($id === null){
			$noticia = Noticia::orderBy('not_id', 'DESC')->get();
		}
		else{
			$noticia = Noticia::find($id);
		}
		return Response::json(array('noticia' => $noticia));
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

	public function postNoticia(){

		$id = Input::get('not_id');

		if($id == null){
			$noticia = new Notícia();
			$mensagem = 'Artigo salvo com sucesso!';
		}
		else{
			$noticia = Notícia::find($id);
			$mensagem = 'Notícia atualizado com sucesso!';
		}
		$noticia->titulo = Input::get('titulo');
		$noticia->imagem = Input::get('imagem');
		$noticia->conteudo = Input::get('conteudo');
		$noticia->data = date('Y:m:d');

		try{
			$noticia->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	public function postRemoverNoticia($id){

		$noticia = Notícia::find($id);

		if($noticia->ativo == 0){
			$noticia->ativo = 1;
		}
		else{
			$noticia->ativo = 0;
		}

		try{
			if($noticia->ativo == 0){
				$mensagem = 'Notícia inativado com sucesso!';
			}
			else{
				$mensagem = 'Notícia ativado com sucesso!';
			}
			$noticia->save();
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