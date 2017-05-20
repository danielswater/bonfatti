<?php
class ProcessosCliente extends Eloquent{
	
	public $timestamps = false;
	protected $table = 'processos_clientes';
	protected $primaryKey = 'cliente_id';
}