

<?php

class MessageModel extends BaseModel{
    

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//   messageのreを更新
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function modify_message_re_message_id($id){
        
        try{            
            $this->pdo->beginTransaction();
            
            $sql = " UPDATE message 
                      SET re = 1 
                     WHERE id = :id ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$id,PDO::PARAM_STR);
            
            $stmh->execute();       
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        }
    }


//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　memberより単一データでmessageを新規に登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function regist_member_message($data){
        
        try{
            
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO message            
                   (member_id,company_id,project_id,action_id,sender,subject,body,reg_date)
                    VALUES
                   (:member_id,:company_id,:project_id,:action_id,'member',:subject,:body,now())";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$_SESSION[_MEMBER_AUTHINFO]['id'],PDO::PARAM_INT);
            $stmh->bindValue(':company_id',$data['company_id'],PDO::PARAM_INT);
            $stmh->bindValue(':project_id',$data['project_id'],PDO::PARAM_INT);
            $stmh->bindValue(':action_id',$data['action_id'],PDO::PARAM_INT);
            $stmh->bindValue(':subject',$data['subject'],PDO::PARAM_STR);
            $stmh->bindValue(':body',$data['body'],PDO::PARAM_STR);            
            $stmh->execute();
            $this->pdo->commit();
                        
        } catch (PDOException $Exception) {            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        }
    }

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　customerより単一データでmessageを新規に登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function regist_customer_message($data){
        
        try{
            
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO message            
                   (member_id,company_id,project_id,action_id,sender,subject,body,reg_date)
                    VALUES
                   (:member_id,:company_id,:project_id,:action_id,'customer',:subject,:body,now())";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$data['member_id'],PDO::PARAM_INT);
            $stmh->bindValue(':company_id',$_SESSION[_CUSTOMER_AUTHINFO]['id'],PDO::PARAM_INT);
            $stmh->bindValue(':project_id',$data['project_id'],PDO::PARAM_INT);
            $stmh->bindValue(':action_id',$data['action_id'],PDO::PARAM_INT);
            $stmh->bindValue(':subject',$data['subject'],PDO::PARAM_STR);
            $stmh->bindValue(':body',$data['body'],PDO::PARAM_STR);
            
            $stmh->execute();
            $this->pdo->commit();
                        
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        }
    }
    

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　　　　$dataと$sessionでデータを登録
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function regist_customer_message_two_data($data,$session){
        
        try{
            
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO message            
                   (member_id,company_id,project_id,action_id,sender,subject,body,reg_date)
                    VALUES
                   (:member_id,:company_id,:project_id,:action_id,'customer',:subject,:body,now())";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$session['member_id'],PDO::PARAM_INT);
            $stmh->bindValue(':company_id',$_SESSION[_CUSTOMER_AUTHINFO]['id'],PDO::PARAM_INT);
            $stmh->bindValue(':project_id',$session['project_id'],PDO::PARAM_INT);
            $stmh->bindValue(':action_id',$data['action_id'],PDO::PARAM_INT);
            $stmh->bindValue(':subject',$data['subject'],PDO::PARAM_STR);
            $stmh->bindValue(':body',$data['body'],PDO::PARAM_STR);
            
            $stmh->execute();
            $this->pdo->commit();
                        
        } catch (PDOException $Exception) {
            
            $this->pdo->rollBack();
            print "エラー".$Exception->getMessage();
            
        }
    }

