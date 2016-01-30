
<?php

class CustomerModel extends BaseModel{

    
// CustomerModelにcustomer以外のテーブルも記載
 
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//   　サーチキーでの検索機能は、今後、拡張
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・

    public function get_project_list($company_id){
        
        try{
         
          $sql = "SELECT * FROM project 
                   WHERE 
                  company_id = :company_id
                   ORDER BY reg_date DESC";
          
          $stmh = $this->pdo->prepare($sql);
          $stmh->bindValue(':company_id',$company_id,PDO::PARAM_INT);
          $stmh->execute();
          $count = $stmh->rowCount();
          
          $i = 0;
          $data    = array();
          $project = array();
          $area    = array();
          
          $ViewModel = new ViewModel;
          $project = $ViewModel->get_project_type();
          $area    = $ViewModel->get_area_type();
          
          while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
              foreach($row as $key => $value){
                  $data[$i][$key] = $value;
              }
              
            //格納データ　数字から文字へ変換  
            $key1 = $data[$i]['project_type'];
            $key2 = $data[$i]['area_type'];
            $data[$i]['project_type'] = $project[$key1];
            $data[$i]['area_type']    = $area[$key2];            
            $i++;
          }
            
        } catch (PDOException $Exception) {
             print "エラー".$Exception->getMessage();
        }
      return array($data,$count);
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　募集中の案件のみ抽出、indexで使用
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_valid_project_list($project_type = "", $area_type = "", $search_key ="",$member_id = ""){
        
          $sql = " SELECT * FROM project WHERE valid = 1 ";

          if($project_type != ""){
              $sql .= " AND (project_type = :project_type) ";
          }
          
          if($area_type != ""){
              $sql .= " AND (area_type = :area_type) ";
          }
          
          if($search_key != ""){
              $sql .= " AND (title like :title OR project_content like :project_content) ";
          }
             
          $sql .= " ORDER BY reg_date DESC ";
          
          if($member_id != ""){
              $BaseController = new BaseController;
          }
          
        
        try{
          $stmh = $this->pdo->prepare($sql); 
          
          if($search_key != ""){
              $search_key = "%".$search_key."%";             
              $stmh->bindValue(':title',$search_key,PDO::PARAM_STR);
              $stmh->bindValue(':project_content',$search_key,PDO::PARAM_STR);
          }
          
          if($project_type != ""){
              $stmh->bindValue(':project_type',$project_type,PDO::PARAM_INT);
          }
          
          if($area_type != ""){
              $stmh->bindValue(':area_type',$area_type,PDO::PARAM_INT);
          }
          
          $stmh->execute();
          
          $ViewModel = new ViewModel;
          $ActionModel = new ActionModel;
          $i = 0;
          $data = array();
          $count = $stmh->rowCount();
          $project = array();
          $area    = array();
          $company = "";
          
          $project = $ViewModel->get_project_type();
          $area    = $ViewModel->get_area_type();
          $company = $ViewModel->get_company_name();
    
          while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
              foreach($row as $key => $value){
                  $data[$i][$key] = $value;
              }
              
            //格納データ　数字から文字へ変換  
            $key1 = $data[$i]['project_type'];
            $key2 = $data[$i]['area_type'];
            $key3 = $data[$i]['company_id'];
            
            $data[$i]['project_type'] = $project[$key1];
            $data[$i]['area_type']    = $area[$key2];
            $data[$i]['company_name']   = $company[$key3];

            $data[$i]['action'] = 0;
            
            if($member_id != ""){
               if($ActionModel->check_member_action($member_id,$data[$i]['id'])){
                    $data[$i]['action'] = 1;          
               }
            }
            
            $i++;
          }
            
        } catch (PDOException $Exception) {
             print "エラー".$Exception->getMessage();
        }
        return array($data,$count);
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　　募集中の案件のみ抽出、indexで使用
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_valid_tomorrow_project_list($project_type = "", $area_type = "", $search_key ="",$member_id = ""){
        
          $sql =  " SELECT * FROM project 
                       WHERE 
                     valid = 1 
                       AND 
                     t_start = :tomorrow ";
                     
                  
          if($project_type != ""){
              $sql .= " AND (project_type = :project_type) ";
          }
          
          if($area_type != ""){
              $sql .= " AND (area_type = :area_type) ";
          }
          
          if($search_key != ""){
              $sql .= " AND (title like :title OR project_content like :project_content) ";
          }
             
          $sql .= " ORDER BY reg_date DESC ";
          
          if($member_id != ""){
              $BaseController = new BaseController;
          }
                  
        try{
          $stmh = $this->pdo->prepare($sql);
          
          $tomorrow = date('Ymd') + 1;
          $stmh->bindValue(':tomorrow',$tomorrow,PDO::PARAM_STR);
          
          if($search_key != ""){
              $search_key = "%".$search_key."%";             
              $stmh->bindValue(':title',$search_key,PDO::PARAM_STR);
              $stmh->bindValue(':project_content',$search_key,PDO::PARAM_STR);
          }
          
          if($project_type != ""){
              $stmh->bindValue(':project_type',$project_type,PDO::PARAM_INT);
          }
          
          if($area_type != ""){
              $stmh->bindValue(':area_type',$area_type,PDO::PARAM_INT);
          }
          
          $stmh->execute();
          
          $ViewModel = new ViewModel;
          $ActionModel = new ActionModel;
          $i = 0;
          $data = array();
          $count = $stmh->rowCount();
          $project = array();
          $area    = array();
          $company = "";
          
          $project = $ViewModel->get_project_type();
          $area    = $ViewModel->get_area_type();
          $company = $ViewModel->get_company_name();
    
          while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
              foreach($row as $key => $value){
                  $data[$i][$key] = $value;
              }
              
            //格納データ　数字から文字へ変換  
            $key1 = $data[$i]['project_type'];
            $key2 = $data[$i]['area_type'];
            $key3 = $data[$i]['company_id'];
            
            $data[$i]['project_type'] = $project[$key1];
            $data[$i]['area_type']    = $area[$key2];
            $data[$i]['company_name']   = $company[$key3];

            $data[$i]['action'] = 0;
            
            if($member_id != ""){
               if($ActionModel->check_member_action($member_id,$data[$i]['id'])){
                    $data[$i]['action'] = 1;          
               }
            }
            
            $i++;
          }
            
        } catch (PDOException $Exception) {
             print "エラー".$Exception->getMessage();
        }
        return array($data,$count);
    }
    
    
    
