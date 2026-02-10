<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("SEU_HOST", "SEU_USER", "SUA_SENHA", "SEU_BANCO");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erro conexão"]));
}

$data = json_decode(file_get_contents("php://input"));

$email = $data->email ?? '';
$password = $data->password ?? '';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado"]);
    exit;
}

$user = $result->fetch_assoc();

if(password_verify($password, $user['password'])){

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user['id'],
            "nome" => $user['nome'],
            "email" => $user['email']
        ]
    ]);

}else{
    echo json_encode(["success" => false, "message" => "Senha incorreta"]);
}
