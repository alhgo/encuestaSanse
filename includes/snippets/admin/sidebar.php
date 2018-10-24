<?php


?>

	<!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block"><!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
      
            <a href="#" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Cerrar</span>
                </div>
            </a>
			<a href="admin.php" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-home fa-fw mr-3"></span>
                    <span class="menu-collapsed">
						Admin
					</span>   
                      
                </div>
            </a>
			<a href="?action=encuestados" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">
						Encuestados
					</span>   
                      
                </div>
            </a>
			<a href="?action=stats" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-signal fa-fw mr-3"></span>
                    <span class="menu-collapsed">
						Estadísticas
					</span>   
                      
                </div>
            </a>
			<a href="logout.php?url=admin.php" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-sign-out fa-fw mr-3"></span>
                    <span class="menu-collapsed">
						Logout
					</span>   
                      
                </div>
            </a>
			<p ></p>
  
        </ul><!-- List Group END-->
		
		<!--SIDE BAR MARKS -->
		<ul id="side_bar">
			
		</ul>
		
    </div><!-- sidebar-container END -->