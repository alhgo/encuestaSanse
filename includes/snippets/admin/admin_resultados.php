<?php

require_once('includes/toolkit.php');

//Opciones de edad
$edades = (isset($_GET['edades'])) ? $_GET['edades'] : 0;

$encuesta = new Encuesta;

$respuestas = $encuesta->getRespuestasResults($edades);

$results = new Results;


?>

<h1>Respuestas realizadas</h1>
<hr>
<div class="row">
	<div class="col-12 text-center">
		<form action="" method="get">
			<div class="form-check-inline">
			  <label class="form-check-label">
				<input type="radio" class="form-check-input" name="edades" value="0" <?php echo ($edades == 0) ? 'checked' : '' ?>> Todos
			  </label>
			</div>
			<div class="form-check-inline">
			  <label class="form-check-label">
				<input type="radio" class="form-check-input" name="edades" value="1" <?php echo ($edades == 1) ? 'checked' : '' ?>> De 18 a 30
			  </label>
			</div>
			<div class="form-check-inline">
			  <label class="form-check-label">
				<input type="radio" class="form-check-input" name="edades" value="2" <?php echo ($edades == 2) ? 'checked' : '' ?>> De 30 a 45
			  </label>
			</div>
			<div class="form-check-inline">
			  <label class="form-check-label">
				<input type="radio" class="form-check-input" name="edades" value="3" <?php echo ($edades == 3) ? 'checked' : '' ?>> De 45 a 67
			  </label>
			</div>

			<div class="form-check-inline">
			  <label class="form-check-label">
				<input type="radio" class="form-check-input" name="edades" value="4"> Más de 65
			  </label>
			</div>
		<input type="hidden" name="action" value="stats">
		<button type="submit" class="btn btn-primary">Actualizar</button>
		</form>
	</div>
</div>
<hr class="style-one">
<div class="container">
    <div class="row">
		
        <div class="col-12">
			<h5>1.- <?= $respuestas['radio'][1]['texto'] ?></h5>
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart1"></canvas>
                </div>
            </div>
        </div>
	</div> 
	<hr class="style-one">
	<div class="row">
		
		<div class="col-12">
			<h5>2.- <?= $respuestas['radio'][2]['texto'] ?></h5>
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
	</div>
	<hr class="style-one">
     
	
	<h5>3.- Responda si está de acuerdo, o no con las siguientes frases: El Ayuntamiendo de Sanse...</h5>
	<div class="row">
		
		<?php for($n=3;$n<=21;$n++) : ?>
		<div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart<?= $n ?>"></canvas>
                </div>
            </div>
        </div>
		<?php endfor ?>
	</div>
	<hr class="style-one">
	<h5>4.- A su juicio ¿Cuáles son los tres problemas más importantes de San Sebastián de los Reyes?</h5>
	<?php foreach($respuestas['texto'][22] AS $key => $val) : ?>
	
	<!--pregunta abierta-->
	<div id="accordion">

	  <div class="card">
		<div class="card-header">
		  <a class="card-link" data-toggle="collapse" href="#collapse22_<?= $key ?>">
			Encuestado <?= $key ?>
		  </a>
		</div>
		<div id="collapse22_<?= $key ?>" class="collapse show" data-parent="#accordion">
		  <div class="card-body">
			<?php foreach($val AS $seccion => $text){
					echo '<p>' . $seccion . '.- ' . $text . '</p>';
				} 
			  ?>
		  </div>
		</div>
	  </div>

	</div>
	<?php endforeach ?>
	
	<hr class="style-one">
	<h5>5.- Valore del 1 al 5 la atención que, a su juicio, el actual Gobierno Municipal ha prestado a esos problemas, siendo 1 la menor atención y 5 la mayor:</h5>
	<div class="row">
		
		<?php for($n=23;$n<=34;$n++) : ?>
		<div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart<?= $n ?>"></canvas>
                </div>
            </div>
        </div>
		<?php endfor ?>
		
	</div>
	
	<!--pregunta abierta-->
	<div id="accordion">

	  <div class="card">
		<div class="card-header">
		  <a class="card-link" data-toggle="collapse" href="#collapseOne">
			Mostrar respuesta abierta:
		  </a>
		</div>
		<div id="collapseOne" class="collapse show" data-parent="#accordion">
		  <div class="card-body">
			<?php echo $results->showTextRadioResponse(35,5) ?>
		  </div>
		</div>
	  </div>

	</div>
	<!--fin pregunta abierta-->
	
	
	<hr class="style-one">
	<h5>6.- Indique hasta tres proyectos que le gustaría que San Sebastián de los Reyes pusiera en marcha en el futuro.</h5>
	<?php foreach($respuestas['texto'][36] AS $key => $val) : ?>
	
	<!--pregunta abierta-->
	<div id="accordion">

	  <div class="card">
		<div class="card-header">
		  <a class="card-link" data-toggle="collapse" href="#collapse36_<?= $key ?>">
			Encuestado <?= $key ?>
		  </a>
		</div>
		<div id="collapse36_<?= $key ?>" class="collapse show" data-parent="#accordion">
		  <div class="card-body">
			<?php foreach($val AS $seccion => $text){
					echo '<p>' . $seccion . '.- ' . $text . '</p>';
				} 
			  ?>
		  </div>
		</div>
	  </div>

	</div>
	<?php endforeach ?>
	
	<hr class="style-one">
	<h5>7.-  Indique cómo de prioritarias son en su opinión las siguientes responsabilidades de la gestión municipal:</h5>
	<div class="row">
		
		<?php for($n=37;$n<=50;$n++) : ?>
		<div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart<?= $n ?>"></canvas>
                </div>
            </div>
        </div>
		<?php endfor ?>
	</div>
	
	<hr class="style-one">
	<h5>8.- Piense cómo le gustaría que fuese San Sebastián de los Reyes dentro de cuatro años. Ahora escriba tres frases relacionadas con su idea.</h5>
	<?php foreach($respuestas['texto'][51] AS $key => $val) : ?>
	
	<!--pregunta abierta-->
	<div id="accordion">

	  <div class="card">
		<div class="card-header">
		  <a class="card-link" data-toggle="collapse" href="#collapse51_<?= $key ?>">
			Encuestado <?= $key ?>
		  </a>
		</div>
		<div id="collapse51_<?= $key ?>" class="collapse show" data-parent="#accordion">
		  <div class="card-body">
			<?php foreach($val AS $seccion => $text){
					echo '<p>' . $seccion . '.- ' . $text . '</p>';
				} 
			  ?>
		  </div>
		</div>
	  </div>

	</div>
	<?php endforeach ?>
	
	
</div>
<p class="mt-5">&nbsp;</p>
	
	
	


<script>
	<?php
		echo $results->showChart("myChart1", $respuestas['radio'][1]);
		echo $results->showChart("myChart2", $respuestas['radio'][2]);
		
							
		for($n=3;$n<=21;$n++) {
			echo $results->showChart("myChart" . $n, $respuestas['radio'][$n],$respuestas['radio'][$n]['texto'],false);
		}	
							
		for($n=23;$n<=34;$n++) {
			echo $results->showChart("myChart" . $n, $respuestas['radio'][$n],$respuestas['radio'][$n]['texto'],false);
		}
							
												
		for($n=37;$n<=50;$n++) {
			echo $results->showChart("myChart" . $n, $respuestas['radio'][$n],$respuestas['radio'][$n]['texto'],false);
		}
				
	?>
</script>
	

