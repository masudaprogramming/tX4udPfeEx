
<?php

class SystemController extends BaseController{
    
    public function run(){
       
       $this->auth = new Auth();
       $this->auth->set_authname(_SYSTEM_AUTHINFO);
       $this->auth->set_sessname(_SYSTEM_SESSNAME);
       $this->auth->start();
    
       //ログイン状態になく、かつ typeがauthenticate でない
       if(!$this->auth->check_system() && $this->type != 'authenticate'){
            $this->type = 'login';
       }
       
       $this->is_system = true;
       $MemberController = new MemberController($this->is_system);
       $MemberMyPageController = new MemberMyPageController($this->is_system);
       $CustomerController     = new CustomerController($this->is_system);
       
       switch($this->type){
        
           
           //認証
           case "authenticate":
           $this->do_authenticate();
           break;
    
           //ログイン
           case "login":
           $this->screen_login();
           break;
       
           //ログアウト
           case "logout":
           $this->auth->logout();
           $this->screen_login();
           break;
                      
    //・・・・・・・member・・・・・・・・・・・・・・・・・                       
           
           //登録会員の一覧
           case "member_list":
           $this->screen_member_list();
           break;
           
           //会員情報の詳細
           case "member_detail":
           $MemberMyPageController->screen_member_modify($this->auth);
           break;
       
           //新規会員の発行
           case "regist":
           $MemberController->screen_regist($this->auth);    
           break;
       
           //新規会員の追加情報の登録
           case "regist_add":
           $MemberController->screen_regist_add($this->auth);    
           break;
               
           //会員情報の更新・削除の振り分け
           case "modify_or_delete":
           $this->screen_member_modify_or_delete();
           break;
           
           //会員情報の更新
           case "modify":              
           $MemberMyPageController->screen_member_modify($this->auth);  
           break;
           
           //会員情報の削除
           case "delete":
           $MemberMyPageController->screen_delete();
           break;
           
    //・・・・・・・・customer・・・・・・・・・・・・・・・・・・      
           
           //顧客の一覧
           case "customer_list":
           $this->screen_customer_list();
           break;
       
           //新規顧客の発行
           case "customer_regist":
           $this->screen_customer_regist();
           break;
       
           //顧客情報の詳細
           case "customer_detail":
           $CustomerController->screen_company($this->auth);
           break;
           
           //顧客情報の更新・削除の振り分け
           case "modify_or_delete_customer":
           $this->screen_customer_modify_or_delete();
           break;
           
           //顧客情報の更新
           case "company":
           $CustomerController->screen_company($this->auth);
           break;
       
           //顧客情報の削除
           case "delete_customer":
           $this->screen_customer_delete();
           break;
       
    //・・・・・・・・customerの案件・・・・・・・・・・・・・・・・・  
               
           //案件一覧   ok
           case "list_project":
           $CustomerController->screen_list_project();
           break;
       
           //案件登録
           case "regist_project":
           $CustomerController->screen_regist_project();
           break;
        
           //更新・削除、動作定義
           case "modify_or_delete_project":
           $CustomerController->screen_modify_or_delete_project();
           break;
                
           //案件更新
           case "modify_project":
           $CustomerController->screen_modify_project();
           break;
        
           //案件削除
           case "delete_project":
           $CustomerController->screen_delete_project();    
           break;
       
           //案件の詳細　顧客一覧より使用
           case "detail_project":
           $MemberController->screen_detail_project();
           break;    
       
    //・・・・・・・・メッセージ・・・・・・・・・・・・・・・・・・・・・・・・       
       
           //メッセージ
           case "message_box":
           $this->screen_message_box();
           break;
       
           //メールの詳細を確認
           case "detail_message":
           $this->screen_detail_message();
           break;  
               
       
    //・・・・・・・・応募履歴・・・・・・・・・・・・・・・・・・・・・・・・・            
       
           //応募者一覧
           case "applicant_list":
           $this->screen_applicant_list();
           break;           
       
    //・・・・・・・トップ画面・・・・・・・・・・・・・・・・・・・・・・・・・
       
           default:
           $this->screen_top();
               
       }
    }


//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
//　　　管理画面　トップ 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function screen_top(){
        
        unset($_SESSION[_CUSTOMER_AUTHINFO]);        
        unset($_SESSION[_MEMBER_AUTHINFO]);
        unset($_SESSION['memberdata']);
        
