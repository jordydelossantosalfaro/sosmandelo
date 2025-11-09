<?php
// La contraseña en texto plano que deseas usar
$password_plana = 'Js.2025+-*/';

// Generar el hash usando Bcrypt (el algoritmo por defecto)
$hash_bcrypt = password_hash($password_plana, PASSWORD_BCRYPT);

// Imprimir el hash en la pantalla
echo $hash_bcrypt;
?>