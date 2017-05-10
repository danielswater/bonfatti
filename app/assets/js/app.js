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

	$urlRouterProvider.otherwise('/');

}])

app.run(function($rootScope, $http){

	$rootScope.permissao = {};

	$rootScope.getTabelaPermissao = function(){
		$http.get(url+'tabela-permissoes/'+0).then(function(data){
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

app.service('UsuarioService', ['$http', function($http){
	this.getInfo = function(id){
		return $http.get(url+'user-info/'+id).then(function(data){
			return data.data.user;
		})
	}
	this.getTodosUsuarios = function(){
		return $http.get(url+'todos-usuarios').then(function(data){
			return data.data.user;
		})
	}
	this.usuarioPermissao = function(){
		return $http.get(url+'tabela-permissoes/'+0).then(function(data){
			return data.data;
		})
	}

}])


