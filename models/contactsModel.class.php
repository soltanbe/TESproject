<?php

require_once 'lib/database.class.php';

class contactsModel

{
    private $db;

    function __construct()
    {
        $database = new database();
        $this->db=$database->getConnection();


    }
    function addUpdateContact($post){
        if($post['con_id']==0){
           $sql="select * from contacts where phone=?";
          $query=$this->db->prepare($sql);
          $query->execute(array($post['phone']));
           if($query->rowCount()==0){
                $sql = "INSERT INTO contacts (first_name, last_name,age,email,gender,phone,created_date) VALUES (?,?,?,?,?,?,?)";
            $stmt= $this->db->prepare($sql);
            $res=$stmt->execute(array(
                    $post['first_name'],
                    $post['last_name'],
                    $post['age'],
                    $post['email'],
                    $post['gender'],
                    $post['phone'],
                    date('Y-m-d h:i:s')
            ));
            return true;
           }else{
              return 'exist'; 
           } 
        }
        if($post['con_id']>0){
          
           /*$sql="select * from contacts where phone=?";
          $query=$this->db->prepare($sql);
          $query->execute(array($post['phone']));
           if($query->rowCount()=1){
                $sql = "UPDATE contacts SET first_name=?,last_name=?,age=?,email=?,gender=?,phone=?,updated_date=? WHERE id=?";
            $stmt= $this->db->prepare($sql);
            $res=$stmt->execute(array(
                    $post['first_name'],
                    $post['last_name'],
                    $post['age'],
                    $post['email'],
                    $post['gender'],
                    $post['phone'],
                    date('Y-m-d h:i:s'),
                    $post['con_id'],
            ));
            return true;
           }else{
              return 'exist'; 
           } */
              $sql = "UPDATE contacts SET first_name=?,last_name=?,age=?,email=?,gender=?,phone=?,updated_date=? WHERE id=?";
            $stmt= $this->db->prepare($sql);
            $res=$stmt->execute(array(
                    $post['first_name'],
                    $post['last_name'],
                    $post['age'],
                    $post['email'],
                    $post['gender'],
                    $post['phone'],
                    date('Y-m-d h:i:s'),
                    $post['con_id'],
            ));
            return true;
        }
         
    }
    function getContacts($post)
    {
          $where='';
          $params=array();
        if(!empty($post['search']['value'])){
            $where.=" AND (phone LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR email LIKE ?) ";
            $s=trim($post['search']['value']);
            $params[]="%$s%";
            $params[]="%$s%";
            $params[]="%$s%";
            $params[]="%$s%";
        }

        $sql="select id from contacts where 1=1 $where";
        $query=$this->db->prepare($sql);
        $query->execute($params);
       $res['cnt']=$query->rowCount();
        //$params[]=(int)$post['length'];
        $length=$post['length'];
        //$params[]=(int)$post['start'];
           $start=$post['start'];
        $sql="select * from contacts where 1=1 $where LIMIT $length OFFSET $start";
       
        $query=$this->db->prepare($sql);
         $query->execute($params);
       $result=$query->fetchAll(PDO::FETCH_ASSOC);
        $res['rows']=$result;

        return $res;
    }
     function deleteContact($post){
           $sql="DELETE from contacts where id=?";
          $query=$this->db->prepare($sql);
          $res=$query->execute(array($post['id']));
          return $res;
         
     }

}
