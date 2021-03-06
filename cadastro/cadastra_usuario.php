<?php
	include_once('../paths.php');
	require_once('../db.php');

	$instance = new db();
	$conexao = $instance->conecta_mysql();

	include_once('../estrutura/auditoria.php');

	$nome 		= $_POST['nome'];
	$telefone 	= $_POST['telefone'];
	$email 		= $_POST['email'];
	$senha 		= $_POST['senha'];

	$sql_valida_dados = "SELECT id FROM usuarios WHERE ( UPPER(nome) = '".strtoupper($nome)."' OR email = '".$email."' )";
	$row_valida_dados = mysqli_fetch_assoc(mysqli_query( $conexao, $sql_valida_dados ));

	if( $row_valida_dados['id'] != '' ){
		echo 2;
	}else{
		$sql = "INSERT INTO usuarios ( nome,
									   fone,
									   email,
									   senha,
									   data_cadastro,
									   data_ultimo_acesso)
							  VALUES ( '".utf8_encode($nome)."',
							  		   '".$telefone."',
							  		   '".$email."',
							  		   '".$senha."',
							  		   CURRENT_TIMESTAMP,
							  		   CURRENT_TIMESTAMP )";

		if( mysqli_query( $conexao, $sql ) ){
			$sql_max = "SELECT MAX(id) AS ultimo FROM usuarios";
			$row_max = mysqli_fetch_assoc( mysqli_query( $conexao,$sql_max ) );

			$nome = explode(" ",$nome);

			$_SESSION['usuario_logado'] = true;
			$_SESSION['id_usuario'] 	= $row_max['ultimo'];
			$_SESSION['nome_usuario']	= $nome[0].' '.$nome[count($nome)-1];

			$imagem_usuario = $path_midia.'perfil/'.$_SESSION['id_usuario'].'.jpg';
			if(!file_exists($imagem_usuario)){ // entra nesse if caso não exista a imagem
				$imagem_usuario = $path_midia.'perfil/avatar.png';
			}

			$_SESSION['foto_usuario']	= $imagem_usuario;

			$acao_auditoria = 'usu ins';
			$descricao_auditoria = 'Cadastro de novo usuario com nome '.$_SESSION['nome_usuario'].' e fone '.$telefone;

			salva_auditoria($conexao,$_SESSION['id_usuario'],$acao_auditoria,$descricao_auditoria,null,null);

			echo 1;			
		}else{
			echo 0;
		}
	}
?>