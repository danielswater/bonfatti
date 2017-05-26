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
		//$scope.tabelaLink = [];
		if(id == undefined){
			$http.get($rootScope.url+'link').then(function(data){
				$scope.tabelaLink = data.data.links;				
				$scope.paginacao($scope.tabelaLink);
			})
		}
		else{
			$http.get($rootScope.url+'link/'+id).then(function(data){
				$scope.tabelaLink = data.data.links;
				$scope.links = data.data.links;
			})
		}
	}
	if($stateParams.param == 0){
		$scope.getLinks($stateParams.link);
	}
	$scope.filtrarLink = function(valid){
		$scope.submitted = true;
		if(valid){
			//$scope.tabelaLink = [];
			$http.post($rootScope.url+'filtra-link', $scope.links).then(function(data){				
				$scope.tabelaLink = data.data.links;
				$scope.paginacao($scope.tabelaLink);
			})
		}
	}
	
	$scope.submitForm = function(valid){
		$scope.submitted = true;
		if(valid){
			console.log('scope', $scope.links);
			$http.post($rootScope.url+'link', $scope.links).then(function(data){
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