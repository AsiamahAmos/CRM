<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Contacts/ContactsListViewSmarty.php');
//include('../crm/modules/Contacts/Contact.js');

class ContactsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay() 
     */
    public function preDisplay(){
      global $db; //get db connection
        require_once('modules/AOS_PDF_Templates/formLetter.php');
        formLetter::LVPopupHtml('Contacts');
      //echo'ghsdhgfweuhfj';
        parent::preDisplay();
    
        $this->lv = new ContactsListViewSmarty();

//echo "gsgsgsg";
 echo"<script src='./crm/modules/Contacts/Contact.js'></script>";
      // $stmt = $db->query("SELECT * FROM campaigns INNER JOIN contacts");
       //$res = $db->fetchByAssoc($stmt);
        // foreach ($stmt as $key => $value) {
        //   # code...
         // echo "<pre><td>".$this->seed;echo "</td></pre>";
        // }
      
      //  parent::display();
      //echo'<script>prompt("Hello")</script>';
    }
    
}
