<?php
/*************************************************
 * 募集企業実行スクリプト
 * 
 */

define('_ROOT_DIR', __DIR__ . '/');
require_once _ROOT_DIR . '../php_lib/init.php';
$controller = new CustomerController();
$controller->run();
exit;

?>
