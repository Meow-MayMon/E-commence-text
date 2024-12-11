<?php

$hash_code = password_hash("Abc123!@#", PASSWORD_BCRYPT);
echo $hash_code;
echo "<br>" . strlen($hash_code);

// echo password_hash("Th@wMgOo123456", PASSWORD_DEFAULT);
// echo "<br>";
// echo password_hash("Abc123!@#", PASSWORD_DEFAULT);


?>