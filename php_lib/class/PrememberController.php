
<?php

class PrememberController extends BaseController{
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　会員登録時にメールから起動
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function run(){
        
        if(isset($_GET['mail']) && isset($_GET['link_pass'])){
            
            $PrememberModel = new PrememberModel;
            $memberdata = $PrememberModel->check_premember($_GET['mail'],$_GET['link_pass']);
            
            if(!empty($memberdata) && count($memberdata) >= 1 ){
              
              $PrememberModel->delete_premember_and_regist_member($memberdata);
              
              $this->title = "登録完了です";
              $this->message = "トップページよりログインしてください！ｌ";  
                
            }else{
                
              $this->title = "!!!エラー!!!";
              $this->message = "無効なURLです";  
                
            }               
        }else{
           
           $this->title = "!!!エラー!!!";
           $this->message = "無効なURLです";
           
        }                 
        $this->file = "premember.tpl";   
        $this->view_display();
    }    
}    
    

?>

