<?php
$current = basename( $_SERVER[ 'PHP_SELF' ] );
//Comprobamos que se le ha pasado un menú

?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
		<!--title-->
		<a class="navbar-brand" href="<?= $site->url ?>"><?= $site->title ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
		
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item<?= ($current == 'index.php') ? ' active' : '' ?>">
					<a class="nav-link" href="<?= $site->url ?>"><i class="fa fa-home"></i>
					<?php if($current == 'index.php') : ?>
					<span class="sr-only">(current)</span>
					<?php endif ?>
              		</a>
				</li>
				<!--Array menu-->
				<?php if(isset($menu) && is_array($menu)) : ?>
				<?php foreach($menu AS $key => $val) : ?>
				<li class="nav-item<?= ($current == $val) ? ' active' : '' ?>">
					<a class="nav-link" href="<?= $val ?>">
						<?= $key ?>
					</a>
				</li>
				<?php endforeach ?>
				<?php endif ?>
				<?php if(c::get('use.database')) : ?>
					<!--User menu-->
					<?php if($user->logged) : ?>
						<!-- Dropdown -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						<?= $user->user_data['username'] ?>
							</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="user.php">Mis datos</a>
								<a class="dropdown-item" href="logout.php">Logout</a>
							</div>
						</li>
						<?php if($user->is_admin) : ?>
						<li class="nav-item<?= ($current == 'admin.php') ? ' active' : '' ?>">
							<a class="nav-link" href="admin.php"><i class="fa fa-wrench"></i>
							<?php if($current == 'admin.php') : ?>
							<span class="sr-only">(current)</span>
							<?php endif ?>
							</a>
						</li>
						<?php endif ?>

					<?php else : ?>
					<li class="nav-item">
						<a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
					</li>
					<?php endif ?>
					<!--End User Menu-->
				<?php endif ?>
			</ul>
		</div>
	</div>
</nav>