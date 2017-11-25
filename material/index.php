<?php include_once("../paths.php"); ?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo $path_css ?>padrao.css">
		<link rel="stylesheet" href="<?php echo $path_css ?>bootstrap.min.css">
	</head>
	<body style="overflow: hidden;">
		<div class="container col-md-12">
<?php
			require_once('../db.php');

			$instance = new db();
			$conexao = $instance->conecta_mysql();

			$sql_area_material = "SELECT * FROM materiais_area WHERE status = 'A' ORDER BY nome";
			$res_area_material = mysqli_query( $conexao,$sql_area_direito );
			$row_area_material_view = mysqli_fetch_assoc( mysqli_query( $conexao,$sql_area_direito ) );

			$titulo_cabecalho = "Cadastrar novo material";

			if( $_GET['id'] != '' ){
				$sql = "SELECT * FROM materiais WHERE id = ".$_GET['id'];
				$row = mysqli_fetch_assoc( mysqli_query( $conexao,$sql ) );

				$titulo_cabecalho = "Material: ".$row['titulo'];

				if( $row['id_usuario'] === $_SESSION['id_usuario'] ){
					// inclui o form
					include_once('form.php');
				}else{
					// inclui o view
					include_once('view.php');
				}
			}else{ // ta entrando em form para adicionar novo
				if( isset($_SESSION['usuario_logado']) ){
					$value_titulo_material 	= '';
					$value_corpo_material 	= '';
					$status_a_material	 	= '';
					$status_i_material	 	= '';
					include_once('form.php');
				}else{
?>
					<div class="col-md-12 alert alert-danger" style="text-align: center; margin-top: 20%">
						<strong>Você não está logado!</strong> Clique <a href="<?php echo $path_raiz.'login/'; ?>">aqui</a> para ser redirecionado á página de login
					</div>
<?php
				}
			}
?>
			<div class="row">
				<div class="col-md-12 shadow_bottom" style="height: 70px;">
					<?php include_once('../estrutura/topo_interno.php'); ?>
				</div>
				<div class="col-md-12" align="center" style="min-height: 70px;">
					<h2><?php echo $titulo_cabecalho; ?></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 center-block" style="float: none;">
					
				</div>
			</div>
		</div>
	</body>
	<script src="<?php echo $path_js ?>jquery.min.js"></script>
	<script src="<?php echo $path_js ?>bootstrap.min.js"></script>
	<script>
		var status = '';
		function muda_status(aux){
			status = aux;
		}

		$('#btn_cadastrar').click(function(){
			var titulo 	= $('#titulo').val();
			var area 	= $('#area_atuacao').val();
			var corpo 	= $('#descricao').val();
			if( titulo != '' && area != '' && status != ''&& corpo != '' ){
				// ajax novo material
			}else{
				alert('Para prosseguir é obrigatório preencher todos os campos!');
			}
		});
	</script>
</html>