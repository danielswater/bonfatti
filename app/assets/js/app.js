var app = angular.module('modulo', ['ngAnimate','toaster', 'ngSanitize','ngCookies','froala','ngResource','ngStorage', 'ngSanitize','ngTouch', 'ui.bootstrap', 'ui.router'])
.value('froalaConfig', {
	toolbarInline: false,
	placeholderText: ''
})

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider, $stateParams){
	
	$stateProvider
	.state('usuario', {
		url : '/',
		params : {
			param: 0,
			usuario : 0
		},
		views: {
			'content@' : {
				templateUrl : '/bonfatti/app/views/wolgest/dashboard/partials/home.html',
				controller: 'UsuarioController'
			}
		}
	})
	.state('busca-usuario', {
		url: '/busca-usuario',
		params: {
			param: 0,
			usuario: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-usuario.html',
				controller: 'UsuarioController'
			}
		}
	})
	.state('permissao', {
		url: '/permissao',
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/permissoes.html',
				controller: 'PermissaoController'
			}
		}
	})
	.state('noticia', {
		urL: '/noticia',
		params: {
			param: 0,
			noticia: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/noticia.html',
				controller: 'NoticiaController'
			}
		}
	})
	.state('busca-noticia', {
		url: '/busca-noticia',
		params: {
			param: 0,
			noticia: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-noticia.html',
				controller: 'NoticiaController'
			}
		}

	})
	.state('links', {
		url: '/links',
		params: {
			param: 0,
			link: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/links.html',
				controller: 'LinksUteis'
			}
		}
	})
	.state('busca-links', {
		url: '/busca-links',
		params: {
			param: 0,
			link: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-links.html',
				controller: 'LinksUteis'
			}
		}
	})
	.state('identificacao', {
		url: '/identificacao',
		params: {
			param: 0,
			identificacao: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/identificacao.html',
				controller: 'ProcessoIdentificacao'
			}
		}
	})
	.state('busca-identificacao', {
		url: '/busca-identificacao',
		params: {
			param: 0,
			identificacao: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-identificacao.html',
				controller: 'ProcessoIdentificacao'
			}
		}
	})
	.state('cliente', {
		url: '/cliente',
		params: {
			param: 0,
			cliente: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/cliente.html',
				controller: 'ProcessosCliente'
			}
		}
	})
	.state('busca-cliente', {
		url: '/busca-cliente',
		params: {
			param: 0,
			cliente: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-cliente.html',
				controller: 'ProcessosCliente'
			}
		}
	})
	.state('rito', {
		url: '/rito',
		params: {
			param: 0,
			rito: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/rito.html',
				controller: 'ProcessosRito'
			}
		}
	})
	.state('cadastro', {
		url: '/cadastro',
		params: {
			param: 0,
			rito: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/cadastro.html',
				controller: 'ProcessosCadastro'
			}
		}
	})
	.state('busca-cadastro', {
		url: '/busca-cadastro',
		params: {
			param: 0,
			rito: 0
		},
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/busca-cadastro.html',
				controller: 'ProcessosCadastro'
			}
		}
	})
	$urlRouterProvider.otherwise('/');

}])

app.run(function($rootScope, $http, $state){

	$rootScope.url = '/bonfatti/administrador/dashboard/';
	$rootScope.permissao = {};
	$rootScope.$state = $state;

	$rootScope.getTabelaPermissao = function(){
		$http.get($rootScope.url+'tabela-permissoes/'+0).then(function(data){
			$rootScope.permissao.funcionario_cadastro = data.data.funcionario_cadastro[0];
			$rootScope.permissao.funcionario_permissoes = data.data.funcionario_permissoes[0];
			$rootScope.permissao.boletim = data.data.boletim[0];
			$rootScope.permissao.links_uteis = data.data.links_uteis[0];
			$rootScope.permissao.processos_identificacao = data.data.processos_identificacao[0];
			$rootScope.permissao.processos_clientes = data.data.processos_clientes[0];
			$rootScope.permissao.processos_ritos = data.data.processos_ritos[0];
			$rootScope.permissao.processos_cadastros = data.data.processos_cadastros[0];
			$rootScope.permissao.contatos = data.data.contatos[0];
			$rootScope.permissao.compromissos = data.data.compromissos[0];
			$rootScope.permissao.caixa = data.data.caixa[0];
			$rootScope.permissao.biblioteca = data.data.biblioteca[0];
			$rootScope.permissao.fale_conosco = data.data.fale_conosco[0];
			$rootScope.permissao.curriculos = data.data.curriculos[0];
			$rootScope.permissao.estatisticas = data.data.estatisticas[0];

			console.log('rootScope', $rootScope.permissao);
		})
	}
	$rootScope.getTabelaPermissao();
})