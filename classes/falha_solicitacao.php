<div class="card-group">
	<!-- Faz os campos de texto ocuparem 8 -->
	<div class="card">
	<div class="card-header" style="background-color: #004f7c;">
		<center><h5 style="color:white;">Falha na Solicitação</h5></center>
		<div class="progress">
			<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
		</div>						
	</div>
	<div class="card-body">
		<form name="solicitacao1" id="solicitacao1" action="solicitacao.php" method="get" enctype="multipart/form-data">
			<div class="row">
				<input name="servico" type="text" value="<?php echo $servico;?>" hidden>
				<input name="familiar" type="text" value="<?php echo $familiar;?>" hidden>
				<input name="etapa" type="text" value="4" hidden>
				<p class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> Sua solicitação foi negada.</p>
				<p class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Provavelmente o prestador de serviço já está ocupado neste dia e horário, tente novamente com outro de nossos prestadores ou altere o horário de sua solicitação. </p>
				<p class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Caso enfrente este problema com frequência, contate nosso suporte.</p>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 2.5%;">
				<center>
					<button type="button" class="btn btn-success" onclick="goBack();" style="margin-right: 1%;">Tentar Novamente</button>
					
				</center>
				</div>
			</div>
		</form>
	</div>
</div>
