<?php

require_once('includes/toolkit.php');

$encuesta = new Encuesta;

$respuestas = $encuesta->getRespuestasResults();

$charts = new Charts;
/*
//Obtenemos las zonas y construimos un array
$z = $encuesta->getZonas();
$zonas = array();
foreach($z AS $key => $val)
{
	$zonas[$val['id_zona']] = $val['nombre'];
}
*/

?>

	<h1>Respuestas realizadas</h1>
<div class="container">
    <div class="row">
		<?php foreach($respuestas['radio'] AS $key => $val) : ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart<?= $key ?>"></canvas>
                </div>
            </div>
        </div>
        <?php endforeach ?>
     </div>     
</div>

	
	<pre><?php //print_r($respuestas) ?></pre>
	<p></p>


<script>
	<?php
	foreach($respuestas['radio'] AS $key => $val) {
		echo $charts->showChart("myChart" . $key, $respuestas['radio'][$key]);
	}
	?>
</script>
	

