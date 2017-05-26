app.controller('ProcessoIdentificacao', function($scope, $http, UsuarioService, $rootScope, toaster, $stateParams, ProcessoService){
	$scope.botao = true;
	$scope.botao_atualizar = true;
	$scope.processo_identificacao = {};
	$scope.tabelaProcIdentificacao = [];

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.processo_identificacao = {};
	};

	$scope.limpaIdentificacao = function(){
		$scope.processo_identificacao = {};
	}

	$scope.submitForm = function(valid){
		$scope.submitted = true;
		if(valid){
			console.log('scope', $scope.processo_identificacao);			
			$http.post($rootScope.url+'identificacao', $scope.processo_identificacao).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}
	}
	$scope.getProcessoIdentificacao = function(id){
		if(id == undefined){
			ProcessoService.getListaProcessoIdentificacao().then(function(data){
				$scope.tabelaProcIdentificacao = data;
				$scope.paginacao($scope.tabelaProcIdentificacao);
			})
		}
		else{
			$http.get($rootScope.url+'identificacao/'+id).then(function(data){
				$scope.tabelaProcIdentificacao = data.data.processo_identificacao;
				$scope.processo_identificacao = data.data.processo_identificacao;
			})
		}
	}
	$scope.filtraProcessoIdentificacao = function(valid){
		$scope.submitted = true;
		if(valid){
			$http.post($rootScope.url+'filtra-identificacao', $scope.processo_identificacao).then(function(data){				
				$scope.tabelaProcIdentificacao = data.data.processo_identificacao;
				$scope.paginacao($scope.tabelaProcIdentificacao);
			})
		}
	}
	if($stateParams.param == 0){
		$scope.getProcessoIdentificacao($stateParams.identificacao);
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