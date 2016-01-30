<?php

class MemberController extends Basecontroller{
    
    public function run(){
        
       $this->auth = new Auth();
       $this->auth->set_authname(_MEMBER_AUTHINFO);    
       $this->auth->set_sessname(_MEMBER_SESSNAME);
       $this->auth->start();    
       $this->auth->session_security();
       
       if($this->auth->check_member()){
          $this->login = 1;
       }
       
       
       switch($this->type){       
      
          //案件の詳細
          case "detail_project":
          $this->screen_detail_project();
          break;
              
          //応募情報の確認
          case "apply";
          $this->screen_apply();
          break;
            
          //登録
          case "regist":
          $this->screen_regist();
          break;
      
          //追加情報の登録
          case "regist_add":
          $this->screen_regist_add();
          break;
                  
          //会員トップ
          case "member":
          $this->member_or_guest();
          break;
                  
//・・・・・案件表示・・・・・・・・・・・・・・・・・・・・・・・・・・・

          //tomorrow：明日のお仕事
          case "tomorrow_project":
          $this->screen_tomorrow_project();
          break; 
      
          //顧客一覧
          case "customer_list":
          $this->screen_customer_list();
          break;    
      
          //運営会社
          case "service":
          $this->screen_service();
          break; 

//・・・・・トップ画面表示・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
      
          default:
          $this->screen_top();
        } 
    }
 
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　顧客の説明
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_customer_list(){
        
        $perPage = 10;        
        $CustomerModel = new CustomerModel;        
        list($data,$count) = $CustomerModel->member_get_customer_list();        
        list($data,$links) = $this->make_page_link($perPage,$data);
        
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('links',$links['all']);        
        $this->title   = "掲載企業";
        $this->message = "サイトに掲載している企業の一覧";
        $this->file    = "member_customer_list.tpl";
        
        $this->view_display();
        
    }


//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　サービス趣旨の説明
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・     
    
