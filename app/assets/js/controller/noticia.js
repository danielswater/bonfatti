
app.controller('NoticiaController', function($scope, $http, toaster, $stateParams, $rootScope){

	$scope.noticias = {};
	$scope.tabelaNoticia = [];

	$scope.clear = function () {
		$scope.noticias.data_inicio = null;
	};

	$scope.toggleMin = function() {
		$scope.minDate = $scope.minDate ? null : new Date();
	};
	$scope.toggleMin();

	$scope.open = function($event) {
		$event.preventDefault();
		$event.stopPropagation();

		$scope.opened = true;
	};

	$scope.open2 = function($event) {
		$event.preventDefault();
		$event.stopPropagation();

		$scope.opened2 = true;
	};

	$scope.dateOptions = {
		formatYear: 'yy',
		startingDay: 1
	};

	$scope.formats = ['dd/MM/yyyy','shortDate'];
	$scope.format = $scope.formats[0];

	$scope.froalaOptions = {
		tableResizerOffset: 10,
		tableResizingLimit: 50,
		imageUploadParam: 'file',
		imageUploadMethod: 'POST',
		imageUploadURL: $rootScope.url+'imagem',
		language: 'pt_br',
		height: 300,
		placeholderText: '',
		events :{
			'froalaEditor.image.beforeUpload': function(e, editor, images){
			},
			'froalaEditor.image.uploaded': function(e, editor, response){
				$scope.imagem = JSON.parse(response);
			},
			'froalaEditor.image.inserted': function(e, editor, $img, response){
				//console.log('imagem inserida', $img[0].src);
			},
			'froalaEditor.image.removed': function(e, editor, $img) {
				$http.post(url+'remove-imagem', $scope.imagem).then(function(data){
					
				})
			},
			'froalaEditor.image.error': function(e, editor, error, response){
			}

		}
	}

	$scope.submitForm = function(isValid){
		$scope.submitted = true;
		if(isValid){
			$http.post($rootScope.url+'noticia', $scope.noticias).then(function(data){
				if(data.data.sucesso){
					toaster.pop('success', "Sucesso", data.data.mensagem, 5000);
				}
				else{
					toaster.pop('error', "Erro", data.data.mensagem, 5000);
				}
			})
		}
	}

	$scope.reset = function(form) {
		$scope.submitted = false;
		form.$setPristine();
		form.$setUntouched();
		$scope.noticias = {};
	};

	$scope.limpaNoticia = function(){
		$scope.noticias = {};
	}

	$scope.getNoticia = function(id){
		$http.get($rootScope.url+'noticia/'+id).then(function(data){
			$scope.noticias = data.data.noticia;
			$scope.tabelaNoticia = $scope.noticias;
			$scope.paginacao($scope.noticias);
		})
	}

	$scope.filtrarNoticia = function(){

		if($scope.noticias.data_inicio){
			$scope.noticias.data_inicio = moment($scope.noticias.data_inicio).format('YYYY-MM-DD');
		}
		if($scope.noticias.data_fim){
			$scope.noticias.data_fim = moment($scope.noticias.data_fim).format('YYYY-MM-DD');
		}
		if((new Date($scope.noticias.data_inicio).getTime() > new Date($scope.noticias.data_fim).getTime())){
			toaster.pop('error', "Erro", "A data inicial não pode ser maior que a data final.", 5000);
			return;
		}
		if($scope.noticias.data_fim && !$scope.noticias.data_inicio){
			toaster.pop('error', "Erro", "Escolha uma data inicial para esse tipo de busca.", 5000);
			return;
		}
		$http.post($rootScope.url+'filtra-noticia', $scope.noticias).then(function(data){
			$scope.noticias = data.data.noticia;
			$scope.tabelaNoticia = $scope.noticias;
			$scope.paginacao($scope.noticias);

		})
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

	if($stateParams.param == 0 && $stateParams.noticia != 0){
		$scope.getNoticia($stateParams.noticia);
	}

})