<?php

require_once('includes/toolkit.php');

$encuesta = new Encuesta;

$encuestados = $encuesta->getEncuestadosResults();

$respuestas = $encuesta->getRespuestasResults();


?>

	<h1>Página de administración</h1>
	<hr>
	<p>Actualmente, se han inscrito para realizar la encuesta <?= count($encuestados) ?> personas.</p>
	<p>Se han respondido a <?= count($respuestas['radio']) ?> preguntas de respuesta cerrada y <?= count($respuestas['texto']) ?> preguntas de respuesta abierta.</p>
	

