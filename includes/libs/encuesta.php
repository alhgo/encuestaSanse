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
	
	public function encuestadoCheck($id='',$token='')
	{
		if(trim($id) == '' || trim($token) == '')
		{
			throw new Exception("Los datos del enlace no son correctos");
		}
		
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
							<p>Se ha recibido la solicitud para participar en la '" . $site->title . "'. Visite el siguiente enlace para acceder a la encuesta online $url_confirm </p>
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
	
	public function getPreguntas()
	{
		$db = $this->db;
		
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
		return $preguntas;
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
		$encuesta = '<h3>Responder a las preguntas que aparecen a continuación.</h3>
		<h6>Usuario: ' . $encuestado['nombre'] . '(' . $encuestado['correo'] . ')</h6>
		<hr class="style-one">
		<form action="encuesta.php?action=entregar" method="post" id="form-encuesta">';
		
		
		$preguntas = $this->getPreguntas();
		
		//Construimos la encuesta
		$encuesta .= $this->preguntaTipoRadio($preguntas[1], 1);
		$encuesta .= '<hr class="style-one">';
		$encuesta .= $this->preguntaTipoRadio($preguntas[2], 2);
		$encuesta .= '<hr class="style-one">';
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
		<hr class="style-one">';
		
		//Pregunta 4 (id 22)
		$encuesta .= $this->preguntaTipoTexto($preguntas[22], 4);
		
		$encuesta .= '<hr class="style-one">';
		
		//Pregunta 5 
		$encuesta .= '<h5>5.- Valore del 1 al 5 la atención que, a su juicio, el actual Gobierno Municipal ha prestado a esos problemas, siendo 1 la menor atención y 5 la mayor:</h5>';
		$encuesta .= '<table class="table table-striped">';
		$encuesta .= $this->preguntaTableHead("Problema",5,6);
		//Por cada opción de la pregunta 3 (desde el ID 23 hasta el 34)
		for($n=23;$n<=34;$n++)
		{
			if(isset($preguntas[$n])) $encuesta .= $this->preguntaTipoRadio($preguntas[$n],'',true);
		}
		//Pregunta de enunciado abierto
		$encuesta .= $this->preguntaTipoRadioVariable($preguntas[35]);
		
		$encuesta .= '</tbody>
		</table>
		<hr class="style-one">';
		
		//Pregunta 6 (id 36)
		$encuesta .= $this->preguntaTipoTexto($preguntas[36], 6);
		
		$encuesta .= '<hr class="style-one">';
		
		//Pregunta 7
		$encuesta .= '<h5>7.- Indique cómo de prioritarias son en su opinión las siguientes responsabilidades de la gestión municipal:</h5>';
		$encuesta .= '<table class="table table-striped">';
		$encuesta .= $this->preguntaTableHead("Área de responsabilidad",6,5);
		//Por cada opción de la pregunta 7 (desde el ID 37 hasta el 50)
		for($n=37;$n<=50;$n++)
		{
			if(isset($preguntas[$n])) $encuesta .= $this->preguntaTipoRadio($preguntas[$n],'',true);
		}
		
		$encuesta .= '</tbody>
		</table>
		<hr class="style-one">';
		
		//Pregunta 8 (id 51)
		$encuesta .= $this->preguntaTipoTexto($preguntas[51], 8);
		
		
		$encuesta .= '<hr>
		<div class="checkbox">
		  <label><input type="checkbox" name="suscriptor" value="si"> Esta encuesta es anónima, pero si quieres recibir información periódica de nuestras propuestas y actuaciones marca este recuadro.</label>
		</div>
		
		<input type="hidden" name="id_encuestado" value="' . $id_encuestado . '">
		<p><button type="submit" class="btn btn-primary" id="rellenar-button">Entregar</button></p>
		</form>
		<p class="mb-5">&nbsp;</p>

		';
		
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
	<td class="text-center">
		<input type="radio" class="form-check-input ml-0" name="pregunta[' . $data['id_pregunta'] . ']" value="' . $key . '" title="' . $val . '">
	</td>';
			}
			
		$texto .= '</tr>';
		}
		

		
		return $texto;
		
	}
	
	private function preguntaTipoRadioVariable($data, $num='')
	{
		$tit = ($num != '') ? $num . ".- " . $data['texto'] : $data['texto'];
			
			$texto = '
	<tr>
      <th scope="row">&#9659; ' . $tit . '<br>
	  <div class="col-12">
	  	<input type="text" name="pregunta_texto[' . $data['id_pregunta'] . '][]" class="form-control form-control-sm"></th>
	  </div>';
			foreach($data['opciones'] AS $key => $val)
			{
				$texto .= '
	<td class="text-center">
		<input type="radio" class="form-check-input ml-0" name="pregunta[' . $data['id_pregunta'] . ']" value="' . $key . '" title="' . $val . '">
	</td>';
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
		<th scope="col" >' . $pregunta . '</th>';
		//Obtenemos las opciones de la ID pasada
		$db = $this->db;
		$db->where ('id_opt', $id_opt);
		$result = $db->getOne ('options');
		if($db->count != 0)
		{
			for($n=1; $n<=$num_opt;$n++)
			{
				$txt .= '<th scope="col" class="text-center">' . $result['opt_' . $n] . '</th>';
			}
		}
		
      
      $txt .= '
    </tr>
  </thead>
  <tbody>';
		
		return $txt;
	}
	
	public function rellenarEncuesta($data) 
	{
			
		$db = $this->db;
		$id_encuestado = $data['id_encuestado'];
		
		//Comprobamos que el usuario no haya rellenado ya la encuesta
		$db->where('id_encuestado',$id_encuestado);
		$encuestado = $db->getOne('encuestados');
		if($encuestado['terminada'] == 1){
			throw new Exception("El usuario al que corresponde este enlace ya ha realizado la encuesta.");
			return 0;
		}
		else {

			//Ponemos el contador a 0
			$n = 0;
			//Insertamos las respuestas tipo radio
			foreach($data['pregunta'] AS $key => $val)
			{
				$insert = Array ("id_encuestado" => $id_encuestado,
							   "id_pregunta" => $key,
							   "opt" => $val
				);
				$id = $db->insert ('respuestas', $insert);
				if($id) $n++;
			}

			//Insertamos las respuestas tipo texto
			foreach($data['pregunta_texto'] AS $key => $val)
			{
				$id_pregunta = $key;
				foreach($data['pregunta_texto'][$id_pregunta] AS $seccion => $texto)
				{
					if(trim($texto) != '')
					{
						$insert = Array ("id_encuestado" => $id_encuestado,
									   "id_pregunta" => $id_pregunta,
									   "seccion" => $seccion,
									   "respuesta" => $texto
						);
						$id = $db->insert ('respuestas_largas', $insert);	
						if($id) $n++;
					}
				}

			}

			//Actualizamos el encuestado para que ni pueda rellenar más encuestas
			$suscr = (isset($data['suscriptor'])) ? 1 : 0;
			$update = Array (
				'terminada' => 1,
				'suscriptor' => $suscr
			);
			$db->where ('id_encuestado', $id_encuestado);
			$db->update ('encuestados', $update);

			return $n;
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
	
	//Resultados de las encuestas
	public function getEncuestadosResults($id_encuestado='')
	{
		$db = $this->db;
		$return = array();
		if($id_encuestado != '') $db->where('id_encuestado',$id_encuestado);
		$encuestados = $db->get('encuestados');
		
		//Por cada encuestado obtenemos el número de respuestas dadas
		foreach($encuestados AS $key => $value)
		{
			$return[$value['id_encuestado']] = [
				'id_encuestado' => $value['id_encuestado'],
				'nombre' => $value['nombre'],
				'correo' => $value['correo'],
				'registered' => $value['registered'],
				'sexo' => $value['sexo'],
				'edad' => $value['edad'],
				'id_zona' => $value['id_zona'],
				'terminada' => $value['terminada'],
				'suscriptor' => $value['suscriptor'],
				'respuestas' => array()
			];
			
			//Obtenemos el nº de respuestas dadas de tipo radio
			$db->where('id_encuestado',$value['id_encuestado']);
			$db->get('respuestas');
			$return[$value['id_encuestado']]['respuestas']['radio'] = $db->count;
			//Obtenemos el nº de respuestas dadas de tipo desarrollo
			$db->where('id_encuestado',$value['id_encuestado']);
			$db->get('respuestas_largas');
			$return[$value['id_encuestado']]['respuestas']['texto'] = $db->count;
		}
		
		return $return;
		
	}
	
	public function getRespuestasResults($id_pregunta='')
	{
		$db = $this->db;
		//Obtenemos las preguntas
		$preguntas = $this->getPreguntas();
		
		$resultados = ['radio' => array(),'texto' => array()];
		//Por cada pregunta, obtenemos los resultados
		foreach($preguntas AS $id => $data)
		{
			//Preguntas de respuesta cerrada
			if($data['tipo'] == 1)
			{
				$resultados['radio'][$id] = [
					'texto' => $data['texto'],
					'resultados' => array()
				];
				//Obtenemos los resultados
				foreach($data['opciones'] AS $id_opt => $text_opt)
				{
					//Obtenemos el número de respuestas
					$db->where('id_pregunta',$id);
					$db->where('opt',$id_opt);
					$db->get('respuestas');
					//Añadimos el resultado al array
					$resultados['radio'][$id]['resultados'][$text_opt] = $db->count;
				}
			}
			else if($data['tipo'] == 2)
			{
				$resultados['texto'][$id] = array();
				//Buscamos las respuestas dadas a esa pregunta
				
			}
			
		}
		
		//print_r($resultados);
		/*
		$db = $this->db;
		$respuestas = array();
		
		$respuestas['radio'] = $db->get('respuestas');
		$respuestas['texto'] = $db->get('respuestas_largas');
		*/
		return $resultados;
		
	}
	
	
}

class charts {
	
	public function showChart($domId, $data)
	{
		//Construimos las opciones
		$options = "[";
		$values = "[";
		foreach($data['resultados'] AS $texto => $resultado)
		{
			$options .= '"' . $texto . '",';
			$values .= $resultado . ',';
		}
		$options .= "]";
		$values .= "]";
		
		$txt = 'var ctx = document.getElementById("' . $domId . '").getContext(\'2d\');
var myChart = new Chart(ctx, {
    type: \'pie\',
    data: {
        labels: ' . $options . ',
        datasets: [{
            label: \'# of Votes\',
            data: ' . $values . ',
            backgroundColor: [
                \'rgba(255, 99, 132, 0.7)\',
                \'rgba(54, 162, 235, 0.7)\',
                \'rgba(255, 206, 86, 0.7)\',
                \'rgba(75, 192, 192, 0.7)\',
                \'rgba(153, 102, 255, 0.7)\',
                \'rgba(255, 159, 64, 0.7)\'
            ],
            borderColor: [
                \'rgba(255,99,132,1)\',
                \'rgba(54, 162, 235, 1)\',
                \'rgba(255, 206, 86, 1)\',
                \'rgba(75, 192, 192, 1)\',
                \'rgba(153, 102, 255, 1)\',
                \'rgba(255, 159, 64, 1)\'
            ],
            borderWidth: 1
        }]
    },
    options: {
		title: {
            display: true,
            text: \'' . $data['texto'] . '\'
        }
    }
});
';

return $txt;
	}
}