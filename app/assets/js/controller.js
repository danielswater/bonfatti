var url = '/bonfatti/administrador/dashboard/';

app.controller('UsuarioController', function($scope, $http, $rootScope,toaster, $stateParams, UsuarioService, $rootScope){

	$scope.user = {};
	$scope.botao = true;

	$scope.getUserInfo = function(id){
		UsuarioService.getInfo(id).then(function(data){
			$scope.user = data;
		});
	}

	$scope.selecionaUsuario = function(id){
		if(id == undefined){
			$scope.tabelaUsuarios = [];
			$scope.tabelaUsuarios = $scope.items;
		}
		else{
			$scope.tabelaUsuarios = [];
			$scope.tabelaUsuarios[0] = $scope.user;
		}
	}

	$scope.submitForm = function(isValid) {
		$scope.submitted = true;
		if (isValid) {
			if($scope.user.func_senha != $scope.user.func_senha2){
				toaster.pop('error', "Erro", 'As senhas não conferem', 5000);
				return;
			}
			$http.post(url+'usuario', $scope.user).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}

	};

	if($stateParams.param == 0){
		console.log('$stateParams', $stateParams);
		$scope.getUserInfo($stateParams.usuario);
		UsuarioService.usuarioPermissao().then(function(data){			
			if(data.funcionario_cadastro[0].alterar == 0 && $stateParams.usuario != 0){
				$scope.botao = false;
			}
		})
	}

	if($stateParams.param == 2){
		UsuarioService.getTodosUsuarios().then(function(data){
			$scope.items = data;
		});
	}

	// $scope.artigos = {};

	// $scope.listaArtigos = function(){
	// 	$http.get(url+'artigo').then(function(data){
	// 		$scope.artigos = data.data.artigo;
	// 		$scope.viewby = 10;
	// 		$scope.totalItems = $scope.artigos.length;
	// 		$scope.currentPage = 1;
	// 		$scope.itemsPerPage = $scope.viewby;
	// 	});
	// }

	// $scope.removerArtigo = function(artigo){
	// 	$http.post(url+'remover-artigo/'+artigo.id).then(function(data){
	// 		if(data.data.sucesso){
	// 			$scope.mensagem = data.data.mensagem;
	// 			$scope.listaArtigos();
	// 		}
	// 	});
	// }
	// $scope.setPage = function (pageNo) {
	// 	$scope.currentPage = pageNo;
	// };

	// $scope.pageChanged = function() {
	// 	console.log('Page changed to: ' + $scope.currentPage);
	// };
	// $scope.setItemsPerPage = function(num) {
	// 	$scope.itemsPerPage = num;
	// 	$scope.currentPage = 1;
	// }

	// $scope.listaArtigos();
})

app.controller('NoticiaController', function($scope, $http){

	$scope.noticias = {};

	$scope.froalaOptions = {
		placeholderText: '',
		events :{
			'froalaEditor.image.inserted': function(e, editor, $img, response) {
				
          },

		}
	}

	$scope.salvaNoticia = function(){
		$http.post(url+'noticia', $scope.noticias).then(function(data){
			console.log('data', data);
		})
	}

})

app.controller('PermissaoController', function($scope, $http, UsuarioService, $rootScope, toaster){

	$scope.permissao = {};

	UsuarioService.getTodosUsuarios().then(function(data){
		$scope.items = data;
	});

	$scope.getTabelaPermissao = function(id){
		// $scope.permissao.id_usuario = id;
		$http.get(url+'tabela-permissoes/'+id).then(function(data){
			$scope.permissao.funcionario_cadastro = data.data.funcionario_cadastro[0];
			$scope.permissao.funcionario_permissoes = data.data.funcionario_permissoes[0];
			$scope.permissao.boletim = data.data.boletim[0];
			$scope.permissao.links_uteis = data.data.links_uteis[0];
			$scope.permissao.processos_identificacao = data.data.processos_identificacao[0];
			$scope.permissao.processos_clientes = data.data.processos_clientes[0];
			$scope.permissao.processos_ritos = data.data.processos_ritos[0];
			$scope.permissao.processos_cadastros = data.data.processos_cadastros[0];
			$scope.permissao.contatos = data.data.contatos[0];
			$scope.permissao.compromissos = data.data.compromissos[0];
			$scope.permissao.caixa = data.data.caixa[0];
			$scope.permissao.biblioteca = data.data.biblioteca[0];
			$scope.permissao.fale_conosco = data.data.fale_conosco[0];
			$scope.permissao.curriculos = data.data.curriculos[0];
			$scope.permissao.estatisticas = data.data.estatisticas[0];

			console.log('$scope.permissao', $scope.permissao);
		})
	}

	$scope.postPermissoes = function(id, update){
		$http.post(url+'permissoes/'+id+'/'+update, $scope.permissao).then(function(data){
			if(data.data.sucesso){
				toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
			}
			else{
				toaster.pop('error', "Erro", data.data.mensagem, 5000);
			}
		})
	}

})

// app.controller('ArtigoController', function($scope, $http, $state, $stateParams, $rootScope, $timeout){

// 	$scope.uploader = {};
// 	$scope.notedited = true;

// 	if($stateParams.id){
// 		$scope.notedited = false;
// 		$http.get(url+'artigo/'+$stateParams.id).then(function(data){
// 			$scope.artigo = data.data.artigo;
// 		});
// 	}
// 	else{
// 		$scope.artigo = {};
// 	}	

// 	$scope.options = {
// 		language: 'pt-br',
// 		allowedContent: true,
// 		entities: false
// 	};

// 	$scope.salvaArtigo = function(){

// 		$scope.uploader.flow.opts.target = url+'imagem';
// 		$scope.uploader.flow.opts.singleFile = true;
// 		$scope.uploader.flow.opts.simultaneousUploads = 1;
// 		$scope.uploader.flow.opts.testChunks = false;
// 		$scope.uploader.flow.opts.permanentErrors = [415, 500, 501];
// 		$scope.uploader.flow.opts.testMethod = "POST";
// 		$scope.uploader.flow.upload();

// 		$scope.uploader = {
// 			controllerFn: function ($flow, $file, $message) {
// 				$scope.artigo.imagem = $message;
// 			}
// 		}

// 		$timeout(function(){
// 			$http.post(url+'artigo', $scope.artigo).then(function(data){
// 				if(data.data.sucesso){
// 					$rootScope.mensagem = data.data.mensagem;
// 					$scope.artigo = {};
// 					$state.go('dash');
// 				}
// 			})
// 		},1000)
// 	}

// 	$scope.removerImagem = function(){
// 		if(!$scope.notedited){
// 			$scope.notedited = true;
// 			delete $scope.artigo.imagem;
// 		}
// 		else{
// 			$scope.uploader.flow.cancel();
// 		}

// 	}
// })
