<?php

$action = isset($_POST['action']) && !empty($_POST['action']) ? $_POST['action'] : '';
switch ($action) {
    case 'getContacts':
        require_once 'controllers/contactsController.class.php';
        $jsond = array();
        $contactsController = new contactsController();
        $result = $contactsController->getContacts($_POST);
        if ($result['cnt'] > 0) {
            foreach ($result['rows'] as $row) {
               $jsond[]=array(
                 $row['phone'],  
                     $row['email'], 
                     $row['first_name'], 
                     $row['last_name'], 
                     $row['age'], 
                     $row['gender'], 
                   $row['created_date'],
                   '<button contact_id="'.$row['id'].'" class="edit_action btn btn-info">Edit</button><button contact_id="'.$row['id'].'" class="btn btn-danger delete_action">Delete</button>'
               );
            }
        }

        echo json_encode(array('draw' => $_POST['draw'], 'recordsTotal' => $result['cnt'], 'recordsFiltered' => $result['cnt'], 'data' => $jsond));
        exit;
        break;
    case 'addUpdateContact':
        $error = array();
        require_once 'controllers/contactsController.class.php';
        $post_arr = array();
        foreach ($_POST['contactForm'] as $p) {
            $post_arr[$p['name']] = $p['value'];
        }
        //^\+?(\d[.\- ]*){9,14}(e?xt?\d{1,5})?$
        //validation
        if (empty($post_arr['phone'])) {
            $error['phone'] = 'phone is not valid';
        } else if (!preg_match('/^\+?(\d[.\- ]*){9,14}(e?xt?\d{1,5})?$/', $post_arr['phone'], $output_array)) {
            $error['phone'] = 'phone is not valid';
        }
        if (empty($post_arr['first_name'])) {
            $error['first_name'] = 'first name is required';
        } else if (!preg_match("/^[a-zA-Z0-9]+$/", ($post_arr['first_name']))) {
            // string only contain the a to z , A to Z, 0 to 9
            $error['first_name'] = 'first name is not valid';
        }
        if (empty($post_arr['last_name'])) {
            $error['last_name'] = 'last name is required';
        } else if (!preg_match("/^[a-zA-Z]+$/", ($post_arr['last_name']))) {
            // string only contain the a to z , A to Z, 0 to 9
            $error['first_name'] = 'last name is not valid';
        }
        if (empty($post_arr['age'])) {
            $error['age'] = 'age is required';
        } else if ($post_arr['age'] < 17 || $post_arr['age'] > 120) {
            $error['age'] = 'age is not valid';
        }
        if (empty($post_arr['email'])) {
            $error['email'] = 'email is required';
        } else if (!filter_var($post_arr['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'email is not valid';
        }
        if (!empty($error)) {
            echo json_encode(array('status' => 'error', 'msg' => $error));
        } else {
            $contactsController = new contactsController();
            $res = $contactsController->addUpdateContact($post_arr);
            if($res==true){
                echo json_encode(array('status' => 'success', 'msg' => 'success'));
            }else{
                $error['phone']='phone is exsit';
                echo json_encode(array('status' => 'error', 'msg' => $error));
            }
        }
        exit;
        break;
         case 'deleteContact':
              require_once 'controllers/contactsController.class.php';
             $contactsController = new contactsController();
            $res = $contactsController->deleteContact($_POST);
            if($res==1){
                echo json_encode(array('status' => 'success', 'msg' => 'success'));
            }else{
              echo json_encode(array('status' => 'error', 'msg' => 'error'));  
            }
             
            exit;
        break;  
    default:
        include 'view/main.php';
        break;
}
