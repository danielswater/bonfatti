<?php

class CarregaController extends BaseController {

	public function getIndex(){

		$user = new User();
		$user->func_login = "daniel";
		$user->func_senha = Hash::make('123mudar');
		$user->func_departamento = "DESENVOLVIMENTO";
		$user->func_nome = "DANIEL SWATER";
		$user->func_email = "danielswater@gmail.com";

		
		if($user->save()){
			echo "salvo";
		}

	}

}