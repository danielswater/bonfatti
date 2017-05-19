
app.controller('ProcessosCliente', function($scope, $http, $rootScope, toaster, $stateParams, EstadoService,ProcessoService){
	$scope.botao_atualizar = true;
	$scope.botao = true;
	$scope.processos_clientes = {};
	$scope.tabelaProcessoClientes = [];
	$scope.itensIdentificacaoCliente = [];
	$scope.telefoneExtra = false;
	$scope.celExtra = false;
	$scope.labelTel = '+';
	$scope.labelCel = '+';
	$scope.tipos = [		
		{label: 'Empresa', value: 'E'}, {label: 'Pessoa', value: 'P'}
	];	
	//$scope.processos_clientes.cliente_tipo = $scope.tipos[0];
	$scope.listaEstado = EstadoService.getEstados();
	$scope.processos_clientes.cliente_estado = $scope.listaEstado[0];

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.processo_identificacao = {};
	};

	ProcessoService.getListaProcessoIdentificacao().then(function(data){
		$scope.itensIdentificacaoCliente = data;
	})

	$scope.adicionaTelefone = function(){
		$scope.telefoneExtra = !$scope.telefoneExtra;
		$scope.labelTel = $scope.telefoneExtra ? '-' : '+';
	}

	$scope.adicionaCel = function(){
		$scope.celExtra = !$scope.celExtra;		
		$scope.labelCel = $scope.celExtra ? '-' : '+';
	}

	$scope.submitForm = function(isValid){
		$scope.submitted = true;
		if(isValid){
			$http.post($rootScope.url+'clientes', $scope.processos_clientes).then(function(data){
				
			})
			//console.log('processos_clientes', $scope.processos_clientes);
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
