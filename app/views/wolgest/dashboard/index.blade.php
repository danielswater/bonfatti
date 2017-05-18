<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Bonfatti - Sistema Administrativo </title>

	<!-- Bootstrap -->
	<link href="{{URL::to('app/assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- FROALA -->
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/froala_editor.min.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/froala_style.min.css')}}" rel="stylesheet">
	<!-- FIM DO FROALA -->

	<!-- PLUGINS FROALA -->
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/colors.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/emoticons.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/file.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/image_manager.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/image.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/table.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/css/plugins/video.css')}}" rel="stylesheet">
	<!-- FIM DOS PLUGINS -->

	<link href="{{URL::to('app/assets/css/custom.min.css')}}" rel="stylesheet">
	<link href="{{URL::to('app/assets/css/toaster.css')}}" rel="stylesheet">
</head>

<body ng-app="modulo" class="nav-md">
	<div class="container body ">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<!-- <div class="profile clearfix">
						<div class="profile_pic">
							<img src="images/img.jpg" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2>John Doe</h2>
						</div>
						<div class="clearfix"></div>
					</div> -->
					<!-- /menu profile quick info -->

					<br />

					<div>
						<!-- sidebar menu -->
						<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
							<div class="menu_section">
								
								<ul class="nav side-menu">
									<li><a><i class="fa fa-home" aria-hidden="true"></i> Meu Cadastro <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a ui-sref="usuario({param: '0', usuario: '0'})">Atualizar</a></li>
										</ul>
									</li>
									<li ><a><i class="fa fa-sitemap"></i> Funcionários <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ng-hide="permissao.funcionario_cadastro.incluir == 0 && permissao.funcionario_cadastro.localizar == 0"><a>Cadastro<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li ng-hide="permissao.funcionario_cadastro.incluir == 0"><a ui-sref="usuario({param: '1'})">Cadastrar</a>
													</li>
													<li ng-hide="permissao.funcionario_cadastro.localizar == 0"><a ui-sref="busca-usuario({param: '2'})">Procurar</a>
													</li>
												</ul>
											</li>
											<li ng-hide="permissao.funcionario_permissoes.localizar == 0"><a>Permissões<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li class="sub_menu"><a ui-sref="permissao">Procurar</a>
													</li>
													
												</ul>
											</li>
										</ul>
									</li> 
									<li ng-hide="permissao.boletim.incluir == 0 && permissao.boletim.localizar == 0"><a><i class="fa fa-desktop"></i> Boletins <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ng-hide="permissao.boletim.incluir == 0"><a ui-sref="noticia({param: '1'})">Cadastrar</a></li>
											<li ng-hide="permissao.boletim.localizar == 0"><a ui-sref="busca-noticia({param: '2'})">Procurar</a></li>
										</ul>
									</li>
									<li ng-hide="permissao.links_uteis.incluir == 0 && permissao.links_uteis.localizar == 0"><a><i class="fa fa-table"></i> Links Úteis <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a ui-sref="links({param: '1'})">Cadastrar</a></li>
											<li><a ui-sref="busca-links({param: '2'})">Procurar</a></li>
										</ul>
									</li>
									<li ><a><i class="fa fa-sitemap"></i> Processos <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a>Identificação<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li ><a ui-sref="identificacao({param: '1'})">Cadastrar</a>
													</li>
													<li ><a ui-sref="busca-identificacao({param: '2'})">Procurar</a>
													</li>
												</ul>
											</li>
											<li ><a>Clientes<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li ><a ui-sref="">Cadastrar</a>
													</li>
													<li ><a ui-sref="">Procurar</a>
													</li>
												</ul>
											</li>
											<li ><a>Ritos<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li ><a ui-sref="">Cadastrar</a>
													</li>
													<li ><a ui-sref="">Procurar</a>
													</li>
												</ul>
											</li>
											<li ><a>Cadastro<span class="fa fa-chevron-down"></span></a>
												<ul class="nav child_menu">
													<li ><a ui-sref="">Cadastrar</a>
													</li>
													<li ><a ui-sref="">Procurar</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Contatos <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Cadastrar</a></li>
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Compromissos <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Cadastrar</a></li>
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Caixa <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Cadastrar</a></li>
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Biblioteca <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Cadastrar</a></li>
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Curriculos <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>

									<li ><a><i class="fa fa-desktop"></i> Fale Conosco <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li ><a ui-sref="">Procurar</a></li>
										</ul>
									</li>
									
								</ul>
							</div>

						</div>
					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
						<!-- <div class="sidebar-footer hidden-small">
							<a data-toggle="tooltip" data-placement="top" title="Settings">
								<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
							</a>
							<a data-toggle="tooltip" data-placement="top" title="FullScreen">
								<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
							</a>
							<a data-toggle="tooltip" data-placement="top" title="Lock">
								<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
							</a>
							<a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
								<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
							</a>
						</div> -->
						<!-- /menu footer buttons -->
					</div>
				</div>

				<!-- top navigation -->
				<div class="top_nav">
					<div class="nav_menu">
						<nav>
							<div class="nav toggle">
								<a id="menu_toggle"><i class="fa fa-bars"></i></a>
							</div>

							<ul class="nav navbar-nav navbar-right">
								<!-- <li class="">
									<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<img src="images/img.jpg" alt="">John Doe
										<span class=" fa fa-angle-down"></span>
									</a>
									<ul class="dropdown-menu dropdown-usermenu pull-right">
										<li><a href="javascript:;"> Profile</a></li>
										<li>
											<a href="javascript:;">
												<span class="badge bg-red pull-right">50%</span>
												<span>Settings</span>
											</a>
										</li>
										<li><a href="javascript:;">Help</a></li>
										<li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
									</ul>
								</li> -->

								<!-- <li role="presentation" class="dropdown">
									<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-envelope-o"></i>
										<span class="badge bg-green">6</span>
									</a>
									
								</li> -->
								<li><a href="dashboard/sair"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- /top navigation -->

				<!-- page content -->
				<div class="right_col" role="main" ui-view="content"></div>
				<!-- /page content -->

				<!-- footer content -->
				<footer>
					<div class="pull-right">
						www.bonfattiadvogados.com.br
					</div>
					<div class="clearfix"></div>
				</footer>
				<!-- /footer content -->
			</div>
		</div>

		<!-- Custom Theme Scripts -->
		<script src="{{URL::to('app/assets/jquery/jquery.min.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-locale_pt-br.js')}}"></script>
		<script src="{{URL::to('app/assets/bootstrap/js/bootstrap.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-animate.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-cookie.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-resource.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-sanitize.js')}}"></script>		
		<script src="{{URL::to('app/assets/angular/angular-touch.js')}}"></script>
		<script src="{{URL::to('app/assets/jquery/moment.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/angular-ui-router.js')}}"></script>
		<script src="{{URL::to('app/assets/bootstrap/js/bootstrap-progressbar.js')}}"></script>
		<script src="{{URL::to('app/assets/js/pt-br.js')}}"></script>
		<script src="{{URL::to('app/assets/angular/ngstorage.js')}}"></script>

		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/froala_editor.min.js')}}"></script>

		<!-- FROALA PLUGINS -->
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/emoticons.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/file.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/image.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/image_manager.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/link.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/save.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/table.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/plugins/video.min.js')}}"></script>
		<script src="{{URL::to('app/assets/bower_components/froala-wysiwyg-editor/js/languages/pt_br.js')}}"></script>

		<!-- FIM DOS PLUGINS -->
		
		<script src="{{URL::to('app/assets/js/app.js')}}"></script>
		<script src="{{URL::to('app/assets/js/controller.js')}}"></script>
		<script src="{{URL::to('app/assets/js/custom.min.js')}}"></script>
		<script src="{{URL::to('app/assets/js/toaster.js')}}"></script>
		<script src="{{URL::to('app/assets/js/angular-froala.js')}}"></script>

		<!-- Google Analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-23581568-13', 'auto');
			ga('send', 'pageview');

		</script>
	</body>
	</html>