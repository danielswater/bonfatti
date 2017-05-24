
app.controller('ProcessosCliente', function($scope, $http, $rootScope, toaster, $timeout,$stateParams, EstadoService,ProcessoService){
	$scope.botao_atualizar = true;
	$scope.botao = true;
	$scope.processos_clientes = {};
	$scope.tabelaProcessoClientes = [];
	$scope.itensIdentificacaoCliente = {};
	$scope.telefoneExtra = false;
	$scope.celExtra = false;
	$scope.labelTel = '+';
	$scope.labelCel = '+';
	$scope.tipos = [		
		{label: 'Empresa', value: 'E'}, {label: 'Pessoa', value: 'P'}
	];
	$scope.listaEstado = EstadoService.getEstados();
	console.log('state cliente', $stateParams);

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.processos_clientes = {};
	};

	ProcessoService.getListaProcessoIdentificacao().then(function(data){
		$scope.itensIdentificacaoCliente = data;
	});	

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
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			});
		}
	}
	$scope.filtraCliente = function(isValid){
		$scope.submitted = true;
		console.log('$scope.tabelaProcessoClientes', $scope.processos_clientes);
		//if(isValid){
			$http.post($rootScope.url+'filtra-cliente', $scope.processos_clientes).then(function(data){
				$scope.tabelaProcessoClientes = data.data.processo_cliente;
				$scope.paginacao($scope.tabelaProcessoClientes);
			})
		//}
	}
	$scope.getCliente = function(id){
		if(id == undefined){
			$http.get($rootScope.url+'clientes').then(function(data){
				$scope.tabelaProcessoClientes = data.data.processo_cliente;
				$scope.paginacao($scope.tabelaProcessoClientes);
			})
		}
		else{
			$http.get($rootScope.url+'clientes/'+id).then(function(data){
				$scope.tabelaProcessoClientes = data.data.processo_cliente;				
				$timeout(function(){
					$scope.processos_clientes = data.data.processo_cliente;
				},500);				
			})
		}
	}
	if($stateParams.param == 0){
		$scope.getCliente($stateParams.cliente);
	}

	$scope.limpaCliente = function(){
		$scope.processos_clientes = {};
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
		$scope.maxSize = 10;
	}

})
