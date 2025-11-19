<?php
$password = 'admin123'; // ganti dengan password yang Anda inginkan
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash untuk password '$password':<br><br>";
echo "<code>$hash</code>";