//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//   　　message_idによりmessageのデータを取得
//  　　 bodyは改行記号を<br>にして返す
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_message_message_id($message_id){
        
        try{
            $sql = " SELECT * FROM message 
                      WHERE 
                     id = :id 
                     limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$message_id,PDO::PARAM_INT);
            $stmh->execute();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
            $row['body']  = htmlspecialchars($row['body'],ENT_QUOTES);
            $row['body'] = nl2br($row['body']);
                        
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
       return $row;
    }
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//   action_idによりmessageのデータを取得
//   bodyは改行記号を<br>にして返す
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_message_action_id($action_id){
        
        try{
            $sql = " SELECT * FROM message 
                      WHERE 
                     action_id = :id ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$action_id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            
            $row['body']  = htmlspecialchars($row['body'],ENT_QUOTES);
            $row['body'] = nl2br($row['body']);
                        
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();
        }
       return $row;
    }
    
    

    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//　   message_idによりmessageの詳細表示用のデータを取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function member_detail_message_messsage_id($message_id){
        
        try{
            $sql = " SELECT * FROM message 
                      WHERE 
                     id = :id 
                     limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$message_id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
            
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
                        
            $project_data = $CustomerModel->get_project_title($data['project_id']);
            $company_name = $CustomerModel->get_company_name_company_id($data['company_id']);
            $action_data  = $ActionModel->get_action_id($data['action_id']);
                        
            $data['action_reg_date']  = $action_data['reg_date'];
            $data['company_name']     = $company_name;
            $data['title']            = $project_data;
            $data['body'] =  htmlspecialchars($data['body'],ENT_QUOTES);
            $data['body'] = nl2br($data['body']);
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();           
        }
         return $data;     
    }
    
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
// 　　　  message_idによりmessageの詳細表示用のデータを取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_detail_message_messsage_id($message_id){
        
        try{
            $sql = " SELECT * FROM message 
                      WHERE 
                     id = :id 
                     limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id',$message_id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
                        
            $MemberModel = new MemberModel;
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
            
            $member_data = $MemberModel->get_member_base_info_id($data['member_id']);
            $project_data = $CustomerModel->get_project_title($data['project_id']);
            $action_data  = $ActionModel->get_action_id($data['action_id']);
                        
            $data['member_last_name'] = $member_data['last_name'];
            $data['member_first_name'] = $member_data['first_name'];
            $data['action_reg_date']  = $action_data['reg_date'];
            $data['title']            = $project_data;
            $data['body'] =  htmlspecialchars($data['body'],ENT_QUOTES);
            $data['body'] =  nl2br($data['body']);
            
        } catch (PDOException $Exception) {
            print "エラー".$Exception->getMessage();           
        }
      return $data;  
    }
    
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//  　  customer_idによりmessageのデータを取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_message_customer_id($customer_id){
        
        try{
            $sql = " SELECT * FROM message 
                      WHERE 
                     company_id = :company_id ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_id',$customer_id,PDO::PARAM_INT);
            $stmh->execute();
            $count = $stmh->rowCount();
            
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

//**********************************************************************************
//    customer で使用
//**********************************************************************************
    
    //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    //   customerで使用するmessageの★transmit★一覧listのデータを取得
    //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_transmit_message_list_customer_id($customer_id){
        
        try{
            $sql = "SELECT * FROM message
                      WHERE 
                     ( company_id = :company_id )
                      AND 
                     ( sender = 'customer' )
                      ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_id',$customer_id,PDO::PARAM_STR);
            $stmh->execute();
            
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = array();
            
            $MemberModel = new MemberModel;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                $member_data = $MemberModel->get_member_base_info_id($data[$i]['member_id']);
                
                $data[$i]['member_last_name'] = $member_data['last_name'];
                $data[$i]['member_first_name'] = $member_data['first_name'];

                $i++;
            }
            
                    
        } catch (PDOException $Exception) {
            
            print "エラー".$Exception->getMessage();
            
        }
        return array($data,$count);
    }
    
    //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    //   customerで使用するmessageの★receive★一覧listのデータを取得
    //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    public function get_receive_message_list_customer_id($customer_id){
        
        try{
            $sql = "SELECT * FROM message
                      WHERE 
                     ( company_id = :company_id )
                      AND 
                     ( sender = 'member' ) 
                     ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':company_id',$customer_id,PDO::PARAM_STR);
            $stmh->execute();
            
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = array();
            
            $MemberModel = new MemberModel;            
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                $member_data = $MemberModel->get_member_base_info_id($data[$i]['member_id']);
                $data[$i]['member_last_name'] = $member_data['last_name'];
                $data[$i]['member_first_name'] = $member_data['first_name'];           
                
                $i++;
            }
            
                    
        } catch (PDOException $Exception) {
            
            print "エラー".$Exception->getMessage();
            
        }
        return array($data,$count);
    }
    
