
<?php

class SystemModel extends BaseModel{
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     システムの認証情報　格納
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・ 
    
    public function get_authinfo($mail){
        
        try{
            $this->pdo->beginTransaction();
            
            $sql = "SELECT * from system 
                     WHERE
                    mail = :mail";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':mail',$mail,PDO::PARAM_STR);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
        }
       return $row;         
    }
    
    
}

?>