//*******************************************************************************
//　　　　id　で該当する案件のデータを取出し
//*******************************************************************************
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
// 　　　　idから情報を取出し未加工のまま値を渡す
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_project_raw($project_id){
        
       try{
           $sql = "SELECT * FROM project WHERE id = :id limit 1";
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':id',$project_id,PDO::PARAM_INT);
           $stmh->execute();
           $row = $stmh->fetch(PDO::FETCH_ASSOC);      
            
       } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();    
       } 
      return $row;
    }
    

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　 idから情報を取出し、対応する名称への変更も行う    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_project($project_id,$member_id = ""){
        
        try{
            $sql = "SELECT * FROM project WHERE id = :id limit 1";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$project_id,PDO::PARAM_INT);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
            $row['action'] = 0;
                        
            if($member_id != ""){
                $ActionModel = new ActionModel;
                if($ActionModel->check_member_action($member_id,$project_id)){
                    $row['action'] = 1;
                }
            }

            $ViewModel = new ViewModel;
            $project = $ViewModel->get_project_type();
            $area    = $ViewModel->get_area_type();
            $company = $ViewModel->get_company_name();
            
            $row['project_type'] = $project[$row['project_type']];
            $row['area_type']    = $area[$row['area_type']];
            $row['company_name'] = $company[$row['company_id']];
            
            
        }catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
       return $row;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
