<?php include_once("../paths.php"); ?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo $path_css ?>padrao.css">
		<link rel="stylesheet" href="<?php echo $path_css ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $path_css ?>font-awesome.min.css">
		<link rel="shortcut icon" type="image/png" href="<?php echo $path_midia ?>favicon.png"/>
	</head>
	<body>
		<div class="container col-md-12">
			<div class="row">
				<div class="col-md-12 alert alert-success" id="sucesso" style="text-align: center; display: none;">
					<strong>Sugestão cadastrada com sucesso!</strong> Obrigado.
				</div>
				<div class="col-md-12 alert alert-danger"  id="falha" style="text-align: center; display: none;">
					<strong>Erro ao cadastrar sugestão!</strong> Tente novamente em instantes.
				</div>
				<div class="col-md-12 shadow_bottom" id="topo_nome" style="height: 70px;">
					<?php include_once('../estrutura/topo_interno.php'); ?>
				</div>
				<div class="col-md-12 " align="center" style="min-height: 70px;">
					<h2>Sugestões</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"> 
					<div class="col-md-8 center-block" style="float: none;">
						<form style="margin-top: 2%">
							<div class="form-group">
								<input type="text" class="form-control" id="sugestao_nome" placeholder="Nome">
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="sugestao_email" placeholder="Email">
							</div>
							<div class="form-group">
								<span>Por que cadastrar uma sugestão?</span>
							</div>
							<div class="form-group">
								<input type="radio" name="sugestao_radio" onclick="muda_radio(1);">
								Não encontrei o que procurava
							</div>
							<div class="form-group">
								<input type="radio" name="sugestao_radio" onclick="muda_radio(2);">
								Sugestão sobre o portal
							</div>
							<div class="form-group">
								<input type="radio" name="sugestao_radio" onclick="muda_radio(3);">
								Outras
							</div>
							<div class="form-group">
								<textarea class="form-control" id="sugestao" placeholder="O que pode nos sugerir?" style="min-height: 100px;"></textarea>
							</div>
							<div class="form-group" align="right" style="margin-top: 3%; margin-bottom: 3%;">
								<p>
									<button type="button" class="btn btn-primary btn-sm" id="btn_salvar">
										Enviar Sugestão
									</button>
								</p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="<?php echo $path_js ?>jquery.min.js"></script>
	<script src="<?php echo $path_js ?>bootstrap.min.js"></script>
	<script>
		var opcao_radio = '';

		function muda_radio(aux){
			opcao_radio = aux;
		}

		$('#btn_salvar').click(function(){
			var nome 		= $('#sugestao_nome').val();
			var email 		= $('#sugestao_email').val();
			var sugestao 	= $('#sugestao').val();

			if( nome != '' && email != '' && sugestao != '' && opcao_radio != '' ){
				$.ajax({
					url: "commit.php",
					type: "POST",
					data : {
						nome 		: nome,
						email 		: email,
						causa 		: opcao_radio,
						mensagem 	: sugestao
					},
					success: function(resultado){
						console.log("sucesso: "+resultado);
						if( resultado == 1 ){
							$('#sucesso').show("slow");
							window.setTimeout(function() {
							    window.location.href='<?php echo $path_raiz; ?>';
							}, 5000);
						}else{
							$('#falha').show("slow");
							window.setTimeout(function() {
							    location.reload();
							}, 5000);
						}
				    },
				    error: function(res){
				    	console.log("Erro: "+res);
				    }
				});
			}else{
				$('#falha').show("slow");
				window.setTimeout(function() {
				    location.reload();
				}, 5000);
			}
		});
	</script>
</html>