        $this->title = "システム理画面トップ";
        $this->file  = "system_top.tpl";
        $this->view_display();
        
    }    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//　　　顧客情報の発行
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・       
    
    public function screen_customer_regist(){
        
       $btn1 = "";
       $btn2 = "";
       
       $this->make_system_regist_customer_form();
       
       $password  = "abcdefghijklmnopqrstuvwxyz";
       $password .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
       $password .= "0123456789";
       $password .= "_-!?#$%&";
       
       $password = substr(str_shuffle($password),0,8);
       $this->form->setDefaults(array('password' => $password));
        
        //　入力値が適切でなく　かつ　$this->actionがviewでない
        if(!$this->form->validate()){
            $this->action = "form";
        }
       
       if($this->action == "form"){
           
          $this->title = "新規：顧客発行";          
          $this->file = "system_customer_regist.tpl";
          $this->next_type = "customer_regist";
          $this->next_action = "confirm";
          $btn1 = "確認";
          $btn2 = ""; 
          
       }else if($this->action == "confirm" && $_POST['submit1'] && $_POST['submit1'] == "確認"){
           
          $this->form->freeze();
          
          $this->title = "新規：顧客発行";        
          $this->message = "下記で宜しいですか？";
          $this->file = "system_customer_regist.tpl";
          $this->next_type = "customer_regist";
          $this->next_action = "complete";
          
          $btn1 = "発行";
          $btn2 = "戻る";
           
       }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){    
          
          $this->title = "新規：顧客発行";         
          $this->file = "system_customer_regist.tpl";
          $this->next_type = "customer_regist";
          $this->next_action = "confirm";
          
          $btn1 = "確認";
          $btn2 = "";
           
       }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "発行"){
           
          $data = $this->form->getSubmitValues();
          $data['password'] = $this->auth->get_hash_password($data['password']);
          
          $CustomerModel = new CustomerModel;
          $CustomerModel->regist_customer($data);
          
          $this->title = "発行完了";
          $this->message = "新規顧客の発行が完了しました";          
          $this->file = "message.tpl";
    
       }
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset',"リセット");
       $this->view_display();
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
//　　　customer 顧客の一覧表示 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_customer_list(){
        
        unset($_SESSION[_CUSTOMER_AUTHINFO]);
        
        $perPage = 5;
        $CustomerModel = new CustomerModel;       
        
        list($data,$count) = $CustomerModel->system_get_customer_list();
        list($data,$links) = $this->make_page_link($perPage,$data);
        
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('links',$links['all']);
        
        $this->next_type   = "list_project";
        
        $this->title = "顧客の一覧";
        $this->file = "system_customer_list.tpl";
        $this->view_display();
        
    }  
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
//　　　customer 顧客情報の更新・削除の振り分け
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_customer_modify_or_delete(){
        
        $CustomerController     = new CustomerController($this->is_system);
        
        if(isset($_POST['submit1']) && $_POST['submit1'] == "更新"){            
                    $CustomerController->screen_company($this->auth);
        }else if(isset($_POST['submit2']) && $_POST['submit2'] == "削除"){
                    $this->screen_customer_delete();
        }
        
    }


