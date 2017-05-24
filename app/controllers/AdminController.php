<?php

class AdminController extends BaseController {

	public $url = 'http://localhost/bonfatti/';

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

	public function postFiltraNoticia(){
		if(Input::has('data_inicio')){
			$dataInicio = Input::get('data_inicio');			
			$noticia = DB::select("select * from noticia where not_data between '{$dataInicio} 00:00:00' and '{$dataInicio} 23:59:59'");
		}
		if(Input::has('data_inicio') && Input::has('data_fim')){
			$dataInicio = Input::get('data_inicio');
			$dataFim = Input::get('data_fim');
			$noticia = DB::select("select * from noticia where not_data between date('$dataInicio') and date('$dataFim')");
		}
		if(Input::has('titulo')){
			$titulo = Input::get('titulo');
			$noticia = Noticia::where('not_titulo', 'LIKE', "%$titulo%")->get();
		}
		if(Input::has('chamada')){
			$chamada = Input::get('chamada');
			$noticia = Noticia::where('not_chamada', 'LIKE', "%$chamada%")->get();
		}
		return Response::json(array('noticia' => $noticia));
	}

	// Busca a noticia pelo id, se for null, pega todas as noticias
	public function getNoticia($id){
		if($id == 0){
			$noticia = Noticia::orderBy('not_id', 'DESC')->get();
		}
		else{
			$noticia = Noticia::find($id);
		}
		return Response::json(array('noticia' => $noticia));
	}

	//Faz upload de imagem
	public function postImagem(){
		$file = Input::file('file');
		$destino = base_path().('/app/assets/imagem/');
		$filename = $file->getClientOriginalName();
		$filename = uniqid() . $filename;
		$extension = $file->getClientOriginalExtension();
		$sucesso = Input::file('file')->move($destino, $filename);

		$path = $this->url.'app/assets/imagem/'.$filename;

		if($sucesso){
			return Response::json(array('link' => $path));
		}
	}

	//Remove a imagem do servidor, caso seja excluída do editor
	public function postRemoveImagem(){
		$file = Input::all();
		$img = explode('/imagem/', $file['link']);
		$filename = base_path().('/app/assets/imagem/').$img[1];
		if(File::exists($filename)){
			if(File::delete($filename)){
				return "sucesso";
			}
		}
	}

