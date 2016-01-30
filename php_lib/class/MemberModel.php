<?php

class MemberModel extends BaseModel{
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
//  system : memberの一覧を取得
//           必要なデータだけを取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function system_get_member_list(){
        
        try{
            $sql = " SELECT id,last_name,first_name,mail,gender,reg_date FROM member ORDER BY reg_date DESC ";
            $stmh = $this->pdo->query($sql);
            
            $count = $stmh->rowCount();
            
            $data = array();
            $i = 0;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $key => $value ){
                    $data[$i][$key] = $value;
                }
               $i++; 
            }
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }      
       return array($data,$count);
    }  
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
//  メンバーの削除に関する関数
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function delete_member($id){
        
       try{
            $this->pdo->beginTransaction();     
            $sql = "DELETE FROM member WHERE id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_STR);
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();   
            print "エラー".$Exception->getMessage();          
        }
    }    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・      
//     入力されたメールがすでに登録されているかどうか確認
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function check_member($memberdata){
        
        $count = "";
        
        try{
            $sql = "SELECT * FROM member WHERE mail = :mail ";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$memberdata['mail'],PDO::PARAM_STR);
            $stmh->execute();
            $count = $stmh->rowCount();
            
        } catch (PDOException $Exception) {
       
            print "エラー".$Exception->getMessage();            
        }
        
        if($count >= 1){
            return true;
        }else{
            return false;
        }
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//       メールによるメンバー情報の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function get_member_authinfo($mail){
        
        try{
           
          $sql = " SELECT * FROM member WHERE mail = :mail limit 1 ";  
          $stmh = $this->pdo->prepare($sql);
          $stmh->bindValue(':mail',$mail,PDO::PARAM_STR);
          $stmh->execute();
          $row = $stmh->fetch(PDO::FETCH_ASSOC);
                    
        } catch (PDOException $Exception) {

            print "エラー".$Exception->getMessage();          
        
        }
        return $row;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・      
//       idによるメンバーの基本情報の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    public function get_member_base_info_id($id){
        
        try{
            
           $sql = " SELECT * FROM member WHERE id = :id limit 1"; 
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':id',$id,PDO::PARAM_INT);
           $stmh->execute();
           $row = $stmh->fetch(PDO::FETCH_ASSOC);
           $row['password'] = "";
           
        } catch (PDOException $Exception) {
           
           print "エラー".$Exception->getMessage();
           
        }
        return $row;
    }
  
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
//   　　　idによるメンバーの名前の取得 
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    public function get_member_name_info_id($id){
        
        try{
            
           $sql = " SELECT last_name,first_name FROM member WHERE id = :id limit 1"; 
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':id',$id,PDO::PARAM_INT);
           $stmh->execute();
           $row = $stmh->fetch(PDO::FETCH_ASSOC);
                      
        } catch (PDOException $Exception) {
           
           print "エラー".$Exception->getMessage();
           
        }
        return $row;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　memberへの基本データの登録systemから使用
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
  public function regist_member_return_id($memberdata){
        
        try{
            $this->pdo->beginTransaction();
                       
            $sql = "INSERT INTO member
                    (mail,last_name,first_name,birthday,gender,
                     password,reg_date)
                   VALUES
                    (:mail,:last_name,:first_name,:birthday,:gender,
                     :password,now())";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$memberdata['mail'],PDO::PARAM_STR);
            $stmh->bindValue(':last_name',$memberdata['last_name'],PDO::PARAM_STR);
            $stmh->bindValue(':first_name',$memberdata['first_name'],PDO::PARAM_STR);
            $stmh->bindValue(':birthday',$memberdata['birthday'],PDO::PARAM_STR);
            $stmh->bindValue(':gender',$memberdata['gender'],PDO::PARAM_INT);
            $stmh->bindValue(':password',$memberdata['password'],PDO::PARAM_STR);
            $stmh->execute();            
            $this->pdo->commit();
            
            $sql = " SELECT id FROM member 
                      WHERE 
                     mail = :mail ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$memberdata['mail'],PDO::PARAM_STR);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }      
      return $row['id'];  
    } 
    
    
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
  //　　　memberへの追加データの登録
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function regist_add_member($memberdata,$id){
        
        try{
            $this->pdo->beginTransaction();            
            $sql = "UPDATE  member SET
                    hope_start = :hope_start, 
                    area_type  = :area_type,
                    project_type = :project_type,
                    expe_appeal = :expe_appeal,
                    record      = 'on' 
                    WHERE id = :id";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':hope_start',$memberdata['hope_start'],PDO::PARAM_STR);
            $stmh->bindValue(':area_type',$memberdata['area_type'],PDO::PARAM_STR);
            $stmh->bindValue(':project_type',$memberdata['project_type'],PDO::PARAM_STR);
            $stmh->bindValue(':expe_appeal',$memberdata['expe_appeal'],PDO::PARAM_STR);
            $stmh->bindValue(':id',$id,PDO::PARAM_STR);
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        } 
    }

    
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
  //　　　member データ(パス以外)の更新
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・   
    
    public function modify_member($data){
        
        try{
            $this->pdo->beginTransaction();            
            $sql = "UPDATE  member SET
                    mail       = :mail,
                    last_name  = :last_name,
                    first_name = :first_name,
                    birthday   = :birthday,
                    gender     = :gender,
                    hope_start = :hope_start, 
                    area_type  = :area_type,
                    project_type = :project_type,
                    expe_appeal = :expe_appeal
                    WHERE id = :id";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$data['mail'],PDO::PARAM_STR);
            $stmh->bindValue(':last_name',$data['last_name'],PDO::PARAM_STR);
            $stmh->bindValue(':first_name',$data['first_name'],PDO::PARAM_STR);
            $stmh->bindValue(':birthday',$data['birthday'],PDO::PARAM_STR);
            $stmh->bindValue(':gender',$data['gender'],PDO::PARAM_INT);
            
            $stmh->bindValue(':hope_start',$data['hope_start'],PDO::PARAM_STR);
            $stmh->bindValue(':area_type',$data['area_type'],PDO::PARAM_STR);
            $stmh->bindValue(':project_type',$data['project_type'],PDO::PARAM_STR);
            $stmh->bindValue(':expe_appeal',$data['expe_appeal'],PDO::PARAM_STR);
            $stmh->bindValue(':id',$data['id'],PDO::PARAM_INT);
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        } 
        
    }     
    
    
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
  //　　　memberのパス 更新
  //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    
    public function modify_member_pass($data){
        
        try{
           $this->pdo->beginTransaction();
           
           $sql = "UPDATE member SET
                   password = :password
                   WHERE id = :id";
           
           $stmh = $this->pdo->prepare($sql);
           $stmh->bindValue(':password',$data['password'],PDO::PARAM_STR);
           $stmh->bindValue(':id',$data['id'],PDO::PARAM_INT);
           $stmh->execute();
           $this->pdo->commit();
             
        } catch (PDOException $Exception) {

            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();           
            
        }
    }
    
    
}

?>

