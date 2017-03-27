<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'funcionario';
	protected $primaryKey = 'func_id';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('func_senha');

	public function getRememberToken()
    {
        return '';
    }
    public function getAuthPassword()
	{
		return $this->func_senha;
	}
	public function getReminderEmail()
	{
		return $this->func_login;
	}
 

    public function setRememberToken($value)
    {
    }


	public static $rules = array(
	    'nome'=>'required|min:2',
	    'email'=>'required|email|unique:users',
	    'password'=>'required|alpha_num|between:6,12'
    );

    public static $form = array(
	    'func_login'=>'required',
	    'func_senha'=>'required'
    );

}
