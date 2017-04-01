var app = angular.module('modulo', ['ngAnimate','toaster', 'ngSanitize','ngCookies','ngResource','ngStorage', 'ngSanitize','ngTouch', 'ui.bootstrap', 'ui.router', 'ckeditor'])

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
				templateUrl : function($stateParams){
					if($stateParams.param == 2){
						return '/bonfatti/app/views/wolgest/dashboard/partials/busca-usuario.html';
					}
					return '/bonfatti/app/views/wolgest/dashboard/partials/home.html'
				},
				controller: 'UsuarioController'
			}
		}
	})
	.state('permissao', {
		url: 'permissao',
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/permissoes.html',
				controller: 'PermissaoController'
			}
		}
	})

	$urlRouterProvider.otherwise('/');

}])

app.service('UsuarioService', ['$rootScope','$http', function($rootScope, $http){

	this.getUserInfo = function(id){

		$http.get(url+'user-info/'+id).then(function(data){
			console.log('data', data);
			return data;
		})
	}
}])

