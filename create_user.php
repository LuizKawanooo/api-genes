<?php

$conn = new mysqli("genes.mysql.uhserver.com", "genes_user", "{[Genes2019", "genes");

$senhaHash = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nome,email,password)
VALUES ('Luiz','teste@gmail.com','$senhaHash')";

$conn->query($sql);

echo "Usuário criado!";