//**********************************************************************************
//    member で使用
//**********************************************************************************

 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //   memberで使用するmessageの★receive★一覧listのデータを取得
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・    
    
    public function get_receive_message_list_member_id($member_id){
         
       try{
            $sql = "SELECT * FROM message
                      WHERE 
                     ( member_id = :member_id )
                      AND 
                     ( sender = 'customer' )
                      ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmh->execute();
            
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = array();
            
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                $action_data   = $ActionModel->get_action_id($data[$i]['action_id']);
                $customer_data = $CustomerModel->get_customer_authinfo_id($data[$i]['company_id']);
                
                $data[$i]['action_reg_date']  = $action_data['reg_date'];
                $data[$i]['company_name']     = $customer_data['company_name'];
                
                $i++;
            }
                    
        } catch (PDOException $Exception) {
            
            print "エラー".$Exception->getMessage();
            
        }
        return array($data,$count);
        
    }

 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
 //   memberで使用するmessageの★transmit★一覧listのデータを取得
 //・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_transmit_message_list_member_id($member_id){
        
        try{
            $sql = "SELECT * FROM message
                      WHERE 
                     ( member_id = :member_id )
                      AND 
                     ( sender = 'member' )
                      ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmh->execute();
            
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = array();
            
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                $action_data   = $ActionModel->get_action_id($data[$i]['action_id']);
                $customer_data = $CustomerModel->get_customer_authinfo_id($data[$i]['company_id']);
                
                $data[$i]['action_reg_date']  = $action_data['reg_date'];
                $data[$i]['company_name']     = $customer_data['company_name'];
                
                $i++;
            }
            
                    
        } catch (PDOException $Exception) {
            
            print "エラー".$Exception->getMessage();
            
        }
        return array($data,$count);
    }

    
//**********************************************************************************
//    system で使用
//**********************************************************************************
//    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//    すべてのmessageを取得
//    値を変換
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function get_system_all_message(){
    
       try{
            $sql = " SELECT * FROM message 
                    ORDER BY reg_date DESC ";
            
            $stmh = $this->pdo->query($sql);
            $stmh->execute();
            
            $count = $stmh->rowCount();
            
            $i = 0;
            $data = array();
            
            $MemberModel = new MemberModel;
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
            
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                
                foreach($row as $key => $value){
                   $data[$i][$key] = $value;
                }
                
                $action_data   = $ActionModel->get_action_id($data[$i]['action_id']);
                $customer_data = $CustomerModel->get_customer_authinfo_id($data[$i]['company_id']);
                $member_data = $MemberModel->get_member_base_info_id($data[$i]['member_id']);
                
                $data[$i]['action_reg_date']  = $action_data['reg_date'];
                $data[$i]['company_name']     = $customer_data['company_name'];
                $data[$i]['member_last_name'] = $member_data['last_name'];      
                $data[$i]['member_first_name'] = $member_data['first_name'];
                $i++;
            }
            
                    
        } catch (PDOException $Exception) {
            
            print "エラー".$Exception->getMessage();
            
        }
        return array($data,$count);
    }   
    
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//    message_idからsystemで使用するための値を取得
//・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
    
    public function system_get_detail_message_messsage_id($message_id){
        
        try{
            $sql = " SELECT * FROM message 
                    WHERE
                     id = :message_id 
                     limit 1 ";
            
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':message_id',$message_id,PDO::PARAM_INT);
            $stmh->execute();
            
            
            $i = 0;
            $data = array();
            
            $MemberModel = new MemberModel;
            $CustomerModel = new CustomerModel;
            $ActionModel   = new ActionModel;
            
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
            
            $action_data   = $ActionModel->get_action_id($data['action_id']);
            $customer_data = $CustomerModel->get_customer_authinfo_id($data['company_id']);
            $member_data   = $MemberModel->get_member_base_info_id($data['member_id']);
            $project_data  = $CustomerModel->get_project_title($data['project_id']);
                
            $data['action_reg_date']  = $action_data['reg_date'];
            $data['company_name']     = $customer_data['company_name'];
            $data['member_name']      = $member_data['last_name'].'&nbsp;'.$member_data['first_name'];
            $data['title']            = $project_data;
            
            $data['body']  = htmlspecialchars($data['body'],ENT_QUOTES);
            $data['body']  = nl2br($data['body']);
            
            $i++;           
                    
        } catch (PDOException $Exception) {            
            print "エラー".$Exception->getMessage();
        }
        return $data;        
        
    }
    
    
}

?>