	// Cria uma nova notícia caso não seja passado o id, se for passado, atualiza
	public function postNoticia(){

		$id = Input::get('not_id');

		if($id == null){
			$noticia = new Noticia();
			$mensagem = 'Notícia salva com sucesso!';
		}
		else{
			$noticia = Noticia::find($id);
			$mensagem = 'Notícia atualizada com sucesso!';
		}
		$noticia->not_data = date('Y:m:d H:i:s');
		$noticia->not_titulo = Input::get('not_titulo');
		$noticia->not_chamada = Input::get('not_chamada');
		$noticia->not_texto = Input::get('not_texto');
		$noticia->not_publicar = Input::get('not_publicar');

		try{
			$noticia->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	// Remove notícia pelo id passado
	public function postRemoverNoticia($id){

		$noticia = Noticia::find($id);

		if($noticia->ativo == 0){
			$noticia->ativo = 1;
		}
		else{
			$noticia->ativo = 0;
		}

		try{
			if($noticia->ativo == 0){
				$mensagem = 'Notícia excluida com sucesso!';
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

	/*
	*********************************************************************
	**************** METODOS REFERENTE A LINKS **************************
	*********************************************************************
	*/

	public function postLink(){
		if(Input::has('link_id')){
			$link = Links::find(Input::get('link_id'));
			$mensagem = 'Link atualizado com sucesso!';
		}
		else{
			$link = new Links();
			$mensagem = 'Link salvo com sucesso!';
		}
		$link->link_nome = Input::get('link_nome');
		$link->link_url = INput::get('link_url');

		try{
			$link->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	public function postFiltraLink(){
		if(Input::has('link_nome')){
			$nome = Input::get('link_nome');
			$link = Links::where('link_nome', 'LIKE', "%$nome%")->get();
		}
		return Response::json(array('links' => $link));
	}

	public function getLink($id = null){
		if($id == null){
			$links = Links::orderBy('link_id', 'DESC')->get();
		}
		else{
			$links = Links::find($id);
		}
		return Response::json(array('links' => $links));
	}
	/*
	*********************************************************************
	**************** METODOS REFERENTE A PROCESSOS **********************
	*********************************************************************
	*/

	// CADASTRO OU ATUALIZAÇÃO DE IDENTIFICAÇÃO

	public function postIdentificacao(){
		if(Input::has('identificacao_id')){
			$identificacao = ProcessosIdentificacao::find(Input::get('identificacao_id'));
			$mensagem = 'Identificação alterada com sucesso!';
		}
		else{
			$identificacao = new ProcessosIdentificacao();
			$mensagem = 'Identificação salva com sucesso!';
		}
		$identificacao->identificacao_nome = Input::get('identificacao_nome');
		try{
			$identificacao->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	// BUSCA IDENTIFICAÇÃO
	public function getIdentificacao($id = null){
		if($id == null){
			$identificacao = ProcessosIdentificacao::orderBy('identificacao_id', 'DESC')->get();
		}
		else{
			$identificacao = ProcessosIdentificacao::find($id);
		}
		return Response::json(array('processo_identificacao' => $identificacao));
	}

	public function postFiltraIdentificacao(){
		if(Input::has('identificacao_nome')){
			$nome = Input::get('identificacao_nome');
			$identificacao = ProcessosIdentificacao::where('identificacao_nome', 'LIKE', "%$nome%")->get();
		}
		return Response::json(array('processo_identificacao' => $identificacao));
	}

	// CADASTRO OU ATUALIZAÇÃO DE CLIENTES
	public function postClientes(){

		if(Input::has('cliente_id')){
			$cliente = ProcessosCliente::find(Input::get('cliente_id'));
			$mensagem = 'Cliente alterado com sucesso!';
		}
		else{
			$cliente = new ProcessosCliente();
			$mensagem = 'Cliente salvo com sucesso!';
		}
		$cliente->cliente_tipo = Input::get('cliente_tipo');
		$cliente->cliente_cgc = Input::get('cliente_cgc');
		$cliente->identificacao_id = Input::get('identificacao_id');
		$cliente->cliente_nome = Input::get('cliente_nome');
		$cliente->cliente_endereco = Input::get('cliente_endereco');
		$cliente->cliente_numero_end = Input::get('cliente_numero_end');
		$cliente->cliente_complemento = Input::get('cliente_complemento');
		$cliente->cliente_bairro = Input::get('cliente_bairro');
		$cliente->cliente_cidade = Input::get('cliente_cidade');
		$cliente->cliente_estado = Input::get('cliente_estado');
		$cliente->cliente_cep = Input::get('cliente_cep');
		$cliente->cliente_telefone = Input::get('cliente_telefone');
		$cliente->cliente_mais_telefone = Input::get('cliente_mais_telefone');
		$cliente->cliente_celular = Input::get('cliente_celular');
		$cliente->cliente_mais_celular = Input::get('cliente_mais_celular');
		$cliente->cliente_email = Input::get('cliente_email');
		$cliente->cliente_info_adicional = Input::get('cliente_info_adicional');

		try{
			$cliente->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	// BUSCA CLIENTES
	public function getClientes($id = null){
		if($id == null){
			$cliente = ProcessosCliente::orderBy('cliente_id', 'DESC')->get();		
			foreach ($cliente as $key => $value) {
				$cli = DB::table('processos_identificacao')->where('identificacao_id', $value->identificacao_id)->pluck('identificacao_nome');
				$cliente[$key]['identificacao_nome'] = $cli;
			}	
		}
		else{
			$cliente = ProcessosCliente::find($id);
		}
		
		return Response::json(array('processo_cliente' => $cliente));
	}

	public function postFiltraCliente(){
		if(Input::has('identificacao_id')){
			$identificacao_id = Input::get('identificacao_id');
			$cliente = ProcessosCliente::where('identificacao_id', '=', $identificacao_id)->get();
			foreach ($cliente as $key => $value) {
				$cli = DB::table('processos_identificacao')->where('identificacao_id', $identificacao_id)->pluck('identificacao_nome');
				$cliente[$key]['identificacao_nome'] = $cli;
			}	

		}
		if(Input::has('cliente_cgc')){
			$cgc = Input::get('cliente_cgc');
			$cliente = ProcessosCliente::where('cliente_cgc', '=', $cgc)->get();
			foreach ($cliente as $key => $value) {
				$cli = DB::table('processos_identificacao')->where('identificacao_id', $cliente[$key]['identificacao_id'])->pluck('identificacao_nome');
				$cliente[$key]['identificacao_nome'] = $cli;
			}
		}
		if(Input::has('cliente_tipo')){
			$tipo = Input::get('cliente_tipo');
			$cliente = ProcessosCliente::where('cliente_tipo', '=', $tipo)->get();
			foreach ($cliente as $key => $value) {
				$cli = DB::table('processos_identificacao')->where('identificacao_id', $cliente[$key]['cliente_tipo'])->pluck('identificacao_nome');
				$cliente[$key]['identificacao_nome'] = $cli;
			}
		}
		if(Input::has('cliente_email')){
			$email = Input::get('cliente_email');
			$cliente = ProcessosCliente::where('cliente_email', '=', $email)->get();
			foreach ($cliente as $key => $value) {
				$cli = DB::table('processos_identificacao')->where('identificacao_id', $cliente[$key]['cliente_email'])->pluck('identificacao_nome');
				$cliente[$key]['identificacao_nome'] = $cli;
			}
		}
		return Response::json(array('processo_cliente' => $cliente));
	}

	// CADASTRO DE RITOS E ATUALIZAÇÃO DE RITO

	public function postRito(){
		if(Input::has('rito_id')){
			$rito = ProcessosRito::find(Input::get('rito_id'));
			$mensagem = 'Rito cadastrado com sucesso!';
		}
		else{
			$rito = new ProcessosRito();
			$mensagem = "Rito alterado com sucesso!";
		}
		$rito->rito_nome = Input::get('rito_nome');

		try{
			$rito->save();
			return Response::json(array('sucesso' => true, 'mensagem' => $mensagem));
		}
		catch(\Exception $e){
			return Response::json(array('sucesso' => false, 'mensagem' => 'Ocorreu um erro ao salvar: ' . $e->getMessage()));
		}
	}

	public function getRito(){
		
	}

	/*
	*********************************************************************
	************************** SAIR DO SISTEMA **************************
	*********************************************************************
	*/

	public function getSair(){
		Auth::logout();
		Session::flush();
		return Redirect::to('/wolgest');
	}
}