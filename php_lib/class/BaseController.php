
<?php

class BaseController{
    
   protected $auth;
   protected $type;
   protected $title;
   protected $message;
   protected $action;
   protected $view;
   protected $form;
   protected $renderer;
   protected $next_type;
   protected $next_action;
   protected $member_name;
   protected $file;
   protected $is_system = false;
   //memberおよびcustomerでの表示用の変数
   protected $area;
   protected $project;
   protected $shift;
   protected $t;
   protected $company;
   //memberのlogin状態を判別
   protected $login;
   protected $URL;
   
                      
    function __construct($flag = false){
       $this->set_system($flag); 
       $this->view_initialize();
    }
    
    public function set_system($flag){
        $this->is_system = $flag;
    }
    
    private function view_initialize(){
       
       $this->view = new Smarty;
       //smartyのdir定義
       $this->view->template_dir = _SMARTY_TEMPLATES_DIR;
       $this->view->compile_dir  = _SMARTY_TEMPLATES_C_DIR;
       $this->view->config_dir   = _SMARTY_CONFIG_DIR;
       $this->view->cache_dir    = _SMARTY_CACHE_DIR;
       
       //pear
       $this->form = new HTML_QuickForm();
       $this->form->setJsWarnings("入力エラーです","上記項目を修正してください");
       //pearとsmartyの連携
       $this->renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->view);
       
       //入力値の反映
       if(isset($_REQUEST['type'])){ $this->type = $_REQUEST['type']; }
       if(isset($_REQUEST['action'])){ $this->action = $_REQUEST['action']; }
       
