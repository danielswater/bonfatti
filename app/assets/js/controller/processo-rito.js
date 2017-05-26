app.controller('ProcessosRito', function($scope, $http, $rootScope, toaster, $stateParams){
	$scope.botao = true;
	$scope.botao_atualizar = true;
	$scope.processo_rito = {};
	$scope.tabelaRitos = [];

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.processo_rito = {};
	};

	$scope.limpaRito = function(){
		$scope.processo_rito = {};
	}

	$scope.submitForm = function(isValid){
		$scope.submitted = true;
		if(isValid){
			$http.post($rootScope.url+'rito', $scope.processo_rito).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}
	}
	$scope.filtraProcessoRito = function(valido){
		$scope.submitted = true;
		if(valido){
			$http.post($rootScope.url+'filtra-rito', $scope.processo_rito).then(function(data){
				$scope.tabelaRitos = data.data.processo_rito;
				$scope.paginacao($scope.tabelaRitos);
			})
		}
	}
	$scope.getProcessoRito = function(id){
		if(id == null){
			$http.get($rootScope.url+'rito').then(function(data){
				$scope.tabelaRitos = data.data.processo_rito;
				$scope.paginacao($scope.tabelaRitos);
			})
		}
		else{
			$http.get($rootScope.url+'rito/'+id).then(function(data){
				//$scope.tabelaRitos = data.data.processo_rito;
				$scope.processo_rito = data.data.processo_rito;
			})
		}
	}
	if($stateParams.param == 0){
		$scope.getProcessoRito($stateParams.rito);
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