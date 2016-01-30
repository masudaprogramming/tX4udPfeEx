

<?php

class ViewModel extends BaseModel{
        

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     職種の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・            

    public function get_project_type(){
    
       $data = [];
    
       try{
          $sql = "SELECT * FROM project_type";
          $stmh = $this->pdo->query($sql);
          while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
              $data[$row['id']] = $row['project_type'];
          }
        
       } catch (PDOException $Exception) {
           print "エラー".$Exception->getMessage();        
       }
    
       return $data;
    
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     23区のエリア情報の取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function get_area_type(){
        
        $data = [];
        
        try{
            
          $sql = "SELECT * FROM project_area";
          $stmh = $this->pdo->query($sql);
          while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
              $data[$row['id']] = $row['project_area'];
          } 
                     
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
        
        return $data;
        
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//     登録した企業の配列を取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_company_name(){
        
        try{
            $sql = "SELECT * FROM company_list";
            $stmh = $this->pdo->query($sql);
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                $data[$row['id']] = $row['company_name'];
            }

        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
        return $data;
    }
    
}

?>
