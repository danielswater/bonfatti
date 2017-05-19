app.controller('UsuarioController', function($state,$scope, $http, $rootScope,toaster, $stateParams, UsuarioService, $rootScope){

	$scope.user = {};
	$scope.botao = true;
	$scope.botao_atualizar = true;

	$scope.getUserInfo = function(id){
		UsuarioService.getInfo(id).then(function(data){
			$scope.user = data;
		});
	}

	$scope.selecionaUsuario = function(id){
		if(id == undefined){
			$scope.tabelaUsuarios = [];
			$scope.tabelaUsuarios = $scope.items;
		}
		else{
			$scope.tabelaUsuarios = [];
			$scope.tabelaUsuarios[0] = $scope.user;
		}
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
		}

	};

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.user = {};
	};

	$scope.limpaUsuario = function(){
		$scope.user = {};
	}
	if($stateParams.param == 0){
		console.log('$stateParams', $stateParams);
		$scope.getUserInfo($stateParams.usuario);
		UsuarioService.usuarioPermissao().then(function(data){			
			if(data.funcionario_cadastro[0].alterar == 0 && $stateParams.usuario != 0){
				$scope.botao = false;
			}
			if(data.funcionario_cadastro[0].incluir == 0){
				$scope.botao_atualizar = false;
			}
		})
	}

	if($stateParams.param == 2){
		UsuarioService.getTodosUsuarios().then(function(data){
			$scope.items = data;
		});
	}

})