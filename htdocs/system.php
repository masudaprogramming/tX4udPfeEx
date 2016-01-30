<?php
/*************************************************
 * 管理者実行スクリプト
 * 
 */

define('_ROOT_DIR', __DIR__ . '/');
require_once _ROOT_DIR . '../php_lib/init.php';
$controller = new SystemController();
$controller->run();
exit;

?>