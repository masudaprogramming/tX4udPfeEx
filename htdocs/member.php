<?php
/*************************************************
 * マイページ起動 
 */

define('_ROOT_DIR', __DIR__ . '/');
require_once _ROOT_DIR . '../php_lib/init.php';
$controller = new MemberMyPageController();
$controller->login();
exit;

?>