    public function screen_service(){
        
        $this->title    = "運営会社";        
        $this->message  = "このサイトは<br><br>";
        $this->message .= "「PHP+MySQL」学習のために作成されたデモサイトです<br><br><br>";
        $this->message .= "<font size='4' color='red'>--現在開発中--</font><br><br>";
        $this->message .= "";
        $this->message .= "";      
        $this->file = "message.tpl";
        
        $this->view_display();               
        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　ログイン済み　の判断
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・       
    
    public function member_or_guest(){
    
       if($this->auth->check_member()){
           $this->screen_member();
       }else{
           $this->screen_login();
       }
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　メンバートップ
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_top(){
        
        unset($_SESSION['memberdata']);
        unset($_SESSION['search_key']);
        unset($_SESSION['pageID']);
        unset($_SESSION['apply']);
         
        $perPage = 4;
        $disp_search_key = "";
        $sql_search_key  = "";
        $project_type = "";
        $area_type    = "";
        
        $this->make_select_form_project_type();
        $this->make_form_project_area();       
        $search_terms = $this->form->getSubmitValues();
        
        
        if(isset($search_terms['project_type']) && $search_terms['project_type'] != "0" ){         
            $project_type = $search_terms['project_type'];
        }
        
        if(isset($search_terms['area_type1']) && $search_terms['area_type1'] != "1"){
            $area_type = $search_terms['area_type1'];
        }
        
        //・・・・・・・・・・・・・・・・・・・・・
        //　サーチキーによるサーチワードの設定
        //・・・・・・・・・・・・・・・・・・・・・
        
        //何らかの値が代入されている場合
        if(isset($_POST['search_key']) && $_POST['search_key'] != ""){
            $_SESSION['search_key'] = $_POST['search_key'];
            $disp_search_key = htmlspecialchars($_POST['search_key'],ENT_QUOTES);
            $sql_search_key  = $_POST['search_key'];
        //セットされていない。何も代入されていない場合    
        }else{
            //何も値が代入されずに、ボタンだけ押された場合
            if(isset($_POST['submit']) && $_POST['submit'] == "絞り込み"){
                //セッションの削除
                unset($_SESSION['search_key']);              
             //新規検索実行　以外の動作の場合（ページが更新もしくは他のボタンが押された）
            }else{
                //もしsessionにサーチキーが格納されている場合
                if(isset($_SESSION['search_key'])){
                    $disp_search_key = htmlspecialchars($_SESSION['search_key'],ENT_QUOTES);
                    $sql_search_key  = $_SESSION['search_key'];
                }
            }
        }
        
        $id = "";
        if(isset($_SESSION[_MEMBER_AUTHINFO]['id'])){
           $id = $_SESSION[_MEMBER_AUTHINFO]['id'];
        }
        
        $CustomerModel = new CustomerModel;
        $CustomerModel->valid_off_yesterday_project();
        list($data,$count) = $CustomerModel->get_valid_project_list($project_type,$area_type,$sql_search_key,$id);
        list($data,$links) = $this->make_page_link($perPage,$data);
               
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('search_key',$disp_search_key);
        $this->view->assign('links',$links['all']);
        
        $this->next_action = "";
        $this->next_type   = "all_projects";
        $this->title = "ようこそ！<短期専門>東京23区のお仕事サイトへ";
        $this->file  = 'index.tpl';
        $this->view_display();
        
    }


//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　明日のお仕事
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  

    public function screen_tomorrow_project(){
        
        unset($_SESSION['memberdata']);
        unset($_SESSION['search_key']);
        unset($_SESSION['pageID']);
        unset($_SESSION['apply']);
         
        $perPage = 4;
        $disp_search_key = "";
        $sql_search_key  = "";
        $project_type = "";
        $area_type    = "";
        
        $this->make_select_form_project_type();
        $this->make_form_project_area();       
        $search_terms = $this->form->getSubmitValues();
        
        
        if(isset($search_terms['project_type']) && $search_terms['project_type'] != "0" ){         
            $project_type = $search_terms['project_type'];
        }
        
        if(isset($search_terms['area_type1']) && $search_terms['area_type1'] != "1"){
            $area_type = $search_terms['area_type1'];
        }
        
        //・・・・・・・・・・・・・・・・・・・・・
        //　サーチキーによるサーチワードの設定
        //・・・・・・・・・・・・・・・・・・・・・
        
        //何らかの値が代入されている場合
        if(isset($_POST['search_key']) && $_POST['search_key'] != ""){
            $_SESSION['search_key'] = $_POST['search_key'];
            $disp_search_key = htmlspecialchars($_POST['search_key'],ENT_QUOTES);
            $sql_search_key  = $_POST['search_key'];
        //セットされていない。何も代入されていない場合    
        }else{
            //何も値が代入されずに、ボタンだけ押された場合
            if(isset($_POST['submit']) && $_POST['submit'] == "絞り込み"){
                //セッションの削除
                unset($_SESSION['search_key']);              
             //新規検索実行　以外の動作の場合（ページが更新もしくは他のボタンが押された）
            }else{
                //もしsessionにサーチキーが格納されている場合
                if(isset($_SESSION['search_key'])){
                    $disp_search_key = htmlspecialchars($_SESSION['search_key'],ENT_QUOTES);
                    $sql_search_key  = $_SESSION['search_key'];
                }
            }
        }
        
        $id = "";
        if(isset($_SESSION[_MEMBER_AUTHINFO]['id'])){
           $id = $_SESSION[_MEMBER_AUTHINFO]['id'];
        }
        
        $CustomerModel = new CustomerModel;
        $CustomerModel->valid_off_yesterday_project();
        list($data,$count) = $CustomerModel->get_valid_tomorrow_project_list($project_type,$area_type,$sql_search_key,$id);
        list($data,$links) = $this->make_page_link($perPage,$data);
               
        $this->view->assign('count',$count);
        $this->view->assign('data',$data);
        $this->view->assign('search_key',$disp_search_key);
        $this->view->assign('links',$links['all']);
        
        $this->next_action = "";
        $this->next_type   = "tomorrow_project";
        
        $this->title   = "明日のお仕事";
        $this->message = "急募！！明日スタートのお仕事です！！";
        $this->file  = 'index_tomorrow.tpl';
        
        $this->view_display();
        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　案件の詳細表示
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function screen_detail_project(){
        
        $this->title = "お仕事の詳細";
        $this->message = "下記に応募しますか？";
        
        $project_id = "";
        $member_id  = "";        
        
        if(isset($_REQUEST['project_id'])){
           $project_id = $_REQUEST['project_id'];
        }
        
        if(isset($_SESSION[_MEMBER_AUTHINFO]['id'])){
           $member_id  = $_SESSION[_MEMBER_AUTHINFO]['id'];
        }
        
        $CustomerModel = new CustomerModel;
        $data = $CustomerModel->get_project($project_id,$member_id);
        $data2 = $CustomerModel->get_customer_authinfo_id($data['company_id']);
          
        $this->view->assign('data',$data);
        $this->view->assign('data2',$data2); 
        $this->file = "index_detail_project.tpl";
        
        $this->view_display();
        
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　 　ログイン済みの場合　マイページへの移動の判断
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・     
    
    public function screen_member(){

        if(isset($_SESSION[_MEMBER_AUTHINFO]['record']) && $_SESSION[_MEMBER_AUTHINFO]['record'] == 'on' ){
            header("Location:http://localhost/member.php");
            exit;
        }else{
            $this->screen_regist_add();
        }
    }
 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     ログイン画面
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_login(){

        if(empty($this->action)){
        
           $this->title = "ログイン画面";
           $this->make_pass_form();
           $this->next_type = 'member';
           $this->next_action = 'auth';
           $this->file = 'member_login.tpl';
           $this->view_display();
        
        }else if($this->action == "auth"){
            
           $MemberModel = new MemberModel();
           $memberdata = $MemberModel->get_member_authinfo($_POST['mail']);        
           
           if($this->auth->check_pass($memberdata['password'],$_POST['password'])){
               
               $this->auth->auth_member_ok($memberdata);
               $this->screen_member();
               
           }else{
               
               $this->title = "ログイン画面";
               $this->message .= "<font color='red'>ユーザー名もしくはパスワードが正しくありません</font>";               
               $this->form->addElement('text','mail','メールアドレス：',array('size'=>15,'maxlength'=>50));
               $this->form->addElement('password','password','パスワード：',array('size'=>15,'maxlength'=>50));
               $this->form->addElement('submit','submit','ログイン');
               $this->next_type = 'member';
               $this->next_action = 'auth';
               $this->file = 'member_login.tpl';               
               
               $this->view_display();
           } 
        }
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　案件への応募時
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_apply(){    
        
        if(!$this->auth->check_member()){
            
            //ログイン画面　新規登録　へのリンク
            $this->message = "すでにアカウントをお持ちですか？";
            $this->screen_login();
            exit;
            
        }else{
            
            $action['member_id'] =  $_SESSION[_MEMBER_AUTHINFO]['id'];
            $action['company_id'] = $_POST['company_id'];
            $action['project_id'] = $_POST['project_id'];            
            $history = "appli";
            
            $ActionModel = new ActionModel;
            $ActionModel->regist_action($action,$history);
            
            $this->title = '応募完了';
            $this->message = "応募が完了しました。<br><br>企業からの返信を待ちましょう！";
            $this->file  = 'message.tpl';
            
        }
          $this->view_display();
    }
    
       
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　新規会員登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function screen_regist($auth = ""){
            
        $btn1 = "";
        $btn2 = "";
        
        $this->file  = 'member_regist.tpl';
        $this->make_member_regist_form();
        
        $this->form->setDefaults(
               array('gender' => array('gender' => '1'),
                     'birthday' => array('Y' => 1980,'m' => 1,'d' => 1)               
                     ));
        
        if(!(isset($_POST['submit1']) && $_POST['submit1'] == "登録" )){
            if(!$this->form->validate()){
               $this->action = "form";
            }
        }        
        
        if($this->action == "form"){
           
           if($this->is_system){
              $this->title = "新規会員登録";
              $this->message = "--会員の情報を入力してください--";               
           }else{ 
              $this->title = "簡単にサイトへの登録ができます！";
              $this->message = "--ご記入ください--";
           }
           
              $this->next_type = "regist";
              $this->next_action = "confirm";
              $btn1        = "確認";
              $btn2        = "";
                   
        }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認"){
          
           $this->form->freeze();
           
           //入力値をセッションへ
           $_SESSION['memberdata'] = $this->form->getSubmitValues();          
           
           $this->title = "＜確認＞";
           $this->message = "下記でよろしいですか？";
           $this->next_type = "regist";
           $this->next_action = "complete";
           $btn1        = "登録";
           $btn2        = "戻る";
           
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る" ){
           
           unset($_SESSION['memberdata']);
           
           $this->title = "＜ 登録画面 ＞";
           $this->next_type = "regist";
           $this->next_action = "confirm";
           $btn1        = "確認";
           $btn2        = "";
           
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "登録" ){

           $PrememberModel = new PrememberModel();
           $MemberModel = new MemberModel();
           $memberdata = $_SESSION['memberdata'];
                      
           if($MemberModel->check_member($memberdata) || $PrememberModel->check_member($memberdata)){

               $this->title = "登録画面";
               $this->message = "!!!すでにこのメールアドレスは登録されています!!!";
               $this->next_type = "regist";
               $this->next_action = "confirm";
               $btn1        = "確認";
               $btn2        = "";               
               
           }else{
               
               $memberdata['birthday'] = sprintf("%04d%02d%02d",$memberdata['birthday']['Y'],
                                                                $memberdata['birthday']['m'],
                                                                $memberdata['birthday']['d']); 
               
               $memberdata['gender']   = sprintf("%1d",$memberdata['gender']['gender']);
               
               if($this->is_system && is_object($auth)){
                  $memberdata['password'] = $auth->get_hash_password($memberdata['password']); 
               }else{
                  $memberdata['password'] = $this->auth->get_hash_password($memberdata['password']);
               }
               
               if($this->is_system){        
                   $this->title   = "基本情報の入力完了";
                   $this->message = "次に追加の情報の登録に移行します";
                   $this->next_type = "regist_add";
                   $this->next_action = "form";
                   $btn1 = "OK";
                   $this->file = "message_submit.tpl";                   
               }else{                   
                   $memberdata['link_pass'] = hash('sha256',uniqid(rand(),1));
                   $PrememberModel->regist_premember($memberdata);
                   $this->mail_to_premember($memberdata);
                   $this->title   = "仮登録完了";
                   $this->message = $memberdata['last_name']."さん、ご入力ありがとうございます。<br><br>";
                   $this->message .= "登録されたメールアドレスに確認のためメールをお送りました。<br><br>";
                   $this->message .= "メール本文のURL（12時間有効）より<br><br>";
                   $this->message .= "登録を完了させてください。<br><br>";
                   $this->file = "message.tpl";
               }               
           }   
        }
        $this->form->addElement('submit','submit1',$btn1);
        $this->form->addElement('submit','submit2',$btn2);
        $this->form->addElement('reset','reset','リセット');
        $this->view_display(); 
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     新規会員・追加情報の登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function screen_regist_add($auth = ""){
        
        $hope_start = array('Y'=>date('Y'),'m'=>date('m'),'d'=>date('d'));
        $this->form->setDefaults(array('hope_start'=>$hope_start)); 
        
        $this->make_member_regist_add_form();
        $this->make_form_project_area();
        $this->make_form_project_type();
       
        $btn1 = ""; 
        $btn2 = "";
       
        if(isset($_POST['re'])){
             $data = $this->form->getSubmitValues();
        }
          
        if(isset($data)){
          
             //エリア選択は３つまでできるので3を送る設定
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

          }else{
               $this->action = "form"; 
          }
       
        if($this->action == "form"){ 
           
          if($this->is_system){
             $this->title = "補足情報";
             $this->message = "--追加情報の入力--";             
          }else{
             $this->title = "お仕事探しまであと一歩！";
             $this->message = "最後に下記の項目を入力しよう！";
          }
          
          $this->file = "member_regist_add.tpl";
          $this->next_type = "regist_add";
          $this->next_action = "confirm";
          $btn1 = "確認";
          $btn2 = "";
                
        }else if($this->action == "confirm" && isset($_POST['submit1']) && $_POST['submit1'] == "確認"){
          
          $this->form->freeze();
          $this->title = "入力の確認";
          $this->message = "下記で宜しいですか？";
          $this->file = "member_regist_add_freeze.tpl";
          $this->next_type = "regist_add";
          $this->next_action = "complete";
          $btn1 = "OK";
          $btn2 = "戻る";           
           
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == "戻る"){
          
          if($this->is_system){
             $this->title = "追加情報の入力";
             $this->message = "プラスアルファの情報の入力";              
          }else{
             $this->title = "お仕事探しまであと一歩！";
             $this->message = "最後に下記の項目を入力しよう！";
          }
          
          $this->file = "member_regist_add.tpl";
          $this->next_type = "regist_add";
          $this->next_action = "confirm";
          $btn1 = "確認";
          $btn2 = "";
          
        }else if($this->action == "complete" && isset($_POST['submit1']) && $_POST['submit1'] == "OK"){
           
           $MemberModel = new MemberModel;
           
           if($this->is_system && isset($_SESSION['memberdata'])){
               
              $memberdata = $_SESSION['memberdata'];
              
              $memberdata['birthday'] = sprintf("%04d%02d%02d",$memberdata['birthday']['Y'],
                                                               $memberdata['birthday']['m'],
                                                               $memberdata['birthday']['d']);              
              $memberdata['gender']   = sprintf("%1d",$memberdata['gender']['gender']);              
               
              $id = $MemberModel->regist_member_return_id($memberdata);
              $_SESSION[_MEMBER_AUTHINFO]['id'] = $id;
              unset($_SESSION['memberdata']);
           }
           
           $data['area_type'] = $this->data_area_input($data);
           $data['project_type'] = $this->data_project_input($data);
           $data['hope_start'] = sprintf('%04d%02d%02d',$data['hope_start']['Y'],$data['hope_start']['m'],$data['hope_start']['d']);
           
           $id = $_SESSION[_MEMBER_AUTHINFO]['id'];           
           $MemberModel->regist_add_member($data,$id);           
           
           if($this->is_system){
              $this->title = "会員情報の登録が完了しました";
              $this->file = "message.tpl";              
           }else{               
              $mail = $_SESSION[_MEMBER_AUTHINFO]['mail']; 
              $memberdata = $MemberModel->get_member_authinfo($mail);
              $this->auth->auth_member_ok($memberdata);
              $this->screen_member();              
           }
       }
       $this->form->addElement('submit','submit1',$btn1);
       $this->form->addElement('submit','submit2',$btn2);
       $this->form->addElement('reset','reset','リセット');
       $this->view_display();
    }
 
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　     仮登録時のメール
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function mail_to_premember($memberdata){
        
        mb_language("ja");
        mb_internal_encoding("utf8");
        
        $path = pathinfo(_SCRIPT_NAME)['dirname'];
        $to   = $memberdata['mail'];
        $subject = "会員登録の確認";
        
        $message =" {$memberdata['last_name']} {$memberdata['first_name']} 様

        会員登録ありがとうございます!
        下記のリンク（12時間有効）よりアクセスして
        登録を完了させましょう!!
        
        http://{$_SERVER['SERVER_NAME']}{$path}/premember.php?mail={$memberdata['mail']}&link_pass={$memberdata['link_pass']}
        
        このメールに覚えがない場合、
        お手数ですが削除をお願いします。";
       
        $add_header = "";
        mb_send_mail($to,$subject,$message,$add_header);
        
        
    }
    
    
 
}

?>

