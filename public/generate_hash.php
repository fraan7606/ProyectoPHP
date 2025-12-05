<?php
// Genera hashes de contraseñas
$password1 = '123456';
$password2 = '123123';

echo "Hash para 123456: " . password_hash($password1, PASSWORD_DEFAULT) . "<br>";
echo "Hash para 123123: " . password_hash($password2, PASSWORD_DEFAULT) . "<br>";

// Verificar si un hash funciona
$testHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
echo "<br>Verificar hash con 123456: " . (password_verify('123456', $testHash) ? 'SÍ' : 'NO') . "<br>";
?>
