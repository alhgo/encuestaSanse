<?php

require_once('includes/toolkit.php');

$encuesta = new Encuesta;

$encuestados = $encuesta->getEncuestadosResults();

//Obtenemos las zonas y construimos un array
$z = $encuesta->getZonas();
$zonas = array();
foreach($z AS $key => $val)
{
	$zonas[$val['id_zona']] = $val['nombre'];
}


?>

	<h1>Encuestados registrados</h1>
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col" >Nombre - correo</th>
				<th scope="col" class="text-center">Info</th>
				<th scope="col" class="text-center">Fin.</th>
				<th scope="col" class="text-center">Suscr.</th>
				<th scope="col" class="text-center">Resp1.</th>
				<th scope="col" class="text-center">Resp2.</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($encuestados AS $id => $data) : ?>
			<?php $datos = "Datos del encuestado:<br>
ID: " . $data['id_encuestado'] . "<br>
Edad: " . $data['edad'] . "<br>
Sexo: " . $data['sexo'] . "<br>
Zona: " . $zonas[$data['id_zona']] . "<br>
Fecha de registro: " . date('d/m/Y H:i:s',$data['registered']) . "
";
			?>
			<tr>
				<th scope="row"><?= $data['nombre'] . ' - ' . $data['correo'] ?></th>
				<td class="text-center">
					<div class="toolt">
						<a class="fa fa-info-circle"></a>
 						 <span class="toolttext"><?= $datos ?></span>
					</div>
				</td>
				<td class="text-center"><span class="fa fa-<?php echo ($data['terminada'] == 1) ? 'check-circle' : 'times-circle text-danger' ?>"></span></td>
				<td class="text-center"><span class="fa fa-<?php echo ($data['suscriptor'] == 1) ? 'check-circle' : 'times-circle text-danger' ?>"></span></td>
				
				<td class="text-center"><?= $data['respuestas']['radio'] ?></td>
				<td class="text-center"><?= $data['respuestas']['texto'] ?></td>

			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<p></p>
	

