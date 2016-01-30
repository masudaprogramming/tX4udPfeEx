
<?php

class Auth extends BaseController{
    
    private $authname;//認証情報の格納先名
    private $sessname;//セッション名
    
    
    //・・・名称定義および名称取得の関数・・・
    
    public function set_authname($name){
        $this->authname = $name;
    }
    
    public function get_authname(){
        return $this->authname;
    }
    
    public function set_sessname($name){
        $this->sessname = $name;
    }
    
    public function get_sessname(){
        return $this->sessname;
    }
    
    
    //sessionのスタート
    //sessnameの定義
    public function start(){
        
        if(session_status() === PHP_SESSION_ACTIVE){
            return;
        }
        
        if($this->sessname != ""){
            session_name($this->sessname);
        }
        
        session_start();
    }
    
    
    //メンバーサイドのログイン確認
    public function check_member(){
                
         if(!empty($_SESSION[$this->get_authname()]) && $_SESSION[$this->get_authname()]['id'] >= 1 
                 && $_SESSION[$this->get_authname()]['type'] == "member"){
             return true;
         }
         return false;
    } 
    
    //カスタマーサイドのログイン確認
    public function check_customer(){
                
         if(!empty($_SESSION[$this->get_authname()]) && $_SESSION[$this->get_authname()]['id'] >= 1 
                 && $_SESSION[$this->get_authname()]['type'] == "customer"){
             return true;
         }
         return false;
    } 
    
    
    //システムサイドのログイン確認
    public function check_system(){
        
        if(!empty($_SESSION[$this->get_authname()]) && $_SESSION[$this->get_authname()]['id'] >= 1
                && $_SESSION[$this->get_authname()]['type'] == "system" ){
             return true;
        }
        return false;
    }
    
    
    //パスのチェック
    public function check_pass($hash_pass,$pass){
        
       if($hash_pass == crypt($pass,$hash_pass)){
          
           return TRUE;
           
       }else{
        
           return FALSE;
           
       }
    }
    
    
    //ハッシュパスの取得
    public function get_hash_password($password){
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16,MCRYPT_DEV_URANDOM)),'+','.');
        $salt = sprintf("$2y$%02d$",$cost).$salt;
        $hash = crypt($password,$salt);
        return $hash;        
    }
    
    
    //メンバーサイドからのログイン
    public function auth_member_ok($memberdata){
        
        session_regenerate_id(true);
        $_SESSION[$this->get_authname()] = $memberdata;
        $_SESSION[$this->get_authname()]['type'] = "member";
        
    }
    
    
    //顧客サイドからのログイン
    public function auth_customer_ok($customerdata){
    
        session_regenerate_id(true);
        $_SESSION[$this->get_authname()] = $customerdata;
        $_SESSION[$this->get_authname()]['type'] = "customer";      
        
    }
    
    
    //システムサイドからのログイン
    public function auth_system_ok($systemdata){
        
        session_regenerate_id(true);
        $_SESSION[$this->get_authname()] = $systemdata;
        $_SESSION[$this->get_authname()]['type'] = "system";
        
    }
    
    
    //ログアウト処理
    public function logout(){
    
        $_SESSION = array();
        
        //ini_get() 設定オプションの値をとる
        //クライアント側にセッションIDを保存する設定であるとき
        if(ini_get("session.use_cookies")){
            //セッションクッキーのパラメーターを取得
            $params = session_get_cookie_params();
            setcookie(session_name(),'',time()-42000,
                    $params['path'],$params['domain'],
                    $params['secure'],$params['httponly']);
        }
       session_destroy();
    }
    
    
    //member登録時に利用
    public function session_security(){
        
        if(!($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "登録" )){
                unset($_SESSION['memberdata']);
        }
        
    }
    
    
    
}

?>
