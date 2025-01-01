<?php 
session_start();
require 'conexao.php';

if(isset($_POST['create_usuario'])){
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';  

    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($senha)) {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos obrigatórios.';
        header('Location: index.php');
        exit;
    }
    
    $sql = "INSERT INTO usuarios(nome, email, data_nascimento, senha) VALUES('$nome','$email', '$data_nascimento', '$senha')";
    mysqli_query($conexao, $sql);

    if(mysqli_affected_rows($conexao) > 0){
        $_SESSION['mensagem'] = 'Usuáirio inserido com sucesso!';
        header('Location: index.php');
        exit;
    }else{
        $_SESSION['mensagem'] = 'Erro ao inserir usuário';
        header('Location: index.php');
        exit;
    }
}

if(isset($_POST['update_usuario'])){
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

    if (empty($nome) || empty($email) || empty($data_nascimento)){
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos obrigatórios.';
        header('Location: index.php');
        exit;
    }
    
    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";
    

    if(!empty($senha)){
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha = '$senha_hash'";
    }
    $sql .= " WHERE id = '$usuario_id'";
    mysqli_query($conexao, $sql);
    

    if(mysqli_affected_rows($conexao) > 0){
        $_SESSION['mensagem'] = 'Usuário atualizado com sucesso!<br>';
        header('Location: index.php');
        exit;
    }else{
        $_SESSION['mensagem'] = 'Usuário não foi atualizado!';
        header('Location: index.php');
        exit;
    }
}

if(isset($_POST['delete_usuario'])){
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
    
    $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";
    mysqli_query($conexao, $sql);
    if(mysqli_affected_rows($conexao) > 0){
        $_SESSION['mensagem'] = 'Usuário deletado com sucesso!<br>';
        header('Location: index.php');
        exit;
    }else{
        $_SESSION['mensagem'] = 'Usuário não foi deletado!';
        header('Location: index.php');
        exit;
    }
}

?>