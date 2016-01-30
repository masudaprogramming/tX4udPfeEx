<?php


class ActionModel extends BaseModel{

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//    action から情報の取得しそれに対応した案件情報の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_project_action_id($id){
                 
        try{
            
            $data = "";            
            $sql = " SELECT * FROM action 
                     WHERE member_id = :member_id ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = [];
            
            //案件の詳細情報の取得
            $CustomerModel = new CustomerModel;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                    $data[$i][$key] = $value;
                }                            
                
                $project_data = $CustomerModel->get_project($data[$i]['project_id']);
                $data[$i]['title'] = $project_data['title'];
                $data[$i]['company_name'] =  $CustomerModel->get_company_name_company_id($data[$i]['company_id']);
                
                $i++;
            }

        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();            
        }
        return array($data,$count);
    }   
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//    $member_id,$project_idからaction_idの取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_action_some_id($member_id,$project_id){
        
        try{
            $sql = " SELECT * FROM action
                     WHERE
                     (member_id = :member_id) 
                     AND
                     (project_id = :project_id)
                     limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmh->bindValue(':project_id',$project_id,PDO::PARAM_INT);  
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);                    
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }       
      return $row['id'];
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//   idによりデータの取出し
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function get_action_id($id){
        
        try{
            $sql = " SELECT * FROM action 
                    WHERE 
                    id = :id limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_STR);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }  
      return $row;
    }
      
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//　　　action よりデータをcompany_idにより取出
//　　  processの状況に対し日本語を当てはめる
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
     public function get_action_company_id($id){
        
        try{
            $sql = " SELECT * FROM action 
                    WHERE 
                    (company_id = :company_id)
                     ORDER BY reg_date DESC ";            
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_id',$id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            
            $data = array();
            $i = 0;
                                    
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                switch($data[$i]['process']){
                    
                   case "appli":
                   $data[$i]['process'] = "未対応";    
                   break;
                   
                   case "open":
                   $data[$i]['process'] = "<font color='red'>選考中</font><br>";
                   $data[$i]['process'] .= "<font color='blue' size='1'>メッセージBOXで確認ができます</font>";
                   break;
               
                   case "close":
                   $data[$i]['process'] = "<font color='blue'>不採用</font>";
                   break;
                }
              $i++;
            }
            
        } catch (PDOException $Exception) {
           print "エラー".$Exception->getMessage();
        }
      return array($data,$count);
    }
     

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
//　　　　action よりデータをcompany_idと$historyにより取出
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_action_company_id_history($id,$history){
        
        try{
            $sql = " SELECT * FROM action 
                    WHERE 
                    (company_id = :company_id) 
                    AND
                    (process = :process) 
                    ORDER BY reg_date DESC ";            
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_id',$id,PDO::PARAM_INT);
            $stmh->bindValue(':process',$history,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            
            $data = array();
            $i = 0;
                                    
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
     
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　actionのprocessを$project_idにより更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function regist_action_history($project_id,$history){
       
       try{
           
           $this->pdo->beginTransaction();
           
           $sql = "UPDATE action SET
                   process = :process 
                  WHERE
                   project_id = :project_id";
           
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':process',$history,PDO::PARAM_STR);
           $stmh->bindValue(':project_id',$project_id,PDO::PARAM_INT);
           $stmh->execute();
           $this->pdo->commit();
           
       } catch (PDOException $Exception) {
           
           $this->pdo->rollBack();
           print "エラー".$Exception->getMessage();
           
       }       
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　actionへの登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function regist_action($action,$history){
    
       try{
           $this->pdo->beginTransaction();
                   
           $sql = "INSERT INTO action
                  (member_id,company_id,project_id,process,reg_date)
                  VALUES
                  (:member_id,:company_id,:project_id,:process,now())";
           
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':member_id',$action['member_id'],PDO::PARAM_INT);
           $stmh->bindValue(':company_id',$action['company_id'],PDO::PARAM_INT);
           $stmh->bindValue(':project_id',$action['project_id'],PDO::PARAM_INT);
           $stmh->bindValue(':process',$history,PDO::PARAM_STR);
           $stmh->execute();
           $this->pdo->commit();
           
       } catch (PDOException $Exception) {

           $this->pdo->rollBack();
           print "エラー".$Exception->getMessage();
       }
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//  　　action テーブル：関係
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    //action idに対し、応募済かどうか判断    
    public function check_member_action($member_id,$project_id){
        
        try{
            $sql = "SELECT * FROM action 
                    WHERE 
                   ( member_id = :member_id )
                    AND
                   ( project_id = :project_id )";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmh->bindValue(':project_id',$project_id,PDO::PARAM_STR);
            $stmh->execute();
            $count = $stmh->rowCount();
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
        
        if($count >= 1){
            return true;
        }
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//      system で使うactionデータの一覧の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function system_get_all_action(){
        
        try{
            $sql = " SELECT * FROM action 
                     ORDER BY reg_date DESC ";            
            
            $stmh = $this->pdo->query($sql);         
            $count = $stmh->rowCount();
            
            $data = array();
            $i = 0;
                                    
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                switch($data[$i]['process']){
                    
                   case "appli":
                   $data[$i]['process'] = "未対応";    
                   break;
                   
                   case "open":
                   $data[$i]['process'] = "対応中";
                   break;
               
                   case "close":
                   $data[$i]['process'] = "不採用";
                   break;
               
                }
              $i++;
            }
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
       return array($data,$count); 
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//      actionのプロセスの取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function get_action_process_id($action_id){
        
         try{
            $sql = " SELECT process FROM action 
                      WHERE 
                    id = :id 
                      limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$action_id,PDO::PARAM_STR);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }  
      return $row['process'];       
    }

}

?>