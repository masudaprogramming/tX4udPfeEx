<?php
/*************************************************
 * 会員実行スクリプト
 * 
 */

define('_ROOT_DIR', __DIR__ . '/');
require_once _ROOT_DIR . '../php_lib/init.php';
$controller = new MemberController();
$controller->run();
exit;

?>

