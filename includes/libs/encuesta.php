<?php
/**
 * Clases para encuesta 
 * PHP Version 5.5.
 *
 * @see       https://github.com/alhgo/encuestaSanse
 *
 * @author    Álvaro Holguera. La Última Pregunta
 * @author    Izquierda Independiente. Iniciativa por San Sebastián de los Reyes
 */

class encuesta {
	
	function __construct()
	{
		//Obtenemos los datos del sitio
		$site = new Site;
		
		//Conectamos con la base de datos
		$this->db = new MysqliDb (Array (
                'host' => c::get('db.host'),
                'username' => c::get('db.username'), 
                'password' => c::get('db.password'),
                'db'=> c::get('db.database'),
                'port' => 3306,
                'prefix' => '',
                'charset' => 'utf8'));
	}
	
	function __destruct(){
		$this->db->disconnect();
	}
	
	
}