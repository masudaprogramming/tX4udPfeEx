
<?php

define('_ROOT_DIR',__DIR__.'/');
require_once _ROOT_DIR."../php_lib/init.php";
$PrememberController = new PrememberController;
$PrememberController->run();

?>