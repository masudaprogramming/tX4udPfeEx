
<?php

class CustomerController extends BaseController{
    
    public function run(){
        
        $this->auth = new Auth;
        $this->auth->set_authname(_CUSTOMER_AUTHINFO);
        $this->auth->set_sessname(_CUSTOMER_AUTHINFO);
        $this->auth->start();
        
        if($this->auth->check_customer()){
            $this->company = $_SESSION[_CUSTOMER_AUTHINFO]['company_name'];
            $this->menu_customer();
        }else{
            $this->screen_login();
        }
        
    }
    
    
    
    public function menu_customer(){
        
        switch($this->type){
            
            //案件
            case "list_project":
            $this->screen_list_project();
            break;
        
            //案件登録
            case "regist_project":
            $this->screen_regist_project();
            break;
        
            //更新・削除、動作定義
            case "modify_or_delete_project":
            $this->screen_modify_or_delete_project();
            break;
                
            //案件更新
            case "modify_project":
            $this->screen_modify_project();
            break;
        
            //案件削除
            case "delete_project":
            $this->screen_delete_project();    
            break;
        
            //応募者一覧
            case "applicant_list":
            $this->screen_applicant_list();
            break;
            
            //応募者の詳細確認　process
            case "applicant_detail":
            $this->screen_applicant_detail();
            break;
        
            //応募者 採用・見送りの判断
            case "applicant_process":
            $this->screen_applicant_process();
            break;
            
            //応募者 採用プロセス
            case "applicant_process_open":
            $this->screen_applicant_process_open();
            break;
                    
            //応募者 見送りプロセス
            case "applicant_process_close":
            $this->screen_applicant_process_close();
            break;        

   //・・・・・・・・メッセージ・・・・・・・・・・・・・・・・・・・・・・ 
        
            //メールボックス
            case "message_box":
            $this->screen_message_box();
            break;
        
            //メールの詳細を確認
            case "detail_message":
            $this->screen_detail_message();
            break;       
        
            //メッセージの返信
            case "reply_message":
            $this->screen_reply_message();
            break;
       
            //自社情報訂正
            case "company":
            $this->screen_company();
            break;
            
            //ログアウト
            case "logout":
            $this->screen_logout();
            break;
        
            default :
            $this->screen_top();
        }
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　トップ画面
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・     
    
    public function screen_top(){
             
       $this->title = "顧客管理ページトップ";
       $this->file = "customer_top.tpl";
       
       if(isset($_GET['flag'])){     
          if($_GET['flag'] == "company"){ $this->message = "会社情報を更新しました"; }
      }
       
       unset($_SESSION['id']);
       unset($_SESSION['applicant']);
       unset($_SESSION['message_id']);
       
       $this->view_display();
       
    }
    

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　ログイン画面
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function screen_login(){
        
       //ユーザーネームなどはシステム側で定義するとする               
       $this->make_pass_form();
       $this->title = "顧客ログイン画面";
       $this->file = "login.tpl";
       $CustomerModel = new CustomerModel;        
       
        if($this->form->validate()){
            
           $data = $this->form->getSubmitValues();
           $customerdata = $CustomerModel->get_customer_authinfo($data['mail']);
           
           if($this->auth->check_pass($customerdata['password'],$data['password'])){
               
               $this->auth->auth_customer_ok($customerdata);
               $this->company = $customerdata['company_name'];
               $this->menu_customer();            
               
           }else{
               
               $this->message = "メールもしくはパスワードが違います";
               $this->form->addElement('submit','submit1',"送信");
               $this->form->addElement('reset','reset','リセット');
               $this->view_display(); 
               
           }
           
       }else{     
           
           $this->form->addElement('submit','submit1',"送信");
           $this->form->addElement('reset','reset','リセット');
           $this->view_display(); 
           
       }       
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　ログアウト
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function screen_logout(){
        
        $this->auth->logout();
        $this->screen_login();
        
    }    

       
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　メッセージ一覧　受信／送信
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_message_box(){
        
        $MessageModel = new MessageModel;
        $perPage = 8;
        
        if($this->action == "transmit"){          
            
           $this->title = "送信メッセージ";
           $this->message = "--送信履歴--";
           $this->file  = "customer_transmit_message_list.tpl";
           
           list($data,$count) = $MessageModel->get_transmit_message_list_customer_id($_SESSION[_CUSTOMER_AUTHINFO]['id']);
           list($data,$links) = $this->make_page_link($perPage,$data);
           
           $this->view->assign('data',$data);
           $this->view->assign('count',$count);
           $this->view->assign('links',$links['all']);       
                   
           
        }else if($this->action == "receive"){
            
           $this->title = "受信メッセージ";
           $this->message = "--受信履歴--";
           $this->file  = "customer_receive_message_list.tpl";
           
           list($data,$count) = $MessageModel->get_receive_message_list_customer_id($_SESSION[_CUSTOMER_AUTHINFO]['id']);
           list($data,$links) = $this->make_page_link($perPage,$data);
           
           $this->view->assign('data',$data);
           $this->view->assign('count',$count);
           $this->view->assign('links',$links['all']);
           
        }
       $this->view_display();       
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　メッセージの詳細
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
        $this->title = "メッセージ確認";
        $this->file = "customer_detail_message.tpl";
        
        $MessageModel = new MessageModel;
        $message_data = $MessageModel->get_detail_message_messsage_id($message_id);        
        $this->view->assign('var',$var);
        $this->view->assign('data',$message_data);
        
        $this->view_display();        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//        メッセージ返信用の関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_reply_message(){
                
        $btn1 = "";
        $btn2 = "";
        
        $reset = "";        
        $message_id = "";
        
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
           $this->URL = "customer.php?type=message_box&action=receive";                      
           $data = $this->form->getSubmitValues();
           
           $MessageModel = new MessageModel;
           $message_data = $MessageModel->get_message_message_id($_SESSION['message_id']);
           
           //返信済みとmessageに記録
           $MessageModel->modify_message_re_message_id($_SESSION['message_id']);
           //DBの文字制限  subject：100文字／body：1250文字までの容量
           $message_data['subject'] = mb_strimwidth($data['subject'],0,100*2);
           $message_data['body'] = mb_strimwidth($data['body'],0,1000*2);            
           //DBへの登録
           $MessageModel->regist_customer_message($message_data);          
           $this->file = "message.tpl";                                 
        }        
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',$reset); 
       $this->view_display();
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　応募：メッセージ返信用の関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_applicant_list(){
        
       $this->title = "応募者一覧";
       $perPage = 8;
       
       $ActionModel = new ActionModel;
       list($data,$count) = $ActionModel->get_action_company_id($_SESSION[_CUSTOMER_AUTHINFO]['id']);       
       $data = $this->get_base_applicant_list($data);
       list($data,$links) = $this->make_page_link($perPage,$data);
      
       $this->view->assign('data',$data);
       $this->view->assign('count',$count);
       $this->view->assign('links',$links['all']);
       $this->file = "customer_applicant_list.tpl";
       $this->view_display();
    }
    
  
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　応募：応募者の詳細
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_applicant_detail(){
                  
         if(isset($_POST['member_id']) && isset($_POST['project_reg_date']) && isset($_POST['project_reg_date'])){
             
             unset($_SESSION['applicant']);
             
             $_SESSION['applicant']['member_id'] = $_POST['member_id'];
             $_SESSION['applicant']['project_id'] = $_POST['project_id'];
             $_SESSION['applicant']['project_reg_date'] = $_POST['project_reg_date'];
                          
             $member_id = $_POST['member_id'];             
             $project_reg_date = $_POST['project_reg_date'];
             
         }else{
             
             $member_id = $_SESSION['applicant']['member_id'];
             $project_reg_date = $_SESSION['applicant']['project_reg_date'];
             
         }
         
         $this->title = "--応募者--";
         $this->message  = "この候補者に連絡を取りますか？";
         $this->next_type   = "applicant_process";
         $this->file = "customer_applicant_detail.tpl";         
         
         $MemberModel = new MemberModel;
         $member_data = $MemberModel->get_member_base_info_id($member_id);
                          
         $now = date('Ymd');
         $member_data['age'] = floor(($now-$member_data['birthday'])/10000);
         $member_data['project_reg_date'] = $project_reg_date;
         
         $this->view->assign('data',$member_data);        
         
         $btn1 = "連絡フォームへ";
         $btn2 = "不採用";
        
         $this->form->addElement('submit','submit1',$btn1);
         $this->form->addElement('submit','submit2',$btn2);
         $this->view_display(); 
          
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　応募：採用・不採用の判定プロセス
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_applicant_process(){
            
        if(isset($_POST['submit1']) && $_POST['submit1'] == "連絡フォームへ" ){
            
                $this->screen_applicant_process_open();
                exit;
            
        }else if(isset($_POST['submit2']) && $_POST['submit2'] == "不採用" ){
            
                $this->screen_applicant_process_close();
                exit;
        }        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　応募：採用プロセス
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_applicant_process_open(){
        
        $btn1 = "";
        $btn2 = "";
        $reset = "";
                
        $MemberModel = new MemberModel;
        $CustomerModel = new CustomerModel;
        $member_data  = $MemberModel->get_member_name_info_id($_SESSION['applicant']['member_id']);    
        $project_data = $CustomerModel->get_project_title($_SESSION['applicant']['project_id']);
        
        $subject = "ご応募ありがとうございます。";
        $body    = $member_data['last_name']." ".$member_data['first_name']."様\n\n";
        $body   .= "ご応募いただきありがとうございます。";
        $body   .= "\n\n\n\n\n\n\n\n";
        $body   .= "---------------------------------\n";
        $body   .= "<応募案件>\n";
        $body   .= $project_data."\n";
        $body   .= "http://localhost/index.php?type=detail_project&project_id=".$_SESSION['applicant']['project_id'];       
        
        $setDefaults = array( 'subject' => $subject,
                              'body'    => $body );        
        $this->form->setDefaults($setDefaults);
        $this->make_message_form();
        
        //reに値なし、または　データの値が正しくない
        //その場合、formを実行
        if(!(isset($_POST['re']) && $_POST['re'] == "re") || !$this->form->validate()){            
                $this->action = "form";                       
        }
        
        if($this->action == "form"){
        
            $this->title = "連絡フォーム";
            $this->message = "--下記、応募者の方へメッセージを送信します。--";
            $this->file = "customer_applicant_message_form.tpl"; 
            $this->next_type   = "applicant_process_open";
            $this->next_action = "confirm";            
            $btn1 = "確認";
            $reset = "リセット";
                        
        }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認" ){
            
            $this->form->freeze();            
            $this->title = "連絡フォーム確認";
            $this->message  = "下記を送信しても宜しいでしょうか？<br><br><br>";
            $this->message .= "<font size='4' color='red'>--メッセージを送信すると課金が発生します--</font><br>";            
            $this->file = "customer_applicant_message_form.tpl"; 
            $this->next_type   = "applicant_process_open";
            $this->next_action = "complete";            
            $btn1 = "送信 （課金）";            
            $btn2 = "戻る";
            
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る" ){
            
            $this->title = "連絡フォーム";
            $this->message = "--下記、応募者の方へメッセージを送信します。--";            
            $this->file = "customer_applicant_message_form.tpl"; 
            $this->next_type   = "applicant_process_open";
            $this->next_action = "confirm";            
            $btn1 = "確認";
            $reset = "リセット";
            
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "送信 （課金）" ){
            
            $data = $this->form->getSubmitValues();
            $MessageModel = new MessageModel;
            $ActionModel  = new ActionModel;
            $ActionModel = new ActionModel;
            
            $data['action_id'] = $ActionModel->get_action_some_id($_SESSION['applicant']['member_id'], $_SESSION['applicant']['project_id']);     
            $MessageModel->regist_customer_message_two_data($data,$_SESSION['applicant']);
            /*
            $this->mail_to_applicant($data,$_SESSION['applicant']);                  
            */
            
            $history = "open";
            $ActionModel->regist_action_history($_SESSION['applicant']['project_id'],$history);            
            $this->title = "メッセージ送信完了";
            $this->message  = "メッセージの送信が完了しました。<br><br>";
            $this->URL = "customer.php?type=applicant_list";
            $this->file = "message.tpl";
            
            unset($_SESSION['applicant']);
        }
        
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',$reset);
       $this->view_display();
       
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　　応募：不採用プロセス
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・        
    
    public function screen_applicant_process_close(){
        
        $btn1 = "";
        $btn2 = "";
        $reset = "";
        
        $this->make_message_form();
        
        if(empty($this->action)){          
            
            $MemberModel = new MemberModel;
            $CustomerModel = new CustomerModel;
            $member_data  = $MemberModel->get_member_name_info_id($_SESSION['applicant']['member_id']);    
            $project_data = $CustomerModel->get_project_title($_SESSION['applicant']['project_id']);
                        
            $subject = "不採用のお知らせ";            
            $body    = $member_data['last_name']." ".$member_data['first_name']." 様\n\n";
            $body   .= "このたびは下記のお仕事\n\n";
            $body   .= "「".$project_data."」\n";
            $body   .= "http://localhost/index.php?type=detail_project&project_id=".$_SESSION['applicant']['project_id']."\n\n";
            $body   .= "にご応募いただきありがとうございました。\n\n";
            $body   .= "誠に残念でございますが、\n今回のお仕事は不採用となりました。\n\n";
            $body   .= "何卒、ご了承いただけましたら\n幸いでございます。\n\n";
            $body   .= $_SESSION[_CUSTOMER_AUTHINFO]['company_name'];
            
            $this->form->setDefaults(array('subject'=>$subject,'body'=>$body));
            $this->form->freeze();                 
            $this->title = "見送り";
            $this->message = "不採用の通知をお送りして宜しいでしょうか？";                 
            $this->file = "customer_applicant_message_form.tpl";                 
            $this->next_type   = "applicant_process_close";
            $this->next_action = "complete";
            
            $btn1 = "OK";
            $btn2 = "戻る";          
        
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
            
            $this->screen_applicant_detail();
            exit;
                    
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "OK"){
            
            $data = $this->form->getSubmitValues();
            
            $MessageModel = new MessageModel;
            $ActionModel = new ActionModel;
            
            $data['action_id'] = $ActionModel->get_action_some_id($_SESSION['applicant']['member_id'], $_SESSION['applicant']['project_id']);
            $MessageModel->regist_customer_message_two_data($data,$_SESSION['applicant']);
            $ActionModel = new ActionModel;
            $history = "close";
            $ActionModel->regist_action_history($_SESSION['applicant']['project_id'],$history);
            
            $this->title = "お見送り完了";
            $this->message = "不採用の通知の送付が完了しました。";                 
            $this->file = "message.tpl";            
            
            unset($_SESSION['applicant']);
        }
                   
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->view_display();
       
    }    

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　顧客情報の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・       
    
    public function screen_company($auth = ""){
        
       $btn1 = "";
       $btn2 = "";
       
       if($this->action == "view" && $this->is_system){
            $CustomerModel = new CustomerModel;
            $_SESSION[_CUSTOMER_AUTHINFO] = $CustomerModel->get_customer_authinfo_id($_GET['id']);
        }
       
       $setDefaults = array( 'company_name' => $_SESSION[_CUSTOMER_AUTHINFO]['company_name'],
                             'mail'         => $_SESSION[_CUSTOMER_AUTHINFO]['mail'],
                             'tel'          => $_SESSION[_CUSTOMER_AUTHINFO]['tel'],
                             'address'      => $_SESSION[_CUSTOMER_AUTHINFO]['address'],
                             'appeal'       => $_SESSION[_CUSTOMER_AUTHINFO]['appeal'],
                             'last_name'    => $_SESSION[_CUSTOMER_AUTHINFO]['last_name'],
                             'first_name'   => $_SESSION[_CUSTOMER_AUTHINFO]['first_name']);
        
        $this->form->setDefaults($setDefaults); 
        $this->make_customer_modify_company();
        
        if($this->action == "view" && $this->is_system){
            
            $this->form->freeze();
            $this->title = "情報詳細";
            $this->message = "";
            $this->file = "customer_modify_company.tpl";
            $this->next_type = "modify_or_delete_customer";
            $this->next_action = "form";
            $btn1 = "更新";
            $btn2 = "削除";
            
        }
        
        //　入力値が適切でなく　かつ　$this->actionがviewでない
        if(!$this->form->validate() && $this->action != "view"){
            $this->action = "form";
        }
       
       if($this->action == "form"){
           
          if($this->is_system){
             $this->title = "顧客情報更新";
          }else{
             $this->title = "自社情報編集ページ";
          }
          
          $this->file = "customer_modify_company.tpl";
          $this->next_type = "company";
          $this->next_action = "confirm";
          $btn1 = "確認";
          $btn2 = ""; 
          
       }else if($this->action == "confirm" && $_POST['submit1'] && $_POST['submit1'] == "確認"){
           
          $this->form->freeze();
          
          if($this->is_system){
             $this->title = "顧客情報更新";
          }else{
             $this->title = "自社情報編集ページ";
          }
          
          $this->message = "下記で宜しいですか？";
          $this->file = "customer_modify_company.tpl";
          $this->next_type = "company";
          $this->next_action = "complete";
          $btn1 = "更新";
          $btn2 = "戻る";
           
       }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){    
          
          if($this->is_system){
             $this->title = "顧客情報更新";
          }else{
             $this->title = "自社情報編集ページ";
          }
          
          $this->file = "customer_modify_company.tpl";
          $this->next_type = "company";
          $this->next_action = "confirm";
          $btn1 = "確認";
          $btn2 = "";
           
       }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "更新"){
           
          $data = $this->form->getSubmitValues();
          $data['id'] = $_SESSION[_CUSTOMER_AUTHINFO]['id'];           
          $CustomerModel = new CustomerModel;
          $CustomerModel->modify_customer_company($data);
          
           if($this->is_system){
              $this->title = "更新完了";
              $this->message = "顧客情報の更新が完了しました";
              $this->URL   = "system.php?type=customer_list";
              $this->URL   .= $this->add_pageID();
              $this->file  = "message.tpl"; 
          }else{
              $this->auth->auth_customer_ok($data);
              header("Location:http://localhost/customer.php?flag=company");
              exit;
          }          
       }
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',"");
       $this->view_display();
    }
    
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
 //　　　案件の一覧表示
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function screen_list_project(){                 
        
      if(isset($_GET['flag'])){     
          if($_GET['flag'] == "regist"){ $this->message = "新規で１件、登録が完了しました"; }
          if($_GET['flag'] == "modify"){ $this->message = "案件を１件、更新しました"; }
          if($_GET['flag'] == "delete"){ $this->message = "案件を１件、削除しました"; }
      }
      
      //システム側から来た場合、セッション値の定義
      if($this->is_system && isset($_POST['id'])){
          $_SESSION[_CUSTOMER_AUTHINFO]['id'] = $_POST['id'];
          $CustomerModel = new CustomerModel;
          $_SESSION[_CUSTOMER_AUTHINFO]['company_name'] = $CustomerModel->get_company_name_company_id($_POST['id']);
      }
      
      if($this->is_system){
          $this->title = "<font color='blue'>".$_SESSION[_CUSTOMER_AUTHINFO]['company_name']."</font>様の案件一覧";
      }else{
          $this->title = "案件一覧";
      }
      
       $perPage = "5";
       $this->next_type = "list_project";
       
       $CustomerModel = new CustomerModel;
       $CustomerModel->valid_off_yesterday_project();
       list($data,$count) = $CustomerModel->get_project_list($_SESSION[_CUSTOMER_AUTHINFO]['id']);
       list($data,$links) = $this->make_page_link($perPage,$data);     
       $this->view->assign('data',$data);
       $this->view->assign('count',$count);
       $this->view->assign('links',$links['all']);
       $this->file = "customer_list_project.tpl";
       $this->view_display();
    }    
    

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　案件の登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function screen_regist_project(){
        
       $day = array('Y'=>date('Y'),'m'=>date('m'),'d'=>date('d'));
       
       $this->form->setDefaults(array('valid' => array('valid'=>1),
                                      't_start'=>$day,
                                      't_end'=>$day));
       
       $this->make_customer_regist_project();
       $this->make_select_form_project_type();
       $this->make_form_project_area();
       
       $btn1 = ""; 
       $btn2 = "";
          
          if(isset($_POST['re'])){
            $data = $this->form->getSubmitValues();
          }

       if(isset($data)){           
           $this->check_screen_regist_project($data);
       }else{
           $this->action = "form"; 
       }
       
       
       if($this->action == "form"){
  
           $this->title = "案件登録ページ";
           $this->file = "customer_regist_project.tpl";
           $this->next_type = "regist_project";
           $this->next_action = "confirm";
           $btn1 = "確認";
           $btn2 = "";
           
       }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認"){
         
           $this->form->freeze();
                        
           $this->title = "案件登録ページ";
           $this->message = "下記でよろしいでしょうか？";
           $this->file = "customer_regist_project.tpl";
           $this->next_type = "regist_project";
           $this->next_action = "complete";
           $btn1 = "登録";
           $btn2 = "戻る";

       }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
           
           $this->title = "案件登録ページ";
           $this->file = "customer_regist_project.tpl";
           $this->next_type = "regist_project";
           $this->next_action = "confirm";
           $btn1 = "確認";
           $btn2 = "";
        
       }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "登録"){
           
           $data['t_start'] = sprintf("%04d%02d%02d",$data['t_start']['Y'],$data['t_start']['m'],$data['t_start']['d']);
           $data['t_end']   = sprintf("%04d%02d%02d",$data['t_end']['Y'],$data['t_end']['m'],$data['t_end']['d']);
           $data['shift_start'] = sprintf("%02d%02d",$data['shift_start']['H'],$data['shift_start']['i']);
           $data['shift_end']   = sprintf("%02d%02d",$data['shift_end']['H'],$data['shift_end']['i']);
           $data['valid'] = $data['valid']['valid'];
           $data['company_id'] = $_SESSION[_CUSTOMER_AUTHINFO]['id']; 
           
           $CustomerModel = new CustomerModel;
           $CustomerModel->regist_project($data);
           
           if($this->is_system){
               
              header("Location:http://localhost/system.php?type=list_project&flag=regist");
              exit;
              
           }else{
              header("Location:http://localhost/customer.php?type=list_project&flag=regist");
              exit;
           }
       }
       
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',"");
       $this->view_display();
    }  
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　案件　削除か更新かの判断
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_modify_or_delete_project(){
       
        unset($_SESSION['id']);
        
        if(isset($_POST['modify']) && $_POST['modify'] == "更新"){
            $this->screen_modify_project();            
        }else if(isset($_POST['delete']) && $_POST['delete'] == "削除"){
            $this->screen_delete_project();             
        }        
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　案件の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・        
    
    public function screen_modify_project(){
            
       $btn1 = "";
       $btn2 = "";
       
       if(isset($_POST['id'])){
       $id = $_POST['id'];
       $_SESSION['id'] = $id;
       
       $CustomerModel = new CustomerModel;
       $project_data = $CustomerModel->get_project_raw($id);
       
       $default_t_start = array('Y'=>substr($project_data['t_start'],0,4),'m'=>substr($project_data['t_start'],4,2),'d'=>substr($project_data['t_start'],6,2));
       $default_t_end   = array('Y'=>substr($project_data['t_end'],0,4),'m'=>substr($project_data['t_end'],4,2),'d'=>substr($project_data['t_end'],6,2));
       
       $default_shift_start = array('H'=>substr($project_data['shift_start'],0,2),'i'=>substr($project_data['shift_start'],2,2));
       $default_shift_end   = array('H'=>substr($project_data['shift_end'],0,2),'i'=>substr($project_data['shift_end'],2,2));
       
       $setDefaults = array('valid' => $project_data['valid'],
                            'project_type'=>$project_data['project_type'],
                            't_start' => $default_t_start,
                            't_end'   => $default_t_end,
                            'shift_start' =>$default_shift_start,
                            'shift_end'   =>$default_shift_end,
                            'title' => $project_data['title'],
                            'project_content' => $project_data['project_content'],
                            'area_type1'    => $project_data['area_type'],
                            'salary_per_hour' => $project_data['salary_per_hour'],
                            'transportation' => $project_data['transportation'],
                            'valid'=>array('valid'=>$project_data['valid']));
       
       $this->form->setDefaults($setDefaults);     
       }
              
       $this->make_customer_regist_project();
       $this->make_form_project_area();
       $this->make_select_form_project_type();
       
       
          if(isset($_POST['re'])){
            $data = $this->form->getSubmitValues();
            $this->check_screen_regist_project($data);
          }
          
       if($this->action == "form"){
           
           $this->title = "更新ページ";
           $this->next_type   = "modify_project";
           $this->next_action = "confirm";
           $this->file = "customer_regist_project.tpl";
           $btn1 = "確認";
           
       }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認"){
           
           $this->form->freeze();
           
           $this->title = "更新ページ";
           $this->message = "下記で宜しいでしょうか？";
           $this->next_type   = "modify_project";
           $this->next_action = "complete";
           $this->file = "customer_regist_project.tpl";
           $btn1 = "更新";
           $btn2 = "戻る";
           
       }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
           
           $this->title = "更新ページ";
           $this->next_type   = "modify_project";
           $this->next_action = "confirm";
           $this->file = "customer_regist_project.tpl";
           $btn1 = "確認";
           
       }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "更新"){
           
           $data['t_start'] = sprintf("%04d%02d%02d",$data['t_start']['Y'],$data['t_start']['m'],$data['t_start']['d']);
           $data['t_end']   = sprintf("%04d%02d%02d",$data['t_end']['Y'],$data['t_end']['m'],$data['t_end']['d']);
           $data['shift_start'] = sprintf("%02d%02d",$data['shift_start']['H'],$data['shift_start']['i']);
           $data['shift_end']   = sprintf("%02d%02d",$data['shift_end']['H'],$data['shift_end']['i']);
           $data['valid'] = $data['valid']['valid'];
         
           $id = $_SESSION['id'];
           unset($_SESSION['id']);
           $CustomerModel = new CustomerModel;
           $CustomerModel->modify_project($data,$id);
           
           if($this->is_system){
              header("Location:http://localhost/system.php?type=list_project&flag=modify");
              exit;
           }else{
              header("Location:http://localhost/customer.php?type=list_project&flag=modify");
              exit;
           }
       }
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',"");       
       $this->view_display();
    }   
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　案件の削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_delete_project(){
        
       $this->title = "削除ページ";
       $this->file = "customer_top.tpl";
       
       $btn1 = "";
       $btn2 = "";       
       
       if(isset($_POST['id'])){
       $id = $_POST['id'];
       $_SESSION['id'] = $id;
       
       $CustomerModel = new CustomerModel;
       $project_data = $CustomerModel->get_project_raw($id);
       
       $default_t_start = array('Y'=>substr($project_data['t_start'],0,4),'m'=>substr($project_data['t_start'],4,2),'d'=>substr($project_data['t_start'],6,2));
       $default_t_end   = array('Y'=>substr($project_data['t_end'],0,4),'m'=>substr($project_data['t_end'],4,2),'d'=>substr($project_data['t_end'],6,2));
       $default_shift_start = array('H'=>substr($project_data['shift_start'],0,2),'i'=>substr($project_data['shift_start'],2,2));
       $default_shift_end   = array('H'=>substr($project_data['shift_end'],0,2),'i'=>substr($project_data['shift_end'],2,2));
       
       $setDefaults = array('valid' => $project_data['valid'],
                            'project_type'=>$project_data['project_type'],
                            't_start' => $default_t_start,
                            't_end'   => $default_t_end,
                            'shift_start' =>$default_shift_start,
                            'shift_end'   =>$default_shift_end,
                            'title' => $project_data['title'],
                            'project_content' => $project_data['project_content'],
                            'area_type1'    => $project_data['area_type'],
                            'salary_per_hour' => $project_data['salary_per_hour'],
                            'transportation' => $project_data['transportation'],
                            'valid'=>array('valid'=>$project_data['valid']));
       
       $this->form->setDefaults($setDefaults);     
       }
       
       $this->make_form_project_area();
       $this->make_customer_regist_project();
       $this->make_select_form_project_type();
       
       
       if($this->action == "form"){
            
           $this->form->freeze();
           $this->title = "削除ページ";
           $this->message = "削除して宜しいですか？";
           $this->next_type   = "delete_project";
           $this->next_action = "complete";
           $this->file = "customer_regist_project.tpl";
           $btn1 = "削除";         
           
       }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "削除"){
           
           $id = $_SESSION['id'];
           unset($_SESSION['id']);
           
           $CustomerModel = new CustomerModel;
           $CustomerModel->delete_project($id);
           
           if($this->is_system){
              header("Location:http://localhost/system.php?type=list_project&flag=delete");
              exit;               
           }else{           
              header("Location:http://localhost/customer.php?type=list_project&flag=delete");
              exit;
           }
       }

    $this->form->addElement('submit','submit1',$btn1);
    $this->form->addElement('submit','submit2',$btn2);
    $this->form->addElement('reset','reset',"");  
    $this->view_display();
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//  以下　補助的な関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    //メール送付関数
    public function mail_to_applicant($data,$session){
        
        mb_language("ja");
        mb_internal_encoding("utf8");
        
        $MemberModel = new MemberModel;
        $memberdata = $MemberModel->get_member_base_info_id($session['member_id']);
              
        $to   = $memberdata['mail'];
        $subject = $data['subject'];
        $message = $data['body'];
        $add_header = "";
       
        mb_send_mail($to,$subject,$message,$add_header);
        
    }
          
    //actionから取得した顧客情報の変換
    public function get_base_applicant_list($data){
        
        $MemberModel = new MemberModel;
        $CustomerModel = new CustomerModel;
        
        $array = array();
                
        for($i=0; $i < count($data); $i++){
           
          $project_data = $CustomerModel->get_project($data[$i]['project_id']);
          $member_data = $MemberModel->get_member_base_info_id($data[$i]['member_id']);

          $array[$i]['action_id']        = $data[$i]['id'];
          $array[$i]['project_title']    = $project_data['title'];
          $array[$i]['project_reg_date'] = $project_data['reg_date'];
          $array[$i]['member_last_name'] = $member_data['last_name'];
          
          $now = date('Ymd');
          $array[$i]['member_age'] = floor(($now-$member_data['birthday'])/10000);
          $array[$i] = array_merge($array[$i],$data[$i]);
        }
       return $array;
    }
    
    //職種の非選択防止
    public function check_type_customer($data){   
        if($data['project_type'] != "0"){
            return true;     
        }
    }
   
    //案件の時間の適正チェック
    public function check_shift_customer($data){
       
        $shift_start = mktime($data['shift_start']['H'],$data['shift_start']['i']);
        $shift_end   = mktime($data['shift_end']['H'],$data['shift_end']['i']);
     
        if($shift_end > $shift_start){      
             return true;
        }
    }
   
    //案件の期間の適正チェック
    public function check_t_customer($data){
       
        $t_start = mktime(0,0,0,$data['t_start']['m'],$data['t_start']['d'],$data['t_start']['Y']);  
        $t_end   = mktime(0,0,0,$data['t_end']['m'],$data['t_end']['d'],$data['t_end']['Y']);
     
        if($t_end >= $t_start){
            return true;
        }
    }
  
    
    
   
}

?>
