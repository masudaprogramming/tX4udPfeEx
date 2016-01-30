
<?php

class MemberMyPageController extends BaseController{
    
    public function login(){
                
        $this->auth = new Auth;
        $this->auth->set_authname(_MEMBER_AUTHINFO);    
        $this->auth->set_sessname(_MEMBER_SESSNAME);
        $this->auth->start();    
        $this->member_name();
           
        if($this->auth->check_member()){
            
            $this->run();
            
        }else{
            
            $this->title = "ログインエラー";
            $this->message = "トップページよりログインし直してください";
            $this->file = "message_mypage.tpl";
            $this->view_display();
        }
    }
    
    
    public function run(){
              
        switch($this->type){
            
           //メールボックス
           case "message_box":
           $this->screen_message_box();
           break;
           
           //メッセージの詳細表示
           case "detail_message":
           $this->screen_detail_message();
           break;
           
           //メッセージの返信
           case "reply_message":
           $this->screen_reply_message();
           break;
       
           //応募履歴の閲覧
           case "action":
           $this->screen_action();
           break;
            
           //会員情報の修正
           case "modify":
           $this->screen_member_modify();
           break;
           
           //パスワードの変更
           case "modify_pass":
           $this->screen_modify_pass();
           break;
           
           //退会
           case "delete":
           $this->screen_delete();
           break;
       
           //ログアウト※
           case "logout":
           $this->auth->logout();    
           $this->screen_logout();    
           break;    
           
           default:
           $this->screen_top();
            
        }              
    } 

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//    メッセージボックスの表示
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_message_box(){
         
        $MessageModel = new MessageModel;
        $perPage = 8;
        
        if($this->action == "transmit"){          
           
           $this->title = "送信BOX";
           $this->message = "--送信履歴--";
           $this->file  = "member_transmit_message_list.tpl";
           
           list($data,$count) = $MessageModel->get_transmit_message_list_member_id($_SESSION[_MEMBER_AUTHINFO]['id']);
           list($data,$links) = $this->make_page_link($perPage,$data);
           
           $this->view->assign('data',$data);
           $this->view->assign('count',$count);
           $this->view->assign('links',$links['all']);
           
                   
        }else if($this->action == "receive"){
            
           $this->title = "受信BOX";
           $this->message = "--受信履歴--";
           $this->file  = "member_receive_message_list.tpl";
           
           list($data,$count) = $MessageModel->get_receive_message_list_member_id($_SESSION[_MEMBER_AUTHINFO]['id']);
           list($data,$links) = $this->make_page_link($perPage,$data);
           
           $this->view->assign('data',$data);
           $this->view->assign('count',$count);
           $this->view->assign('links',$links['all']);                    
           
        }       
       $this->view_display();
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//    メッセージの詳細表示
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_detail_message(){        
       
        $message_id = "";        
        unset($_SESSION['message_id']);
                
        if(isset($_GET['message_id'])){
             $message_id = $_GET['message_id'];
        }
        
        if($this->action == "transmit"){
            
             $this->title = "送信メッセージ";
             $this->message = "送信日時";
             $var = "transmit";
             
        }else if($this->action == "receive"){
            
             $this->title = "受信メッセージ";
             $this->message = "受信日時";
             $this->next_type = "reply_message";
             $this->next_action = "form";
             $var = "receive";
             
        }
                
        $this->file = "member_detail_message.tpl"; 
       
        $ActionModel  = new ActionModel;
        $MessageModel = new MessageModel;
        $message_data = $MessageModel->member_detail_message_messsage_id($message_id);
        $process      = $ActionModel->get_action_process_id($message_data['action_id']);
        
        $this->view->assign('var',$var);
        $this->view->assign('process',$process);
        $this->view->assign('data',$message_data);
        
        $this->view_display();
        
    }   
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　メッセージ返信用の関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_reply_message(){
        
        $message_id = "";
        
        $btn1 = "";
        $btn2 = "";
        $reset = "";        
        
        if(isset($_POST['message_id'])){
             $_SESSION['message_id'] = $_POST['message_id'];
        }
                
        $this->make_message_form();
        
                        
        if($this->action == "form"){
            
           $MessageModel = new MessageModel;
           $message_data = $MessageModel->get_message_message_id($_SESSION['message_id']);
        
           $subject = "Re:".$message_data['subject'];
        
           $body    = "\n----------<".$message_data['reg_date'].">----------\n";
           $body   .= $message_data['body'];
           $body    = str_replace('<br />',"",$body);
           $body    = str_replace("\n","\n".'>',$body);
           $body    = "\n\n\n".$body;        
        
           $this->form->setDefaults(array('subject'=>$subject,'body'=>$body));           
           $this->title = "返信画面";           
           $this->next_type   = "reply_message";
           $this->next_action = "confirm";
           $this->file = "reply_message.tpl";     
                      
           $btn1 = "確認";            
            
        }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認"){            
           
           $this->form->freeze();
           
           $this->title = "返信画面";
           $this->message = "<font color='red'>下記をお送りしても宜しいでしょうか？</font>";           
           $this->next_type   = "reply_message";
           $this->next_action = "complete";           
           $this->file = "reply_message.tpl";
           
           $btn1 = "OK";
           $btn2 = "戻る";
            
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
            
           $this->title = "返信画面";           
           $this->next_type   = "reply_message";
           $this->next_action = "confirm";           
           $this->file = "reply_message.tpl";           
           $btn1 = "確認";            
            
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "OK"){
            
           $this->title = "送信完了"; 
           $this->message = "メッセージの送信が完了しました";           
           $data = $this->form->getSubmitValues();           
           $MessageModel = new MessageModel;
           $message_data = $MessageModel->get_message_message_id($_SESSION['message_id']);
           
           //返信済みとmessageに記録
           $MessageModel->modify_message_re_message_id($_SESSION['message_id']);
           //DBの文字制限  subject：100文字／body：1250文字までの容量
           $message_data['subject'] = mb_strimwidth($data['subject'],0,100*2);
           $message_data['body'] = mb_strimwidth($data['body'],0,1000*2);
            
           //DBへの登録
           $MessageModel->regist_member_message($message_data);
           $this->file = "message.tpl";     
           
           unset($_SESSION['message_id']);
           
        }
        
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',$reset); 
       $this->view_display();
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//       応募履歴表示
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_action(){
        
        $this->title = "応募履歴";
        $this->message = "";
        $perPage = 6;
        
        $ActionModel = new ActionModel;
        //actionに登録されたidより、関連する情報も取得
        list($data,$count) = $ActionModel->get_project_action_id($_SESSION[_MEMBER_AUTHINFO]['id']);        
        list($data,$links) = $this->make_page_link($perPage,$data);
        
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('links',$links['all']);
        $this->file = "member_action_list.tpl";
        
        $this->view_display();
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//       会員情報 パス の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function screen_modify_pass(){
        
        $this->make_member_modify_pass_form();
        $btn1 = "";
        $btn2 = "";
        
        if(!$this->form->validate()){
            $this->action = "form";
        }
                
        if($this->action == "form"){
            
            $this->file = "member_modify_pass.tpl";
            $this->title = "パスワード・変更ページ";            
            $this->next_type   = "modify_pass";
            $this->next_action = "complete";            
            $btn1 = "変更";
            $btn2 = "";
            
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "変更"){
        
            $data = $this->form->getSubmitValues();
            
            if(!$this->auth->check_pass($_SESSION[_MEMBER_AUTHINFO]['password'],$data['password_old'])){
               
                $this->file = "member_modify_pass.tpl";
                $this->title = "パスワード・変更ページ";
                $this->message = "現在のパスワードが間違っています。<br>もう一度、間違えると元のページに戻ります！！";                
                $this->type   = "modify_pass";
                $this->action = "complete";                
                $btn1 = "変更";
                $btn2 = "";
                
            }else{
                
                $MemberModel = new MemberModel;
                $data[] = "";
                $data['password'] = $this->auth->get_hash_password($data['password_new1']);
                $data['id']       = $_SESSION[_MEMBER_AUTHINFO]['id'];
                $MemberModel->modify_member_pass($data);
                $_SESSION[_MEMBER_AUTHINFO]['password'] = $data['password'];                
                $this->file = "message.tpl";
                $this->title = "パスワードの変更が完了しました";
                $this->message = "下記よりトップページに戻ってください";     
                               
            }
        }        
        $this->form->addElement('submit','submit1',$btn1);
        $this->form->addElement('submit','submit2',$btn2);
        $this->form->addElement('reset','reset','取り消し');
        $this->view_display();        
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     会員情報 基本情報 の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
       
    public function screen_member_modify($auth=""){       
        
        $btn1 = ""; 
        $btn2 = "";
        $area = ""; 
        $project = "";        
        
        if($this->action == "view" && $this->is_system){
            $MemberModel = new MemberModel;
            $_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_base_info_id($_GET['id']);
        }
        
        $birthday_defaults = array( 'Y' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'],0,4),  
                                    'm' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'],4,2),
                                    'd' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'],6,2));
        
        $hope_start_defaults = array( 'Y' => substr($_SESSION[_MEMBER_AUTHINFO]['hope_start'],0,4),  
                                      'm' => substr($_SESSION[_MEMBER_AUTHINFO]['hope_start'],4,2),
                                      'd' => substr($_SESSION[_MEMBER_AUTHINFO]['hope_start'],6,2));            
        
        $regist_area = $_SESSION[_MEMBER_AUTHINFO]['area_type'];
        $regist_area = explode('/',$regist_area);
        $this->make_form_project_area($regist_area);   
        
        $regist_project = $_SESSION[_MEMBER_AUTHINFO]['project_type'];
        $regist_project = explode('/',$regist_project);
        $this->make_form_project_type($regist_project);
        
        $this->form->setDefaults(
           array(
             'mail'       => $_SESSION[_MEMBER_AUTHINFO]['mail'], 
             'last_name'  => $_SESSION[_MEMBER_AUTHINFO]['last_name'],
             'first_name' => $_SESSION[_MEMBER_AUTHINFO]['first_name'],  
             'birthday'   => $birthday_defaults,   
             'gender'     => array('gender' => $_SESSION[_MEMBER_AUTHINFO]['gender']),
             'hope_start' => $hope_start_defaults,
             'expe_appeal' => $_SESSION[_MEMBER_AUTHINFO]['expe_appeal'] 
           )
        );      
       
        $this->make_member_regist_form_no_pass();
        $this->make_member_regist_add_form();
        
        if(isset($_POST['re'])){
            $data = $this->form->getSubmitValues();
        }
        
        if(isset($data)){
            
           if(!$this->check_area($data,3)){
               $this->area ='希望のエリアを一つ以上選択してください';
               $this->action = "form";
           }
          
           if(!$this->check_project_member($data)){
               $this->project ='希望の職種は一つ以上選択してください';
               $this->action = "form";
           }
             
           if(!$this->form->validate()){
               $this->action = "form";
           }

        }else if($this->action != "view"){
           $this->action = "form"; 
        }
           
    
        if($this->action == "view" && $this->is_system){            
            
            $this->file = "system_member_detail.tpl";
            $this->title = "登録情報";
            $this->message = "--サイトメンバーの詳細を表示しています--";           
            $regist_project = $this->make_view_project_type($_SESSION[_MEMBER_AUTHINFO]['project_type']);
            $this->view->assign('id',$_SESSION[_MEMBER_AUTHINFO]['id']);
            $this->view->assign('birthday',$_SESSION[_MEMBER_AUTHINFO]['birthday']);
            $this->view->assign('gender',$_SESSION[_MEMBER_AUTHINFO]['gender']);
            $this->view->assign('hope_start',$_SESSION[_MEMBER_AUTHINFO]['hope_start']);
            $this->view->assign('data',$regist_project);            
            $btn1 = "更新";
            $btn2 = "削除";
            $this->form->freeze();            
        }
                
        
        if($this->action == "form"){
          
            $this->file = "member_modify.tpl";
            $this->title = "登録情報の修正";
            $this->message = "登録された情報の修正できます！";
            $this->next_type = "modify";
            $this->next_action = "confirm";
            $btn1 = "確認";
            $btn2 = "";
            
        }else if($this->action == "confirm"){
           
            $this->form->freeze();
            $this->file = "member_modify_freeze.tpl";
            $this->title = "登録情報の修正";
            $this->message = "下記で宜しいでしょうか？";
            $this->next_type = "modify";
            $this->next_action = "complete";
            $btn1 = "登録";
            $btn2 = "戻る";
           
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
           
            $this->file = "member_modify.tpl";
            $this->title = "登録情報の修正";
            $this->message = "登録された情報の修正できます！";
            $this->next_type = "modify";
            $this->next_action = "confirm";
            $btn1 = "確認";
            $btn2 = "";         
           
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "登録"){
            
          $MemberModel = new MemberModel();            
          $PrememberModel = new PrememberModel();  
        
            if($_SESSION[_MEMBER_AUTHINFO]['mail'] != $data['mail'] &&
               ($MemberModel->check_member($data) || $PrememberModel->check_member($data))){

               $this->file = "member_modify.tpl";
               $this->title = "登録画面";
               $this->message = "!!!すでにこのメールアドレスは登録されています!!!";
               $this->next_type = "modify";
               $this->next_action = "confirm";
               $btn1        = "確認";
               $btn2        = "";               
               
            }else{
               
               $data['birthday'] = sprintf("%04d%02d%02d",$data['birthday']['Y'],
                                                          $data['birthday']['m'],
                                                          $data['birthday']['d']); 
               $data['gender']   = sprintf("%1d",$data['gender']['gender']);   
               $data['area_type'] = $this->data_area_input($data);
               $data['project_type'] = $this->data_project_input($data);
               $data['hope_start'] = sprintf('%04d%02d%02d',$data['hope_start']['Y'],$data['hope_start']['m'],$data['hope_start']['d']);
               $data['id'] = $_SESSION[_MEMBER_AUTHINFO]['id'];
               
               $MemberModel->modify_member($data);
               
               if($this->is_system){                                    
                   $this->title = "更新完了";
                   $this->message = "会員情報を更新しました";                   
                   $this->URL  = "system.php?type=member_list";
                   $this->URL  .= $this->add_pageID();                                      
               }else{
                   $this->auth->auth_member_ok($data);
                   $this->title = "登録情報の修正が完了しました。";
                   $this->message = "下記よりトップ画面へお戻りください";           
               }            
              $this->file  = "message.tpl";              
            }
        }
       $this->view->assign('area_error',$area);
       $this->view->assign('project_error',$project);
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset','取り消し');
       $this->view_display();
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     会員情報 　削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function screen_delete(){
        
      $btn = "";
      $MemberModel = new MemberModel;
      
      if(isset($_POST['system_delete']) && $_POST['system_delete'] = 'on'){
          $this->action = "confirm";
      }
      
      if($this->action == "confirm"){
          
        if($this->is_system){            
           $this->title = "会員情報削除";
           $this->message  = "[削除]ボタンをクリックすると<br><br>";
           $this->message .= "会員番号&nbsp;<font color='red'>";
           $this->message .= htmlspecialchars($_SESSION[_MEMBER_AUTHINFO]['id'],ENT_QUOTES);
           $this->message .= "</font>番<br><br><font color='red'>";
           $this->message .= htmlspecialchars($_SESSION[_MEMBER_AUTHINFO]['last_name'],ENT_QUOTES);
           $this->message .= htmlspecialchars($_SESSION[_MEMBER_AUTHINFO]['first_name'],ENT_QUOTES);
           $this->message .= "</font>さん<br><br>の情報を削除します。";
           $btn = "削除";           
        }else{         
           $this->title = "退会画面";        
           $this->message  = "下記、退会ボタンをクリックすると<br><br>すべての情報が削除され<br><br>";
           $this->message .= "退会となります。";
           $btn = "退会";           
        }
        
        $this->file        = "member_delete.tpl";
        $this->next_type   = "delete";
        $this->next_action = "complete";        
                
      }else if($this->action == "complete"){
        
        $MemberModel->delete_member($_SESSION[_MEMBER_AUTHINFO]['id']);  
          
        if($this->is_system){            
            
           $this->title = "削除完了";
           $this->message = "会員情報を削除しました";
           $this->URL   = "system.php?type=member_list";
           $this->URL  .= $this->add_pageID();
           $this->file = "message.tpl";      
           
        }else{
            
           $this->title = "退会完了";
           $this->message = "また宜しければご利用ください";
           $this->auth->logout();
           $this->file = "member_delete.tpl";
           
        }
      }
      $this->form->addElement('submit','submit1',$btn);
      $this->view_display();      
    }    
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　トップ　画面  
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function screen_top(){
        
        $this->title = "メンバー!(^^)!マイページ!";
        unset($_SESSION['message_id']);
        $this->file = "member_mypage_top.tpl";
        $this->view_display();
        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　ログアウト　画面  
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function screen_logout(){
        
        $this->title = "ログアウト完了";
        $this->file  = "member_logout.tpl";
        $this->view_display();        
        
    }
    
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
 //　　使用の可否：検討中
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function member_name(){
        
        if(isset($_SESSION[_MEMBER_AUTHINFO]) && $_SESSION[_MEMBER_AUTHINFO]['type'] = "member"){
           
           $name = $_SESSION[_MEMBER_AUTHINFO]['last_name']." ".$_SESSION[_MEMBER_AUTHINFO]['first_name'];
           $this->member_name = $name;
            
        }else{

           $this->member_name = "ゲスト";
        }
    }
    
}

?>

