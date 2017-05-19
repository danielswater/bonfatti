app.controller('PermissaoController', function($scope, $http, UsuarioService, $rootScope, toaster){

	$scope.permissao = {};
	UsuarioService.getTodosUsuarios().then(function(data){
		$scope.items = data;
	});

	$scope.getTabelaPermissao = function(id){
		$http.get($rootScope.url+'tabela-permissoes/'+id).then(function(data){
			$scope.permissao.funcionario_cadastro = data.data.funcionario_cadastro[0];
			$scope.permissao.funcionario_permissoes = data.data.funcionario_permissoes[0];
			$scope.permissao.boletim = data.data.boletim[0];
			$scope.permissao.links_uteis = data.data.links_uteis[0];
			$scope.permissao.processos_identificacao = data.data.processos_identificacao[0];
			$scope.permissao.processos_clientes = data.data.processos_clientes[0];
			$scope.permissao.processos_ritos = data.data.processos_ritos[0];
			$scope.permissao.processos_cadastros = data.data.processos_cadastros[0];
			$scope.permissao.contatos = data.data.contatos[0];
			$scope.permissao.compromissos = data.data.compromissos[0];
			$scope.permissao.caixa = data.data.caixa[0];
			$scope.permissao.biblioteca = data.data.biblioteca[0];
			$scope.permissao.fale_conosco = data.data.fale_conosco[0];
			$scope.permissao.curriculos = data.data.curriculos[0];
			$scope.permissao.estatisticas = data.data.estatisticas[0];

			console.log('$scope.permissao', $scope.permissao);
		})
	}

	$scope.postPermissoes = function(id, update){
		$http.post($rootScope.url+'permissoes/'+id+'/'+update, $scope.permissao).then(function(data){
			if(data.data.sucesso){
				toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
			}
			else{
				toaster.pop('error', "Erro", data.data.mensagem, 5000);
			}
		})
	}

})