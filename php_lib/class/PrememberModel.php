<?php

class PrememberModel extends BaseModel{
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //     prememberで使用するmailの重複チェック
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function check_member($memberdata){        
        
        $count = "";
        
        try{
            $sql = "SELECT * FROM premember WHERE mail = :mail ";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',  $memberdata['mail'], PDO::PARAM_STR);
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

    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //     idによりprememberのデータを取得
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function get_premember($id){        
        
        
        try{
            $sql = "SELECT * FROM premember WHERE id = :id limit 1";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',  $id, PDO::PARAM_STR);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
                        
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();             
        }

        return $row;
    }

 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //     prememberに仮会員データを登録
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function regist_premember($data){
        
        try{
            $this->pdo->beginTransaction();
            
            $sql = " INSERT INTO premember
                    ( mail, password , last_name, first_name, birthday, gender,
                      link_pass, reg_date)
                    VALUES 
                    ( :mail, :password , :last_name, :first_name, :birthday, :gender,
                     :link_pass, now() ) ";
            
            $stmh = $this->pdo->prepare($sql);            
            $stmh->bindValue(':mail',$data['mail'],PDO::PARAM_STR);
            $stmh->bindValue(':password',$data['password'],PDO::PARAM_STR);
            $stmh->bindValue(':last_name',$data['last_name'],PDO::PARAM_STR);
            $stmh->bindValue(':first_name',$data['first_name'],PDO::PARAM_STR);
            $stmh->bindValue(':birthday',$data['birthday'],PDO::PARAM_STR);
            $stmh->bindValue(':gender',$data['gender'],PDO::PARAM_INT);
            $stmh->bindValue(':link_pass',$data['link_pass'],PDO::PARAM_STR);            
            $stmh->execute();
            $this->pdo->commit();
                        
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        }
    }
    
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //     mail と　linkpass の一致するメンバーのデータを返信
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・  
    
    public function check_premember($mail,$link_pass){
        
        $memberdata = array();
        
        try{
            
            $sql = "SELECT * FROM premember WHERE mail = :mail AND link_pass = :link_pass limit 1";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$mail,PDO::PARAM_STR);
            $stmh->bindValue(':link_pass',$link_pass,PDO::PARAM_STR);
            $stmh->execute();
            $memberdata = $stmh->fetch(PDO::FETCH_ASSOC);  
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();           
        }

        return $memberdata;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     メンバーの本登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function delete_premember_and_regist_member($memberdata){
        
        try{
            $this->pdo->beginTransaction();
            
            $sql = "DELETE FROM premember where id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$memberdata['id'],PDO::PARAM_STR);
            $stmh->execute();
            
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
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }      
        
    }   

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     仮登録メンバーの削除
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function delete_premember($id){
        
        try{
            $this->pdo->beginTransaction();
            $sql = "DELETE FROM premember WHERE id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_STR);
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }      
        
    }   
    
    
}

?>

