<?php

class Noticia extends Eloquent{
	
	protected $table = 'noticia';
	public $timestamps = false;
	protected $primaryKey = 'not_id';
}