

<?php
//---------------------------------------------------
//文字コードの設定
//---------------------------------------------------



//--------------------------------------------------
// デバックモード
//----------------------------------------------------

define("_DEBUG_MODE",false);

//----------------------------------------------------
// SQL関係
//----------------------------------------------------

define("_DB_USER","job23user");
define("_DB_PASS","passjob99");
define("_DB_HOST","localhost");
define("_DB_NAME","job23");
define("_DB_TYPE","mysql");
define("_DSN",_DB_TYPE.":host="._DB_HOST.";dbname="._DB_NAME.";charset=utf8");

//----------------------------------------------------
// セッション名
//----------------------------------------------------

define("_MEMBER_SESSNAME","PHPSESSION_MEMBER");
define("_MEMBER_AUTHINFO","userinfo");

define("_CUSTOMER_SESSNAME","PHPSESSION_CUSTOMER");
define("_CUSTOMER_AUTHINFO","customerinfo");

define("_SYSTEM_SESSNAME","PHPSESSION_SYSTEM");
define("_SYSTEM_AUTHINFO","systeminfo");

//・・・・・・・・・・・・・・・・・・・・
//ファイル設置ディレクトリ
//・・・・・・・・・・・・・・・・・・・・

//php_libの場所を定義

define("_PHP_LIBS_DIR",_ROOT_DIR."../php_lib/");

//classの場所を定義
define("_CLASS_DIR", _PHP_LIBS_DIR ."class/");

//環境変数
define("_SCRIPT_NAME",$_SERVER['SCRIPT_NAME']);

//・・・・・・・・・・・・・・・・・・・・・・・・
// smarty関連設定
//・・・・・・・・・・・・・・・・・・・・・・・・

define( "_SMARTY_LIBS_DIR",         _PHP_LIBS_DIR . "smarty/libs/");
define( "_SMARTY_TEMPLATES_DIR",    _PHP_LIBS_DIR . "smarty/templates/");
define( "_SMARTY_TEMPLATES_C_DIR",  _PHP_LIBS_DIR . "smarty/templates_c/");
define( "_SMARTY_CONFIG_DIR",       _PHP_LIBS_DIR . "smarty/configs/");
define( "_SMARTY_CACHE_DIR",        _PHP_LIBS_DIR . "smarty/cache/");

//・・・・・・・・・・・・・・・・・・・・・・・・・
// 必要なファイルの読み込み
//・・・・・・・・・・・・・・・・・・・・・・・・・

require_once "HTML/QuickForm.php";
require_once "HTML/QuickForm/Renderer/ArraySmarty.php";


//smarty 本体の読み込み
require_once _SMARTY_LIBS_DIR."Smarty.class.php";

//・・・・・・・・・・・・・・・・・・・・・・・・・
// クラスファイルの読み込み
//・・・・・・・・・・・・・・・・・・・・・・・・・

spl_autoload_register(
        
    function($className){
        require_once _CLASS_DIR.$className.".php";
    }
);


?>

