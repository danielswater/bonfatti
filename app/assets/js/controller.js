var url = '/bonfatti/administrador/dashboard/';

app.controller('UsuarioController', function($state,$scope, $http, $rootScope,toaster, $stateParams, UsuarioService, $rootScope){

	$scope.user = {};
	$scope.botao = true;
	$scope.botao_atualizar = true;

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

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.user = {};
	};

	$scope.limpaUsuario = function(){
		$scope.user = {};
	}
	if($stateParams.param == 0){
		console.log('$stateParams', $stateParams);
		$scope.getUserInfo($stateParams.usuario);
		UsuarioService.usuarioPermissao().then(function(data){			
			if(data.funcionario_cadastro[0].alterar == 0 && $stateParams.usuario != 0){
				$scope.botao = false;
			}
			if(data.funcionario_cadastro[0].incluir == 0){
				$scope.botao_atualizar = false;
			}
		})
	}

	if($stateParams.param == 2){
		UsuarioService.getTodosUsuarios().then(function(data){
			$scope.items = data;
		});
	}

})

app.controller('NoticiaController', function($scope, $http, toaster, $stateParams){

	$scope.noticias = {};
	$scope.tabelaNoticia = [];

	$scope.clear = function () {
		$scope.noticias.data_inicio = null;
	};

	$scope.toggleMin = function() {
		$scope.minDate = $scope.minDate ? null : new Date();
	};
	$scope.toggleMin();

	$scope.open = function($event) {
		$event.preventDefault();
		$event.stopPropagation();

		$scope.opened = true;
	};

	$scope.open2 = function($event) {
		$event.preventDefault();
		$event.stopPropagation();

		$scope.opened2 = true;
	};

	$scope.dateOptions = {
		formatYear: 'yy',
		startingDay: 1
	};

	$scope.formats = ['dd/MM/yyyy','shortDate'];
	$scope.format = $scope.formats[0];

	$scope.froalaOptions = {
		tableResizerOffset: 10,
		tableResizingLimit: 50,
		imageUploadParam: 'file',
		imageUploadMethod: 'POST',
		imageUploadURL: url+'imagem',
		language: 'pt_br',
		height: 300,
		placeholderText: '',
		events :{
			'froalaEditor.image.beforeUpload': function(e, editor, images){
			},
			'froalaEditor.image.uploaded': function(e, editor, response){
				$scope.imagem = JSON.parse(response);
			},
			'froalaEditor.image.inserted': function(e, editor, $img, response){
				//console.log('imagem inserida', $img[0].src);
			},
			'froalaEditor.image.removed': function(e, editor, $img) {
				$http.post(url+'remove-imagem', $scope.imagem).then(function(data){
					
				})
			},
			'froalaEditor.image.error': function(e, editor, error, response){
			}

		}
	}

	$scope.submitForm = function(isValid){
		$scope.submitted = true;
		if(isValid){
			$http.post(url+'noticia', $scope.noticias).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}
	}

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.noticias = {};
	};

	$scope.limpaNoticia = function(){
		$scope.noticias = {};
	}

	$scope.getNoticia = function(id){
		$http.get(url+'noticia/'+id).then(function(data){
			$scope.noticias = data.data.noticia;
			$scope.tabelaNoticia = $scope.noticias;
			$scope.paginacao($scope.noticias);
		})
	}

	$scope.filtrarNoticia = function(){

		if($scope.noticias.data_inicio){
			$scope.noticias.data_inicio = moment($scope.noticias.data_inicio).format('YYYY-MM-DD');
		}
		if($scope.noticias.data_fim){
			$scope.noticias.data_fim = moment($scope.noticias.data_fim).format('YYYY-MM-DD');
		}
		if((new Date($scope.noticias.data_inicio).getTime() > new Date($scope.noticias.data_fim).getTime())){
			toaster.pop('error', "Erro", "A data inicial não pode ser maior que a data final.", 5000);
			return;
		}
		if($scope.noticias.data_fim && !$scope.noticias.data_inicio){
			toaster.pop('error', "Erro", "Escolha uma data inicial para esse tipo de busca.", 5000);
			return;
		}
		$http.post(url+'filtra-noticia', $scope.noticias).then(function(data){
			$scope.noticias = data.data.noticia;
			$scope.tabelaNoticia = $scope.noticias;
			$scope.paginacao($scope.noticias);

		})
	}

	$scope.setItemsPerPage = function(num) {
		$scope.itemsPerPage = num;
		$scope.currentPage = 1;
	}

	$scope.setPage = function (pageNo) {
		$scope.currentPage = pageNo;
	};

	$scope.paginacao = function(obj){
		$scope.viewby = 10;
		$scope.totalItems = obj.length;
		$scope.currentPage = 1;
		$scope.itemsPerPage = $scope.viewby;
		$scope.maxSize = 5;
	}

	if($stateParams.param == 0 && $stateParams.noticia != 0){
		$scope.getNoticia($stateParams.noticia);
	}

})

app.controller('PermissaoController', function($scope, $http, UsuarioService, $rootScope, toaster){

	$scope.permissao = {};
	UsuarioService.getTodosUsuarios().then(function(data){
		$scope.items = data;
	});

	$scope.getTabelaPermissao = function(id){
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

app.controller('LinksUteis', function($scope, $http, $rootScope, toaster, $stateParams){
	$scope.botao = true;
	$scope.botao_atualizar = true;
	$scope.links = {};
	$scope.tabelaLink = [];

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.links = {};
	};
	$scope.limpaLinks = function(){
		$scope.links = {};
	}
	$scope.getLinks = function(id){
		if(id == undefined){
			$http.get(url+'link').then(function(data){
				$scope.tabelaLink = data.data.links;				
				$scope.paginacao($scope.tabelaLink);
			})
		}
		else{
			$http.get(url+'link/'+id).then(function(data){
				$scope.tabelaLink = data.data.links;
				$scope.links = data.data.links;
			})
		}
	}
	if($stateParams.param == 0){
		console.log('state param', $stateParams);
		$scope.getLinks($stateParams.link);
	}
	$scope.filtrarLink = function(valid){
		$scope.submitted = true;
		if(valid){
			$http.post(url+'filtra-link', $scope.links).then(function(data){
				console.log('data', data);
			})
		}
	}
	
	$scope.submitForm = function(valid){
		$scope.submitted = true;
		if(valid){
			console.log('scope', $scope.links);
			return;
			$http.post(url+'link', $scope.links).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}
	}

	$scope.setItemsPerPage = function(num) {
		$scope.itemsPerPage = num;
		$scope.currentPage = 1;
	}

	$scope.setPage = function (pageNo) {
		$scope.currentPage = pageNo;
	};

	$scope.paginacao = function(obj){
		$scope.viewby = 10;
		$scope.totalItems = obj.length;
		$scope.currentPage = 1;
		$scope.itemsPerPage = $scope.viewby;
		$scope.maxSize = 5;
	}

})