// 　　　　idから情報を取出し、対応する名称への変更も行う    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_project_title($project_id){
        
        try{
            $sql = "SELECT * FROM project WHERE id = :id limit 1";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$project_id,PDO::PARAM_INT);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);            
            
        }catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
       return $row['title'];
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　　案件登録機能
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function regist_project($data){
        
        try{
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO project
                   (valid,company_id,project_type,area_type,t_start,t_end,shift_start,shift_end,salary_per_hour,
                    transportation,title,project_content,reg_date)
                   VALUES
                   (:valid,:company_id,:project_type,:area_type,:t_start,:t_end,:shift_start,:shift_end,:salary_per_hour,
                    :transportation,:title,:project_content,now())";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':valid',$data['valid'],PDO::PARAM_INT);
            $stmh->bindValue(':company_id',$data['company_id'],PDO::PARAM_INT);
            $stmh->bindValue(':project_type',$data['project_type'],PDO::PARAM_INT);
            $stmh->bindValue(':area_type',$data['area_type1'],PDO::PARAM_INT);
            $stmh->bindValue(':t_start',$data['t_start'],PDO::PARAM_STR);
            $stmh->bindValue(':t_end',$data['t_end'],PDO::PARAM_STR);
            $stmh->bindValue(':shift_start',$data['shift_start'],PDO::PARAM_STR);
            $stmh->bindValue(':shift_end',$data['shift_end'],PDO::PARAM_STR);
            $stmh->bindValue(':salary_per_hour',$data['salary_per_hour'],PDO::PARAM_INT);
            $stmh->bindValue(':transportation',$data['transportation'],PDO::PARAM_INT);
            $stmh->bindValue(':title',$data['title'],PDO::PARAM_STR);
            $stmh->bindValue(':project_content',$data['project_content'],PDO::PARAM_STR);
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();            
        }
    }

    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　　案件の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function modify_project($data,$id){
        
        try{
            $this->pdo->beginTransaction();
            
            $sql = "UPDATE project
                    SET
                   valid = :valid,
                   project_type = :project_type,
                   area_type = :area_type,
                   t_start = :t_start,
                   t_end = :t_end,
                   shift_start = :shift_start,
                   shift_end = :shift_end,
                   salary_per_hour = :salary_per_hour,
                   transportation = :transportation,
                   title = :title,
                   project_content = :project_content,
                   reg_date = now()
                   WHERE id = :id";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':valid',$data['valid'],PDO::PARAM_INT);
            $stmh->bindValue(':project_type',$data['project_type'],PDO::PARAM_INT);
            $stmh->bindValue(':area_type',$data['area_type1'],PDO::PARAM_INT);
            $stmh->bindValue(':t_start',$data['t_start'],PDO::PARAM_STR);
            $stmh->bindValue(':t_end',$data['t_end'],PDO::PARAM_STR);
            $stmh->bindValue(':shift_start',$data['shift_start'],PDO::PARAM_STR);
            $stmh->bindValue(':shift_end',$data['shift_end'],PDO::PARAM_STR);
            $stmh->bindValue(':salary_per_hour',$data['salary_per_hour'],PDO::PARAM_INT);
            $stmh->bindValue(':transportation',$data['transportation'],PDO::PARAM_INT);
            $stmh->bindValue(':title',$data['title'],PDO::PARAM_STR);
            $stmh->bindValue(':project_content',$data['project_content'],PDO::PARAM_STR);
            $stmh->bindValue(':id',$id,PDO::PARAM_INT);
            $stmh->execute();
            $this->pdo->commit();             
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　　　案件の削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function delete_project($id){
        
        try{
           $this->pdo->beginTransaction();   
           $sql = "DELETE FROM project WHERE id = :id";
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':id',$id,PDO::PARAM_STR); 
           $stmh->execute();
           $this->pdo->commit();
            
        } catch (PDOException $Exception) {

           $this->pdo->rollBack();
           print "エラー".$Exception->getMessage(); 
        }
    }
    
    
    
//＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
//　以下、顧客情報に関する関数
//＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
   
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　   systemで使用するリストの取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function system_get_customer_list(){
    
        try{
            $sql = " SELECT id,company_name,tel,last_name,first_name,reg_date 
                       FROM 
                     customer 
                       ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->query($sql);
            $count = $stmh->rowCount();
            $data = array();
            $i    = 0;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
              $i++;
            }           
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
      return array($data,$count);    
    }
   
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　   member(トップ)で使用するリストの取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function member_get_customer_list(){
    
        try{
            $sql = " SELECT company_name,appeal,address 
                       FROM 
                     customer 
                       ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->query($sql);
            $count = $stmh->rowCount();
            $data = array();
            $i    = 0;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
              $i++;
            }           
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
      return array($data,$count);    
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　company_idが一致する顧客のデータを取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_customer_authinfo_id($id){
        
        try{
          $sql = " SELECT * FROM customer WHERE id = :company_id limit 1 ";  
          $stmh = $this->pdo->prepare($sql);
          $stmh->bindValue(':company_id',$id,PDO::PARAM_STR);
          $stmh->execute();
          $row = $stmh->fetch(PDO::FETCH_ASSOC);
                    
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();          
        }
        return $row;
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　mailが一致する顧客のデータを取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    public function get_customer_authinfo($mail){
        
        try{
          $sql = " SELECT * FROM customer WHERE mail = :mail limit 1 ";  
          $stmh = $this->pdo->prepare($sql);
          $stmh->bindValue(':mail',$mail,PDO::PARAM_STR);
          $stmh->execute();
          $row = $stmh->fetch(PDO::FETCH_ASSOC);
                    
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();          
        }
        return $row;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　会社情報の更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
  
    public function modify_customer_company($data){
        
        try{
            
           $this->pdo->beginTransaction();
           
           $sql = "UPDATE customer
                   SET
                    company_name  = :company_name,
                    mail          = :mail,
                    tel           = :tel,
                    address       = :address,
                    appeal        = :appeal,
                    last_name     = :last_name,
                    first_name    = :first_name
                    WHERE id = :id";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_name',$data['company_name'],PDO::PARAM_STR);
            $stmh->bindValue(':mail',$data['mail'],PDO::PARAM_STR);
            $stmh->bindValue(':tel',$data['tel'],PDO::PARAM_STR);
            $stmh->bindValue(':address',$data['address'],PDO::PARAM_STR);
            $stmh->bindValue(':appeal',$data['appeal'],PDO::PARAM_STR);
            $stmh->bindValue(':last_name',$data['last_name'],PDO::PARAM_STR);
            $stmh->bindValue(':first_name',$data['first_name'],PDO::PARAM_STR);
            $stmh->bindValue(':id',$data['id'],PDO::PARAM_INT);
            $stmh->execute();
            
            $sql = "UPDATE company_list
                   SET
                   company_name = :company_name
                   WHERE
                   id = :company_id";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_name',$data['company_name'],PDO::PARAM_STR);
            $stmh->bindValue(':company_id',$data['id'],PDO::PARAM_INT);
            $stmh->execute();
            
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {

            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }
       
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　会社名の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
   
    public function get_company_name_company_id($id){
    
       try{          
           
           $sql = " SELECT company_name FROM company_list
                     WHERE id = :id 
                    limit 1 ";
          
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':id',$id,PDO::PARAM_INT);
           $stmh->execute();
           $row = $stmh->fetch(PDO::FETCH_ASSOC);
           
       } catch (PDOException $Exception) {
           print "エラー".$Exception->getMessage();           
       }
      return $row['company_name'];
    }
   
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　顧客情報の登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function regist_customer($data){
        
        try{            
            $this->pdo->beginTransaction();
            
            //同時にテーブルに登録するため、
            //company_idのidと　customerのidはずれない
            
            //customer_listに登録
            $sql =  "INSERT INTO company_list
                      (company_name) 
                     VALUES 
                      (:company_name)";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_name',$data['company_name'],PDO::PARAM_STR);
            $stmh->execute();
            
            $sql =  "INSERT INTO customer
                   (password,company_name,mail,tel,address,appeal,last_name,first_name,reg_date)
                     VALUES 
                   (:password,:company_name,:mail,:tel,:address,:appeal,:last_name,:first_name,now())"; 
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':password',$data['password'],PDO::PARAM_STR);
            $stmh->bindValue(':company_name',$data['company_name'],PDO::PARAM_STR);
            $stmh->bindValue(':mail',$data['mail'],PDO::PARAM_STR);
            $stmh->bindValue(':tel',$data['tel'],PDO::PARAM_STR);
            $stmh->bindValue(':address',$data['address'],PDO::PARAM_STR);
            $stmh->bindValue(':appeal',$data['appeal'],PDO::PARAM_STR);
            $stmh->bindValue(':last_name',$data['last_name'],PDO::PARAM_STR);
            $stmh->bindValue(':first_name',$data['first_name'],PDO::PARAM_STR);
            $stmh->execute();
            
            $this->pdo->commit();            
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();            
        }
    }
    
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　顧客情報の削除
//    下記のテーブルよりidに一致する情報の削除
//　　・company_list
//   ・customer
//　　・action
//　　・message
//　　・project  
//   応募履歴　//すべて削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function delete_customer($id){
        
        try{            
            $this->pdo->beginTransaction();
            
            //company_list
            $sql = "DELETE FROM company_list 
                      WHERE id = :id";            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_INT);
            $stmh->execute();
            
            //customer
            $sql = "DELETE FROM customer 
                      WHERE id = :id";            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_INT);
            $stmh->execute();
            
            //action
            $sql = "DELETE FROM action 
                      WHERE company_id = :id";            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_INT);
            $stmh->execute();
            
            //project
            $sql = "DELETE FROM project 
                      WHERE company_id = :id";            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_INT);
            $stmh->execute();
            
            $this->pdo->commit();            
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();            
        }
    }
    
//********************************************************************************
//　　 案件の時間による管理
//********************************************************************************
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
// 　　　　　　本日より前の案件の募集終了
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function valid_off_yesterday_project(){
        
        $today = date('Ymd');
        
        try{
            $this->pdo->beginTransaction();
            
            $sql =  "UPDATE project 
                      SET 
                     valid = 0 
                      WHERE 
                     t_start <= :today";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':today',$today,PDO::PARAM_INT);
            $stmh->execute();
            $this->pdo->commit();
                        
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }
       
    }
    
}

?>

