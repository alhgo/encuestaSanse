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
	
	private $db;
	
	function __construct()
	{
		//Obtenemos los datos del sitio
		$site = new Site;
		
		//Conectamos con la base de datos
		if(!$this->db = new MysqliDb (Array (
				'host' => c::get('db.host'),
				'username' => c::get('db.username'), 
				'password' => c::get('db.password'),
				'db'=> c::get('db.database'),
				'port' => c::get('db.port'),
				'prefix' => '',
				'charset' => 'utf8'))
		   )
		{
			die('Se ha producido un problema al conectar con la base de datos' . $db->getLastError());
		}
		
	}
	
	function __destruct(){
		$this->db->disconnect();
	}
	
	public function encuestadoExists($email)
	{
		$db = $this->db;
		$db->where ('correo', $email);
		$result = $db->getOne ('encuestados');
		if($db->count != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function encuestadoCheck($id,$token)
	{
		$db = $this->db;
		//$db->where ('id_encuestado', $id);
		//$db->where ('token', $token);
		//$data = $db->get ('encuestados');
		$data = $db->rawQuery("SELECT * from encuestados where id_encuestado = $id AND token = '$token'");
		
		
		if($db->count === 0)
		{
			throw new Exception("El enlace no es válido. No se encuentra usuario.");
		}
		else if($data[0]['terminada'] == 1)
		{
			
			throw new Exception("El usuario indicado ya ha realizado la encuesta.");
		}
		
		
	}
	
	public function registerEncuestado($datos=array())
	{
		$db = $this->db;
		//Generamos un token
		$token = md5(uniqid(rand(), true));
		//Insertamos los datos
		$data = array(
			'nombre' => $datos['r-name'],
			'correo' => $datos['r-email'],
			'id_zona' => $datos['r-zone'],
			'edad' => $datos['r-birth'],
			'sexo' => $datos['r-sexo'],
			'registered' => $datos['registered'],
			'terminada' => 0,
			'token' => $token
		);
		$id = $db->insert ('encuestados', $data);
		if(!$id)
		{
			throw new Exception("Error al insertar los datos");
		}
		else
		{
			return $id;	
		}
	}
	
	public function getZonas()
	{
		
		$db = $this->db;
		
		if(!$zonas = $db->get('zonas')) {
			die('La base de datos no está correctamente configurada: ' . $db->getLastError());
		}
		
		return $zonas;
		
	}
	
	public function sendCorreo($id)
	{
		$site = new Site;
		//Obtenemos los datos del usuario
		$db = $this->db;
		$db->where ('id_encuestado', $id);
		$data = $db->getOne ('encuestados');
		
		//Enviamos el correo
		//Declaramos las clases	
		$mail = new PHPMailer(true);
		//Desactivamos el modo de debug para que no muestre errores
		$mail->SMTPDebug = false;
		$mail->do_debug = 0;

		//Construimos el cuerpo
		$body = new mailBody; 
		//Construimos el texto de previo para algunos clientes
		$body->bodyPreheader = 'Solicitud recibida desde ' . $site->title;
		//Construimos el cuerpo, que incluye párrafos y un botón
		$url_confirm = c::get('site.url') . 'encuesta.php?u=' . $id . '&t=' . $data['token'];
		//echo $url_confirm;
		$button = $body->bodyButton($url_confirm,"Realizar encuesta");
		$body->bodyContent = "
							<p>Se ha recibido la solicitud para realizar la encuesta de " . $site->title . ". Visite el siguiente enlace para acceder a la encuesta online $url_confirm </p>
							" . $button . "";
		$body->getBodyHTML();

		//Datos del correo
		$mail->setFrom(c::get('mail.from'), c::get('mail.fromName'));
		if(isset($data['name']))
		{
			$mail->addAddress($data['correo'],$data['name']);
		}
		else
		{
			$mail->addAddress($data['correo']);
		}
		$mail->Subject  = 'Solicitud recibida desde ' . $site->title;
		$mail->isHTML(true); //Indicamos que es un correo HTML
		$mail->CharSet = 'UTF-8'; //Convertimos los caracteres a UTF8
		$mail->Body = $body->bodyHTML; //Insertamos el cuerpo construido previamente
		//Enviamos el correo y comprobamos que se ha mandado correctamente	

		try {
			//Desactivamos los errores de la clase PHP Mailer
			@$mail->send();
			return true;

		} catch (Exception $e) {
			//Insertamos un mensaje de error en el LOG
			$error_msg = 'Se ha producido un error al enviar el correo al encuestado (ID: ' . $id . '). Código de error: ' . $mail->ErrorInfo;
			log::putErrorLog($error_msg);

			throw new Exception("Error el enviar el correo." . $url_confirm);

		} 
	}
	
	public function mostrarEncuesta($id_encuestado)
	{
		$db = $this->db;
		//Obtenemos los datos del encuestado
		$db->where ("id_encuestado", $id_encuestado);
		if(!$encuestado = $db->getOne("encuestados")){
			die('Error al obtener los datos el encuestado');
		}
		
		//Creamos el texto de la encuesta
		$encuesta = '<h1>Rellenar la encuesta</h1>
		<h6>' . $encuestado['nombre'] . '</h6>
		<hr>
		<form action="encuesta.php?action=entregar" method="post" id="form-encuesta">';
		
		
		//OBtenemos todas las preguntas
		$p = $db->get('preguntas');
		$preguntas = array();
		//Creamos un array completo con las preguntas 
		foreach($p AS $key => $val)
		{
			$id_pregunta = $val['id_pregunta'];
			$preguntas[$id_pregunta] = array(
				'id_pregunta' => $id_pregunta,
				'texto' => $val['texto'],
				'tipo' => $val['id_tipo']
			);
			//Si es de tipo "radio" (1) seleccionamos las opciones
			if($val['num_opt'] != 0)
			{
				$opts = $db->where('id_opt',$val['id_opt']);
				$opts = $db->getOne("options");
				for($n=1;$n<=$val['num_opt'];$n++)
				{
					$preguntas[$id_pregunta]['opciones'][$n] = $opts['opt_' . $n];
				}
				
			}
		}
		//print_r($preguntas);
		
		//Construimos la encuesta
		$encuesta .= $this->preguntaTipoRadio($preguntas[1], 1);
		$encuesta .= '<hr>';
		$encuesta .= $this->preguntaTipoRadio($preguntas[2], 2);
		$encuesta .= '<hr>';
		//Pregunta 3
		$encuesta .= '<h5>3.- Responda si está de acuerdo, o no con las siguientes frases:</h5>';
		$encuesta .= '<table class="table table-striped">';
		$encuesta .= $this->preguntaTableHead("El Ayuntamiento de Sanse...",3,5);
		//Por cada opción de la pregunta 3 (desde el ID 3 hasta el 21)
		for($n=3;$n<=21;$n++)
		{
			if(isset($preguntas[$n])) $encuesta .= $this->preguntaTipoRadio($preguntas[$n],'',true);
		}
		
		$encuesta .= '</tbody>
		</table>
		<hr>';
		
		//Pregunta 4 (id 22)
		$encuesta .= $this->preguntaTipoTexto($preguntas[22], 4);
		
		
		//Pregunta 5 (id 23)
		$encuesta .= '<h5>5.- Valore del 1 al 5 la atención que, a su juicio, el actual Gobierno Municipal ha prestado a esos problemas, siendo 1 la menor atención y 5 la mayor:</h5>';
		$encuesta .= '<table class="table table-striped">';
		$encuesta .= $this->preguntaTableHead("Problema",5,6);
		//Por cada opción de la pregunta 3 (desde el ID 23 hasta el 34)
		for($n=23;$n<=34;$n++)
		{
			if(isset($preguntas[$n])) $encuesta .= $this->preguntaTipoRadio($preguntas[$n],'',true);
		}
		
		$encuesta .= '</tbody>
		</table>
		<hr>';
		
		$encuesta .= '<hr>
		<input type="hidden" name="id_encuestado" value="' . $id_encuestado . '">
		<p><button type="submit" class="btn btn-primary" id="rellenar-button">Entregar</button></p>
		</form>
		<p class="mb-5">* Al enviar el formulario aceptas las condiciones de uso. Tus datos solo serán utilizados con fines estadísticos y nunca para comunicaciones posteriores, salvo que assí lo indiques.</p>';
		
		return $encuesta;
	}
	
	private function preguntaTipoRadio($data,$num="",$inline=false)
	{
		
		if(!$inline)
		{
			$tit = ($num != '') ? $num . ".- " . $data['texto'] : $data['texto'];
			$texto = '<h5>' . $tit . '</h5>';
			foreach($data['opciones'] AS $key => $val)
			{
				$texto .= '
	<div class="form-check-inline" >
	  <label class="form-check-label">
		<input type="radio" class="form-check-input" name="pregunta[' . $data['id_pregunta'] . ']" value="' . $key . '">' . $val . '
	  </label>
	</div>';
			}
		}
		else
		{
			$tit = ($num != '') ? $num . ".- " . $data['texto'] : $data['texto'];
			
			$texto = '
	<tr>
      <th scope="row">&#9659; ' . $tit . '</th>
	';
			foreach($data['opciones'] AS $key => $val)
			{
				$texto .= '
	<td align="center">
		<input type="radio" class="form-check-input" name="pregunta[' . $data['id_pregunta'] . ']" value="' . $key . '" title="' . $val . '">
	</td>';
			}
			
		$texto .= '</tr>';
		}
		

		
		return $texto;
		
	}
	
	private function preguntaTipoTexto($data,$num="")
	{
		$tit = ($num != '') ? $num . ".- " . $data['texto'] : $data['texto'];
		$texto = '<h5>' . $tit . '</h5>';
		foreach($data['opciones'] AS $key => $val)
			{
				$texto .= '
<div class="form-group">
    <textarea class="form-control" name="pregunta_texto[' . $data['id_pregunta'] . '][' . $key . ']" rows="2" placeholder="' . $val . '"></textarea>
 </div>';
		}
		
		return $texto;
	}
	
	private function preguntaTableHead($pregunta, $id_opt, $num_opt)
	{
		$txt = '
  <thead>
    <tr>
		<th scope="col">' . $pregunta . '</th>';
		//Obtenemos las opciones de la ID pasada
		$db = $this->db;
		$db->where ('id_opt', $id_opt);
		$result = $db->getOne ('options');
		if($db->count != 0)
		{
			for($n=1; $n<=$num_opt;$n++)
			{
				$txt .= '<th scope="col">' . $result['opt_' . $n] . '</th>';
			}
		}
		
		
      
      
      $txt .= '
    </tr>
  </thead>
  <tbody>';
		
		return $txt;
	}
	
	public function resendCorreo($email)
	{
		//Comprobamos que el usuario está registrado
		$db = $this->db;
		$db->where ('correo', $email);
		$result = $db->getOne ('encuestados');
		if($db->count != 0)
		{
			if($result['terminada'] != '1')
			{
				try {
				//Desactivamos los errores de la clase PHP Mailer
				$this->sendCorreo($result['id_encuestado']);
					return "sent";

				} catch (Exception $e) {
					return "No se ha podido enviar el correo. Por favor contacte con el administrador.";
				}

			}
			else
			{
				return "El correo indicado ya ha realizado la encuesta. Póngase en contacto con el administrador si considera que hay algún error";	
			}
			
		}
		else
		{
			return "No hay usuario registrado con ese correo.";
		}
		
	}
	
}