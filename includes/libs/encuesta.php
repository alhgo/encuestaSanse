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
		$this->db = new MysqliDb (Array (
                'host' => c::get('db.host'),
                'username' => c::get('db.username'), 
                'password' => c::get('db.password'),
                'db'=> c::get('db.database'),
                'port' => c::get('db.port'),
                'prefix' => '',
                'charset' => 'utf8'));
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
		$db->where ('id_encuestado', $id);
		$db->where ('token', $token);
		$data = $db->get ('encuestados');
		//echo($db->count);
		
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
		$database = $this->db;
		$zonas = $database->get('zonas'); //contains an Array of all users 

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
		$body->bodyPreheader = "Solicitud para realizar encuensta en " . $site->title;
		//Construimos el cuerpo, que incluye párrafos y un botón
		$url_confirm = c::get('site.url') . '/encuesta.php?u&id=' . $id . '&t=' . $data['token'];
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
		$mail->Subject  = 'Solicitud para realizar la encuesta en ' . $site->title;
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
			$error_msg = 'Se ha producido un error al enviar el correo al usuario temporal (ID: ' . $id . '). Código de error: ' . $mail->ErrorInfo;
			log::putErrorLog($error_msg);

			throw new Exception("Error el enviar el correo");

		} 
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