       //共通の変数
       $this->view->assign('add_pageID',$this->add_pageID());
       $this->view->assign('is_system',$this->is_system);
       
    }
   
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //　　View_display() 関数
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function view_display(){
           
       $this->debug_display();
       
       $this->view->assign('title',$this->title);
       $this->view->assign('message',$this->message);
       $this->view->assign('type',$this->next_type);
       $this->view->assign('action',$this->next_action);       
       $this->view->assign('member_name',$this->member_name);       
       $this->view->assign('area_error',$this->area);
       $this->view->assign('project_error',$this->project);
       $this->view->assign('shift_error',$this->shift);
       $this->view->assign('t_error',$this->t);
       $this->view->assign('company',$this->company);
       $this->view->assign('login',$this->login);       
       $this->view->assign('URL',$this->URL);
       
       //HTML_QuickForm::acceptメソッドでフォームへの関連づけが可能
       $this->form->accept($this->renderer);
       
       //toArray 生成されたメニューを配列として出力
       $this->view->assign('form',$this->renderer->toArray());
       $this->view->display($this->file);
       
    }
       
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //　　以下、member controllerフォームの関数群
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    //会員登録時のフォーム作成
    public function make_member_regist_form(){
       
       $this->form->addElement('text','mail','E-Mailアドレス',array('size'=>50,'maxlength'=>255));
       $this->form->addElement('password','password','　　　  パスワード',array('size'=>50,'maxlength'=>255));
       $this->form->addElement('password','password2','パスワード(再入力)',array('size'=>50,'maxlength'=>255));     
       $this->form->addElement('text','last_name','苗字',array('size'=>20,'maxsize'=>20));
       $this->form->addElement('text','first_name','名前',array('size'=>20,'maxsize'=>20));
       $this->form->addElement('date','birthday','誕生日',array('language'=>'ja','minYear'=>1950,'maxYear'=>2010,'format'=>'Ymd'));
       $gender[] = $this->form->createElement('radio','gender',NULL,'男',1);
       $gender[] = $this->form->createElement('radio','gender',NULL,'女',2);
       $this->form->addGroup($gender,'gender','性別:');

        $this->form->setDefaults(
        
               array(
               'gender' => array('gender' => '1'),
               'birthday' => array('Y' => 1980,'m' => 1,'d' => 1)               
               ));
       
       $this->form->addRule('mail','アドレスの形式が正しくありません','email',NULL,'server');
       $this->form->addRule('mail','アドレスの入力は必須です','required',NULL,'server');
       $this->form->addRule('password','パスワードの入力は必須です','required',NULL,'server');
       $this->form->addRule('password','パスワードは8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
       $this->form->addRule('password','パスワードは半角の英数字、記号(_\-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');
       $this->form->addRule('password2','パスワードの入力は必須です','required',NULL,'server');
       $this->form->addRule('password2','パスワードは8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
       $this->form->addRule('password2','パスワードは半角の英数字、記号(_\-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');
       $this->form->addRule(array('password','password2'),'パスワードが一致していません','compare',NULL,'server');
       $this->form->addRule('last_name','苗字は必須入力です','required',NULL,'server');
       $this->form->addRule('first_name','名前は必須入力です','required',NULL,'server');
       $this->form->addRule('last_name','苗字は20文字以下で入力してください','rangelength',array(0,20*3),'server');
       $this->form->addRule('first_name','名前は20文字以下で入力してください','rangelength',array(0,20*3),'server');
       
       $this->form->applyFilter('__ALL__','trim');
       
    }
    
    //会員情報更新時のパス更新
    public function make_member_modify_pass_form(){
        
       $this->form->addElement('password','password_old','現在のパスワード',array('size'=>50,'maxlength'=>255));
       $this->form->addElement('password','password_new1','　　　 　新しいパスワード',array('size'=>50,'maxlength'=>255));      
       $this->form->addElement('password','password_new2','新しいパスワード(確認)',array('size'=>50,'maxlength'=>255));
       
       $this->form->addRule('password_old','入力されていません','required',NULL,'server');
       $this->form->addRule('password_old','8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
       $this->form->addRule('password_old','半角の英数字、記号(_\-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');
       
       $this->form->addRule('password_new1','入力されていません','required',NULL,'server');
       $this->form->addRule('password_new1','8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
       $this->form->addRule('password_new1','半角の英数字、記号(_\-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');
       
       $this->form->addRule('password_new2','入力されていません','required',NULL,'server');
       $this->form->addRule('password_new2','8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
       $this->form->addRule('password_new2','半角の英数字、記号(_\-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');       
       $this->form->addRule(array('password_new1','password_new2'),'パスワードが一致していません','compare',NULL,'server');
       
    }   
    
    //会員情報更新時のパス以外のフォーム
    public function make_member_regist_form_no_pass(){
       
       $this->form->addElement('text','mail','E-Mailアドレス',array('size'=>50,'maxlength'=>255));
       $this->form->addElement('text','last_name','苗字',array('size'=>20,'maxsize'=>20));
       $this->form->addElement('text','first_name','名前',array('size'=>20,'maxsize'=>20));
       $this->form->addElement('date','birthday','誕生日',array('language'=>'ja','minYear'=>1950,'maxYear'=>2010,'format'=>'Ymd'));
       
       $gender[] = $this->form->createElement('radio','gender',NULL,'男',1);
       $gender[] = $this->form->createElement('radio','gender',NULL,'女',2);
       $this->form->addGroup($gender,'gender','性別:');
       
       $this->form->addRule('mail','アドレスの形式が正しくありません','email',NULL,'server');
       $this->form->addRule('mail','アドレスの入力は必須です','required',NULL,'server');
       $this->form->addRule('last_name','苗字は必須入力です','required',NULL,'server');
       $this->form->addRule('first_name','名前は必須入力です','required',NULL,'server');
       $this->form->addRule('last_name','苗字は20文字以下で入力してください','rangelength',array(1*3,20*3),'server');
       $this->form->addRule('first_name','名前は20文字以下で入力してください','rangelength',array(1*3,20*3),'server');
       /*
       $this->form->addRule('gender','選択してください','required',NULL,'server');
       */
       $this->form->applyFilter('__ALL__','trim');
       
    }
       
   //初回ログイン時の追加情報のフォームの作成
    public function make_member_regist_add_form(){
                 
       $this->form->addElement('date','hope_start','希望勤務スタート:',array('language'=>'ja','format'=>'Ymd','maxYear'=>2020));    
       $this->form->addElement('textarea','expe_appeal','お仕事への意気込み',array('Cols'=>'50','Rows'=>'3'));
       $this->form->addElement('submit','sub','登録完了');     
       
       $this->form->addRule('expe_appeal','お仕事への意気込みは必須です','required',NULL,'server');      
       $this->form->addRule('expe_appeal','お仕事への意気込みは5文字以上～450文字以下で記入してください','rangelength',array(5,450),'server');
       $this->form->applyFilter('__ALL__','trim');
       
    }

 
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //　　member controllerの補助的な関数群
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・


    //プロジェクトの職種が一つ以上選択されているか判断
    public function check_project_member($data){
        
        $i = 1;
        
        while($i <= 15){
           $project = "project_type".$i;
           if(isset($data[$project])){
                return true;
           }
           $i++;
        }
    }
    
    
    //選択されたエリアの番号を文字列で格納
    public function data_area_input($data){
        
        $i   = 1;
        $row = "";
        
        while($i <= 3){
           $area = "area_type".$i;
           if($data[$area] != "1" ){
                $row .= $data[$area]."/";
           }
           $i++;
        }
       return $row;
    }
    
    
    //選択されたプロジェクトの職種の番号を文字列で格納
    public function data_project_input($data){
    
        $i   = 1;
        $row = "";
        
        while($i <= 15){
           $project = "project_type".$i;
           if(isset($data[$project])){
               $row .= $i."/";
           }
          $i++;
        }
       return $row; 
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　以下、customer controllerの関数群
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
      
    //顧客情報更新用のフォーム
    public function make_customer_modify_company(){
        
        $this->form->addElement('text','company_name','会社名',array('size'=>30));
        $this->form->addElement('text','mail','メールアドレス',array('size'=>30));
        $this->form->addElement('text','tel','電話番号',array('size'=>30));
        $this->form->addElement('text','address','住所',array('size'=>30));
        $this->form->addElement('textarea','appeal','会社の紹介(アピール)',array('Cols'=>50,'Rows'=>3));
        $this->form->addElement('text','last_name','苗字',array('size'=>15));
        $this->form->addElement('text','first_name','名前',array('size'=>15));
        
        $this->form->addRule('company_name','会社名が入力されていません','required',null,'server');
        $this->form->addRule('mail','メールアドレスが入力されていません','required',null,'server');
        $this->form->addRule('mail','メールアドレスの形式が不正です','email',null,'server');
        $this->form->addRule('tel','電話番号が入力されていません','required',null,'server');
        $this->form->addRule('tel','電話番号は半角数字とハイフンのみを使ってください','regex','/^[0-9-]*$/','server');
        $this->form->addRule('address','住所が入力されていません','required',null,'server');
        $this->form->addRule('appeal','会社の紹介が入力されていません','required',null,'server');
        $this->form->addRule('appeal','会社の紹介は10以上～450未満の文字数で入力してください','rangelength',array(10*3,450*3),'server');
        $this->form->addRule('last_name','苗字が入力されていません','required',null,'server');
        $this->form->addRule('first_name','名前が入力されていません','required',null,'server');
               
        $this->form->applyFilter('__ALL__','trim');
    }
    

    //案件登録
    public function make_customer_regist_project(){
              
        $this->form->addElement('date','t_start','勤務開始日付:',array('language'=>'ja','format'=>'Ymd','maxYear'=>2020,));
        $this->form->addElement('date','t_end','勤務終了日付:',array('language'=>'ja','format'=>'Ymd','maxYear'=>2020,));
        $this->form->addElement('date','shift_start','勤務開始時間:',array('language'=>'ja','format'=>'Hi'));
        $this->form->addElement('date','shift_end','勤務終了時間:',array('language'=>'ja','format'=>'Hi'));        
        $this->form->addElement('textarea','title','お仕事のタイトル',array('maxlength'=>100,'rows'=>2,'cols'=>65));
        $this->form->addElement('textarea','project_content','お仕事の内容(具体的に)',array('maxlength'=>300,'rows'=>3,'cols'=>65));
        $valid[] = $this->form->createElement('radio','valid',null,'公開する',1);
        $valid[] = $this->form->createElement('radio','valid',null,'非公開にする',0);
        $this->form->addGroup($valid,'valid','この求人を公開しますか？');
                
        $data1 = array();
        $i = 900;
        while($i <= 2000){ $data1[$i] = $i." 円"; $i = $i + 50; } 
        $this->form->addElement('select','salary_per_hour','時給',$data1);
        
        $data2 = array();
        $i = 50;
        $data2[0] = "支給なし";
        while($i <= 2000){ $data2[$i] = $i." 円"; $i = $i + 50; }
        
        $this->form->addElement('select','transportation','交通費',$data2);        
        $this->form->addRule('title','記入は必須です','required',null,'server');
        $this->form->addRule('project_content','記入は必須です','required',null,'server');
        $this->form->applyFilter('__ALL__','trim');
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　以下、system controllerの関数群
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
      
    //顧客情報更新用のフォーム
    public function make_system_regist_customer_form(){
        
        $this->form->addElement('text','company_name','会社名',array('size'=>30));
        $this->form->addElement('text','password','パスワード',array('size'=>30));
        $this->form->addElement('text','mail','メールアドレス',array('size'=>30));
        $this->form->addElement('text','tel','電話番号',array('size'=>30));
        $this->form->addElement('text','address','住所',array('size'=>30));
        $this->form->addElement('textarea','appeal','会社の紹介(アピール)',array('Cols'=>50,'Rows'=>3));
        $this->form->addElement('text','last_name','苗字',array('size'=>15));
        $this->form->addElement('text','first_name','名前',array('size'=>15));
        
        $this->form->addRule('company_name','会社名が入力されていません','required',null,'server');        
        $this->form->addRule('password','パスワードが入力されていません','required',null,'server');
        $this->form->addRule('password','8～16文字の範囲で入力してください','rangelength',array(8,16),'server');
        $this->form->addRule('password','半角の英数字、記号(_-!?#$%&)を使ってください','regex','/^[a-zA-Z0-9_\-!?#$%&]*$/','server');        
        $this->form->addRule('mail','メールアドレスが入力されていません','required',null,'server');
        $this->form->addRule('mail','メールアドレスの形式が不正です','email',null,'server');
        $this->form->addRule('tel','電話番号が入力されていません','required',null,'server');
        $this->form->addRule('tel','電話番号は半角数字とハイフンのみを使ってください','regex','/^[0-9-]*$/','server');
        $this->form->addRule('address','住所が入力されていません','required',null,'server');
        $this->form->addRule('appeal','会社の紹介が入力されていません','required',null,'server');
        $this->form->addRule('appeal','会社の紹介は10以上～450未満の文字数で入力してください','rangelength',array(10*3,450*3),'server');
        $this->form->addRule('last_name','苗字が入力されていません','required',null,'server');
        $this->form->addRule('first_name','名前が入力されていません','required',null,'server');
               
        $this->form->applyFilter('__ALL__','trim');
    }
    
   
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　memberとcustomer controllerの共通のフォーム作成：関数群
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    //メール送信用のフォーム
    public function make_message_form(){
        
        $this->form->addElement('text','subject','件名',array('size'=>44));
        $this->form->addElement('textarea','body','本文',array('rows'=>18,'cols'=>45));
        
        $this->form->addRule('subject','件名が入力されていません','required',null,'server');
        $this->form->addRule('subject','件名は50文字以下の範囲で入力してください','rangelength',array(0,50*3),'server');        
        $this->form->addRule('body','本文が入力されていません','required',null,'server');
        $this->form->addRule('body','本文は1000文字以下の範囲で入力してください','rangelength',array(0,1000*3),'server');
        
        $this->form->applyFilter('__ALL__','trim');
    }

    
    //職種のセレクトボックス作成
    public function make_select_form_project_type(){
        
        $ViewModel = new ViewModel;
        $data = $ViewModel->get_project_type();     
        $data = array_merge(array("0"=>"選択なし"),$data);
        $this->form->addElement('select','project_type','職種',$data);
        
    }
   
    //職種のチェックボックスを作成
    public function make_form_project_type($regist = []){
        
       $ViewModel = new ViewModel;
       $data = $ViewModel->get_project_type();

        if(!empty($regist)){
            foreach($data as $key => $value){
                $var = "";
               foreach($regist as $id => $project_number){
                 if($key == $project_number){
                   $var = array("not checked");
                   break;
               }
             }
              $project_type[] = $this->form->addElement('checkbox','project_type'.$key,NULL,$value,$var);  
           }
        }else{
              foreach($data as $key => $value){
                  $project_type[] = $this->form->addElement('checkbox','project_type'.$key,NULL,$value);
              }
       }
    }  
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　systemで使うproject typeのviewを作成
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    //project_typeのviewを作成
    public function make_view_project_type($regist_project){
    
        $regist_project = explode('/',$regist_project);
        
        $ViewModel = new ViewModel;
        $data = $ViewModel->get_project_type();
        $var = [];
        
        //職種リストを分解
        foreach($data as $key => $value){                
               foreach($regist_project as $id => $project_number){
                 if($key == $project_number){
                   $var[] = $value;
                   break;
                 }
               }              
        }
        return $var;        
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//        エリアのセレクトボックスを作成
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    //案件の募集エリアを作成
    public function make_form_project_area($regist_area = []){
       
       $ViewModel = new ViewModel;
       $data = $ViewModel->get_area_type();
 
       if(!empty($regist_area)){
           
           $defaults_area = array();           
           
           foreach($regist_area as $key => $value){
               if(!empty($value)){
                    $defaults_area = array_merge($defaults_area,array('area_type'.($key+1) => $value));      
               }
           }
          $this->form->setDefaults($defaults_area);
       }

       $this->form->addElement('select','area_type1','エリア1：',$data);
       $this->form->addElement('select','area_type2','エリア2：',$data);
       $this->form->addElement('select','area_type3','エリア3：',$data);       
    }
    
    //ページリンク作成関数
    public function make_page_link($perPage,$data){
        
        require_once "Pager/Jumping.php";

        $params = array("perPage"  => $perPage,
                        "itemData" => $data,
                        'delta'    => 5,
                        'mode'     => 'Jumping'
                        );
        
        $o_page = new Pager_Jumping($params);        
        $data   = $o_page->getPageData();
        $links  = $o_page->getLinks();
        
        return array($data,$links);        
    }
    
    //パスワードのフォームを作成
    public function make_pass_form(){ 
           $this->form->addElement('text','mail','メールアドレス：',array('size'=>15,'maxlength'=>50));
           $this->form->addElement('password','password','パスワード：',array('size'=>15,'maxlength'=>50));
           $this->form->addElement('submit','submit','ログイン');
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　memberとcustomerの共通の入力値確認：関数群
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
     
    //入力値の確認
    public function check_screen_regist_project($data){
       
            if(!$this->check_area($data,1)){
               $this->area ='勤務地を選択してください';
               $this->action = "form";
             }
          
             if(!$this->check_type_customer($data)){
               $this->project ='職種を選択してください';
               $this->action = "form";
             }
             
             if(!$this->check_shift_customer($data)){
               $this->shift ='時間の設定が不正です';
               $this->action = "form";
             }             
             
             if(!$this->check_t_customer($data)){
               $this->t ='時間の設定が不正です';
               $this->action = "form";                
             }
             
             if(!$this->form->validate()){
               $this->action = "form";
             }
    }  
    
    
    //エリア選択が一つ以上されているか判断
    public function check_area($data,$max){
        
        $i = 1;
        
        while($i <= $max){
           $area = "area_type".$i;
             if(isset($data[$area])){
                if($data[$area] != "1"){
                    return true;
                }
             }
           $i++;
        }
    } 
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　pageIDの発行
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
   //pageIDをURLに
    public function add_pageID(){
        
     //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
     //　 --ここにreturnの条件文を書く--
     //　　 管理権限でかつ　member_listでない場合は　returnする
     //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
        
        $add_pageID = "";
        
        //pageIDを受け取ったとき
        if(isset($_GET['pageID']) && $_GET['pageID'] != ""){            
            $add_pageID = '&pageID='.$_GET['pageID'];
            $_SESSION['pageID'] = $_GET['pageID'];        
        //pageIDを受け取らず、ただし、セッションに値がある
        //(ページ遷移していない)
        }else if(isset($_SESSION['pageID']) && $_SESSION['pageID'] != "" ){            
            $add_pageID = "&pageID=".$_SESSION['pageID'];        
        }
        return $add_pageID;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//   　　デバック用の関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function debug_display(){
        
        //initでdefine false
        if(_DEBUG_MODE){
           $this->debug_str = "";
           if(isset($_SESSION)){
               $this->debug_str .= '<br><br>$_SESSION<br>';
               $this->debug_str .=  var_export($_SESSION,TRUE);
           }
           if(isset($_POST)){
               $this->debug_str .= '<br><br>$_POST<br>';
               $this->debug_str .=  var_export($_SESSION,TRUE);
           }
           if(isset($_GET)){
               $this->debug_str .= '<br><br>$_GET<br>';
               $this->debug_str .= var_export($_GET,TRUE);
           }
           //smartyのデバックモード設定
           //$smarty->debugging = true;
           $this->view->debugging = _DEBUG_MODE;
        }
        
    } 
   

}


?>

