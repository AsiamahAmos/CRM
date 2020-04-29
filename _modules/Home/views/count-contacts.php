<?php
ini_set("display_errors",1);
//include('view.list.php');
//echo "Hi";
echo (file_exists('view.list.php'))? 'Yes' :'No';

require_once('view.list.php');

global $current_user;
echo $current_user->id;
// class CountContacts extends ViewList{
//file_get_contents('index.php');
// function ActivitiesViewList(){
//  		parent::__construct();
 		
//      }
     

// public function C_count(){
// global $current_user;

// print ('$current_user->id');

//    }

// }

// $count = new CountContacts();
// $count->C_count();