var app = angular.module('modulo', ['ngAnimate','toaster', 'ngSanitize','ngCookies','ngResource','ngStorage', 'ngSanitize','ngTouch', 'ui.bootstrap', 'ui.router', 'ckeditor'])

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
	
	$stateProvider
	.state('dash', {
		url : '/',
		views: {
			'content@' : {
				templateUrl : '/bonfatti/app/views/wolgest/dashboard/partials/home.html',
				controller: 'HomeController'
			}
		}
	})
	.state('dash.novo-usuario', {
		url: 'novo-usuario',
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/novo-usuario.html',
				controller: 'UsuarioContoller'
			}
		}
	})
	.state('dash.artigo', {
		url: 'artigo/:id',
		views: {
			'content@' : {
				templateUrl: '/bonfatti/app/views/wolgest/dashboard/partials/artigo.html',
				controller: 'ArtigoController'
			}
		}
	})

	$urlRouterProvider.otherwise('/');

}])

