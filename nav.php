<?php
if(isset($_GET['nav'])){
	if($_GET['nav']=='cliente'){
		echo'
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid"> <!-- Fluido -->
		<div class="row">
		<a class="navbar-brand"> <img src="../img/logo.png"  height="45" alt="logo"> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
		<ul class="navbar-nav">
		<li class="nav-item">
		<a class="nav-link" href="arquivos">Arquivos</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="configuracao">Configurações</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="../sair.php">Sair</a>
		</li>
		</ul>
		</div>
		</div>
		</div>
		</nav>

		';
	}else if($_GET['nav']=='adm'){
		echo'
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid"> <!-- Fluido -->
		<div class="row">
		<a class="navbar-brand"> <img src="../img/logo.png"  height="45" alt="logo"> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">

		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse " id="navbarNavDropdown">
		<ul class="navbar-nav justify-content-between">
		<li class="nav-item">
		<a class="nav-link" href="prestador">Corretores</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="empreendimento">Empreendimentos</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="configura">Configurações</a>
		</li>

		<li class="nav-item">
		<a class="nav-link" href="../sair.php">Sair</a>
		</li>

		</ul>
		</div>





		</div>
		</div>

		</nav>';
	}
}

?>
