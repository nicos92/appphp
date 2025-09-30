<?php
// Redireccionar a la página de login si no hay nadie logueado
header("Location: public/index.php?ruta=auth/login");
exit();
?>