<?php

class LoginController extends BaseController {

	public function getIndex(){
		return View::make('wolgest.login');
		//return Redirect::to('/')->with('message', 'Você não tem acesso permitido!');
	}

	public function postLoginUsuario(){

		if(Request::isMethod('post')){

			if(Auth::attempt(array('func_login' => Input::get('func_login'),'password' => Input::get('func_senha')))){
				return Redirect::to('administrador/dashboard');				
			}
			else{
				return Redirect::to('/wolgest')->with('message', 'E-Mail ou senha incorreto!');
			}
		}
		else{
			return Redirect::to('/wolgest')->with('message', 'Acesso não autorizado!');
		}
	}

}