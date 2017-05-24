app.controller('ProcessosRito', function($scope, $http, $rootScope, toaster, $stateParams){
	$scope.botao = true;
	$scope.botao_atualizar = true;
	$scope.processo_rito = {};
	$scope.tabelaProcRito = [];

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
	$scope.getProcessoRito = function(){

	}
	$scope.filtraProcessoRito = function(isValid){
		$scope.submitted = true;
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