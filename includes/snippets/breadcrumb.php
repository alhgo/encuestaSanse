<?php
$n = 1;
?>
		<div class="pt-0">
			<nav aria-label="breadcrumb">
	  			<ol class="breadcrumb">
		  		<?php foreach($data AS $key => $value) : ?>
		  			<?php if($n != count($data)) : ?>
		  			<li class="breadcrumb-item"><a href="<?= $value ?>"><?= $key ?></a></li>
		  			<?php else : ?>
		  			<li class="breadcrumb-item active" aria-current="page"><?= $key ?></li>
		  			<?php endif ?>
		  		<?php $n++ ?>
		  		<?php endforeach ?>
			</nav>
		</div>