<?php

require_once 'models/contactsModel.class.php';

class contactsController

{
     public $contactsModel = null;
    function __construct()
    {
        $this->contactsModel=new contactsModel();

    }

    function getContacts($post)
    {
        $res=$this->contactsModel->getContacts($post);
        return $res;
    }
     function addUpdateContact($post)
    {
        $res=$this->contactsModel->addUpdateContact($post);
        return $res;
    }
     function deleteContact($post)
    {
        $res=$this->contactsModel->deleteContact($post);
        return $res;
    }

}