//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     顧客情報 　削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function screen_customer_delete(){
        
      $btn = "";
      $CustomerModel = new CustomerModel;      
     
      if($this->action == "form"){          
                 
        $this->title = "顧客情報削除";
        $this->message  = "<font color='red' size='4'>--注意--</font><br><br>";
        $this->message .= "[削除]ボタンをクリックすると<br><br>";
        $this->message .= "顧客番号&nbsp;<font color='blue'>";
        $this->message .= htmlspecialchars($_SESSION[_CUSTOMER_AUTHINFO]['id'],ENT_QUOTES);
        $this->message .= "</font>番<br><br><font color='blue'>";
        $this->message .= htmlspecialchars($_SESSION[_CUSTOMER_AUTHINFO]['company_name'],ENT_QUOTES);
        $this->message .= "</font>&nbsp;様の<br><br><font color='red' size='4'>すべての情報</font>を削除します。";
        
        $this->file        = "member_delete.tpl";        
        $this->next_type   = "delete_customer";
        $this->next_action = "complete";
        
        $btn = "削除";
        
      }else if($this->action == "complete"){
        
        $CustomerModel->delete_customer($_SESSION[_CUSTOMER_AUTHINFO]['id']);  
                  
        $this->title = "削除完了";
        $this->message = "顧客情報を削除しました";
        $this->URL  = "system.php?type=customer_list";
        $this->URL  .= $this->add_pageID();
        $this->file = "message.tpl";          
        
      }      
      $this->form->addElement('submit','submit1',$btn);
      $this->view_display();      
    }    
          

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　member 関係の関数 　＊基本情報の一覧表示
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_member_list(){
        
        unset($_SESSION[_MEMBER_AUTHINFO]);
        unset($_SESSION['memberdata']);
        
        $perPage = 5;
        $MemberModel = new MemberModel;
        list($data,$count) = $MemberModel->system_get_member_list();
        list($data,$links) = $this->make_page_link($perPage,$data);
        
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('links',$links['all']);
        
        $this->title = "メンバーの一覧";
        $this->file = "system_member_list.tpl";
        $this->view_display();
        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　member 関係の関数 　＊delete or modify
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function screen_member_modify_or_delete(){
        
        $MemberMyPageController = new MemberMyPageController($this->is_system);
        
        if(isset($_POST['submit1']) && $_POST['submit1'] == "更新"){            
                     $MemberMyPageController->screen_member_modify($this->auth);
        }else if(isset($_POST['submit2']) && $_POST['submit2'] == "削除"){
                     $MemberMyPageController->screen_delete();  
        }
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　message メッセージ画面 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_message_box(){
        
        $MessageModel = new MessageModel;
        $perPage = 15;               
            
        $this->title = "メッセージ一覧";
        $this->message = "サイト内で送受信されたメッセージの全件表示";
        $this->file  = "system_message_list.tpl";
           
        list($data,$count) = $MessageModel->get_system_all_message();
        list($data,$links) = $this->make_page_link($perPage,$data);
           
        $this->view->assign('data',$data);
        $this->view->assign('count',$count);
        $this->view->assign('links',$links['all']);       
        
        $this->view_display();
        
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　message メッセージの詳細
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
     public function screen_detail_message(){
        
        $message_id = "";        
                
        if(isset($_GET['message_id'])){
             $message_id = $_GET['message_id'];
        }

        $this->title = "メッセージ確認";
        $this->message = "";
        $this->file = "system_detail_message.tpl";
        
        $MessageModel = new MessageModel;
        $message_data = $MessageModel->system_get_detail_message_messsage_id($message_id); 
        
        $this->view->assign('data',$message_data);        
        $this->view_display();        
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　applicant 応募者のリスト 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
      
    public function screen_applicant_list(){
        
       $this->title   = "サイト内・応募者一覧";
       $this->message = "サイト内で発生した応募の全件表示";
       $perPage = 8;
       
       $ActionModel = new ActionModel;
       
       list($data,$count) = $ActionModel->system_get_all_action();
       
       $data = $this->get_applicant_list($data);
       list($data,$links) = $this->make_page_link($perPage,$data);
      
       $this->view->assign('data',$data);
       $this->view->assign('count',$count);
       $this->view->assign('links',$links['all']);
       $this->file = "system_applicant_list.tpl";
       $this->view_display();        
                    
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　ログイン画面 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    private function screen_login(){
        
        $this->make_pass_form();
        $this->next_type = "authenticate";
        
        $this->title = "管理ログイン画面";
        $this->file  = "login.tpl";
        $this->view_display();        
    }
    
    public function do_authenticate(){
        
        $SystemModel = new SystemModel();
        $data = $this->form->getSubmitValues();       
        $userdata = $SystemModel->get_authinfo($data['mail']);
        
    
        if(!empty($userdata['password']) && $this->auth->check_pass($userdata['password'],$data['password'])){
            $this->auth->auth_system_ok($userdata);
            $this->screen_top();          
        }else{
            $this->message = "メールもしくはパスが異なります";
            $this->screen_login();
        }
        
    }
    

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//   actionから取得した顧客情報の変換
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_applicant_list($data){
        
        $MemberModel = new MemberModel;
        $CustomerModel = new CustomerModel;
        
        $array = array();
                
        for($i=0; $i < count($data); $i++){
           
          $project_data = $CustomerModel->get_project($data[$i]['project_id']);
          $company_name = $CustomerModel->get_company_name_company_id($data[$i]['company_id']);
          $member_data = $MemberModel->get_member_base_info_id($data[$i]['member_id']);

          $array[$i]['action_id']        = $data[$i]['id'];
          $array[$i]['project_title']    = $project_data['title'];
          $array[$i]['project_reg_date'] = $project_data['reg_date'];
          $array[$i]['member_name']      = $member_data['last_name']."&nbsp;".$member_data['first_name'];
          $array[$i]['company_name']     = $company_name;
          
          $now = date('Ymd');
          $array[$i]['member_age'] = floor(($now-$member_data['birthday'])/10000);
          $array[$i] = array_merge($array[$i],$data[$i]);
        }
       return $array;
    }

    
}

?>

