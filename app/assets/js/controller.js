var url = '/bonfatti/administrador/dashboard/';

app.controller('HomeController', function($scope, $http, $rootScope,toaster){

	$scope.user = {};

	$scope.getUserInfo = function(){
		$http.get(url+'user-info').then(function(data){
			$scope.user = data.data.user;
			console.log($scope.user)
		})
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
			//toaster.pop('success', "title", 'TESTE', 5000);
		}

	};

	$scope.getUserInfo();

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

app.controller('ArtigoController', function($scope, $http, $state, $stateParams, $rootScope, $timeout){

	$scope.uploader = {};
	$scope.notedited = true;

	if($stateParams.id){
		$scope.notedited = false;
		$http.get(url+'artigo/'+$stateParams.id).then(function(data){
			$scope.artigo = data.data.artigo;
		});
	}
	else{
		$scope.artigo = {};
	}	

	$scope.options = {
		language: 'pt-br',
		allowedContent: true,
		entities: false
	};

	$scope.salvaArtigo = function(){

		$scope.uploader.flow.opts.target = url+'imagem';
		$scope.uploader.flow.opts.singleFile = true;
		$scope.uploader.flow.opts.simultaneousUploads = 1;
		$scope.uploader.flow.opts.testChunks = false;
		$scope.uploader.flow.opts.permanentErrors = [415, 500, 501];
		$scope.uploader.flow.opts.testMethod = "POST";
		$scope.uploader.flow.upload();

		$scope.uploader = {
			controllerFn: function ($flow, $file, $message) {
				$scope.artigo.imagem = $message;
			}
		}

		$timeout(function(){
			$http.post(url+'artigo', $scope.artigo).then(function(data){
				if(data.data.sucesso){
					$rootScope.mensagem = data.data.mensagem;
					$scope.artigo = {};
					$state.go('dash');
				}
			})
		},1000)
	}

	$scope.removerImagem = function(){
		if(!$scope.notedited){
			$scope.notedited = true;
			delete $scope.artigo.imagem;
		}
		else{
			$scope.uploader.flow.cancel();
		}
		
	}
})
