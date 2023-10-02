<?php 

	include('config.php');
	session_start();

	// Verifica se a sessão está vazia (usuário não autenticado)
	if(empty($_SESSION)){
	    header("location: index.php");
	    exit; // Encerra a execução do script para evitar processamento adicional.
	}

	// Verifica se o formulário foi submetido e se todos os campos estão preenchidos
	if(
	    empty($_POST) || 
	    empty($_POST["nome"]) || 
	    empty($_POST["usuario"]) || 
	    empty($_POST["email"]) || 
	    empty($_POST["senha"]) || 
	    empty($_POST["tipo"])
	){
	    header("location: cad.user.php");
	    exit; // Encerra a execução do script para evitar processamento adicional.
	}

	// Recupera os dados do formulário
	$nome = $_POST["nome"];
	$usuario = $_POST["usuario"];
	$email = $_POST["email"];
	$senha = md5($_POST["senha"]);
	$tipo = $_POST["tipo"];
	$dt = date("Y-m-d");

	$sql = "INSERT INTO usuarios_credencial(nome, usuario, email, senha, tipo, data) 
			VALUES(?, ?, ?, ?, ?, ?)";
	if($stmt = $conn->prepare($sql)){
		$stmt->bind_param("ssssss", $nome, $usuario, $email, $senha, $tipo, $dt);
		if($stmt->execute()){
			echo "Registro inserido com sucesso!";
			sleep(2);
			header("location: dashboard.php");
		}
		else{
			echo "Erro ao inserir registro: ". $stmt->error;
		}

		$stmt->close();
	}
	else{
		echo "Erro na preparação da consulta: ". $conn->error;
	}

	$conn->close();