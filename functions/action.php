<?php

include_once './gen.php';
include_once './adb.php';

$cmd = get_datan("cmd");


switch ($cmd) {

    case 1:
        //get promotion based on idhealth promotion
        login();    
        break;

    case 2:
        //get all promotions 
       set_session_barcode(); 
        break;

    case 3: 
        get_brand();
        break;

    case 4:
        //update promotion
        save_categorisation();
        break;

    case 5:
        //g
        create_user();
        break;

    case 6;
        add_manufacturer();
        break;

    case 7;
        // get idcho from health promotion
        get_();
        break;


    case 8;
        add_brand();
        break;

    case 9;
        save_non_food_item();
        break;
    
     case 10;
        save_user_decision();
        break;
    
    case 11;
        get_family_hierarchy();
        break;

     case 12;
        get_barcode_info();
        break;
    
    case 13;
        test();
        break;
    
    case 14;
        set_session_id();
        break;
    
     case 15;
        group_barcodes(); 
        break;
    
     case 16;
        no_group_barcodes(); 
        break;
    
    case 17;
        save_retailer_and_shop(); 
        break;
     case 18;
        update_retailer_per_id(); 
        break;
    
    case 19;
        update_software_company_info_per_id();
        break;
    
      case 20;
        add_software_company();
        break;
    
    case 21;
        get_barcode_info_supervisor();
        break;
    
    case 22;
        approve_barcode();
        break;
    
    default:
        echo "{";
//      json_encode($cmd);
        echo jsonn("result", 0);
        echo ",";
        echo jsons("message", "not a recognised command");
        echo "}";
}



function login() {
    include_once './functions.php';
    $user = get_data('username');
    $pass = get_data('password');
    $obj = new functions();
     
    if ($obj->log_in($user, $pass)) {
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsonn("id",  $_SESSION['user_id']) . ",";
        echo jsons("username",  $_SESSION['user_name']) . ",";
        echo jsons("firstname",  $_SESSION['firstname']) . ",";
        echo jsonn("user_type",  $_SESSION['user_type']) . ",";
        echo jsons("lastname",  $_SESSION['lastname']);
        echo "}";   
    } else {  
        echo "{";
        echo jsonn("result", 0);
        echo "}";
    }
}

function no_group_barcodes()
{
  include_once './functions.php';
  $obj = new functions();
  if($obj->no_group_barcodes())
  {
     echo "{";
        echo jsonn("result", 1);
        echo "}";
  }
  else
  {
     echo "{";
        echo jsonn("result", 2);
        echo "}";
  }
}

function group_barcodes()
{
  $a03code_array = array();
  include_once './functions.php';
  $j=0;
  for( $i = 0; $i<get_datan("count"); $i++)
  {
    $j++;
    $a03code_array [] = get_datan("code".$j);
  }
  $obj= new functions();
  
  if($obj->group_barcodes($a03code_array))
  {
     echo "{";  
            echo jsonn("result", 1) ;  
//            echo jsonn("code", $row['a31code']);  
            echo "}";
  }
  else
  {
     echo "{";  
            echo jsonn("result", 2) ;  
//            echo jsonn("code", $row['a31code']);  
            echo "}"; 
  }
// print_r($a03code_array);
} 

function set_session_barcode()
{
   session_start();
   if(isset($_SESSION['barcode']))
   {
    unset($_SESSION['barcode']);  
   } 
    
    $_SESSION['barcode'] = get_data("barcode");
    echo "{";  
            echo jsonn("result", 1) ;  
//            echo jsonn("code", $row['a31code']);  
            echo "}";
} 












function get_graph_details_transactions()
{ 
    include_once './functions.php';
    $obj_transactions = new functions();
    $obj_transactions->get_total_values_graph(1);
    
     $row_array = array();
    
      if ($row_transactions = $obj_transactions->fetch()) {
          while($row_transactions)
          {
              $row_array[] = $row_transactions['x_axis'] . "," . $row_transactions['y_axis'];
               $row_transactions = $obj_transactions->fetch();
          }
          print json_encode();
//        echo "[";   
//        while ($row_transactions) {
//            echo "{";  
////            echo jsonn("result", 1) . ",";
//            echo jsons("date", $row_transactions["x_axis"]) . ",";
//            echo jsons("transactions", $row_transactions["y_axis"]);
//    
//            echo "}";  
//            $row_transactions = $obj_transactions->fetch();
//            if ($row_transactions) {
//                echo ',';
//            } 
//        }
//        echo "]"; 
//        print json_encode($row_transactions);  
    }
}
   
function set_session_country()
{
    session_start();
    unset($_SESSION['country']);
    $_SESSION['country'] = get_data("country");
    echo "{";
            echo jsonn("result", 1) ;  
//            echo jsonn("code", $row['a31code']);  
            echo "}";
}
    


















function approve_barcode()
{
//    updte supervised column to yes
//    a03Code
    include_once './functions.php';
    $obj = new functions();
    if($row= $obj->approve_barcode(get_datan("a03code")))
    {
        echo "{";
       echo jsonn("result", 1);
      
       echo "}";  
    }
    else
    {
        echo "{";
       echo jsonn("result", 2);
      
       echo "}";  
    }
    
}

function get_barcode_info_supervisor()
{
    include_once './functions.php';
    $obj = new functions();
    $barcode = get_data("barcode");
    $decision = get_datan("decision");
    
    $obj->get_barcode_info_supervisor($barcode, $decision);
    if($row = $obj->fetch())
    {
        $status = $row["status"]; 
        $offer_val = $row["a03offer_value"];
        $family_id = $row["a03family_id"];
        $unit_id = $row["a03unit_of_measure"];
        $brand_id = $row["a03brand_id"];
        $unit = $row["a03units"];
        $quality_id = $row["a03quality_id"];
        $packaging = $row["a03packaging_units"];
//        $comment = $row["comment"];
    
        if($offer_val == '') 
        {
            $offer_val = 'null';
//            print $offer_val;
        }
        if($status == '')
        {
            $status = 1;
        }
        if($family_id == '')
        {
           $family_id = 0;
        }
        if($unit_id == '')
        {
            $unit_id = 0;
        }
        if($brand_id == '')
        {
            $brand_id = 0;
        }
        if ($quality_id ==  '')
        {
            $quality_id = 0;
        }
        if($unit == '')
        {
            $unit = 0;
        }
        if($packaging == '')
        {
            $packaging = 0;
        }
        
    
      echo "{";
       echo jsonn("result", 1) . ",";
       echo jsonn("family", $family_id) . ","; 
       echo jsonn("status", $status) . ",";
       echo jsons("family_value", $row["FAMILY"]). ",";
       echo jsons("brand_value", $row["a11brand"]). ","; 
       echo jsonn("brand", $brand_id) . ",";
       echo jsonn("unit",$unit) . ",";
       echo jsonn("unit_id", $unit_id) . ",";
       echo jsons("comment", $row["comment"]) . ","; 
       echo jsonn("packaging", $packaging) . ",";
       echo jsonn("quality_id", $quality_id) . ","; 
       echo jsons("offer_value", $offer_val) . ",";   
       echo jsons("item_description", $row["ITEM_DESCRIPTION_ENGLISH"]);  
        
       echo "}"; 
    }
    else
    {
        echo "{";
       echo jsonn("result", 2);
      
       echo "}";  
    }
} 

function add_software_company()
{
     include_once './functions.php';
     $obj = new functions();

$company_name = get_data('company_name');
$contact_name1 = get_data('contact_name1');
$contact_name2 = get_data('contact_name2');
$landline = get_data('land_line');
$email1 = get_data('email1');
$email2 = get_data('email2');
$phone1 = get_data('contact_phone1');
$phone2 = get_data('contact_phone2');
$soft_ware_name = get_data('software_name');
$status = get_data('status');
$user_name = get_data('ftp_name');
$password = get_data('ftp_pass');
$rpt_password = get_data('rpt_pass');
$company_id = get_data('company_id');

$obj->add_software_company($contact_name1, $contact_name2, $company_id, $landline, $company_name, 
        $phone1, $phone2, $email1, $email2, $user_name, $password, $rpt_password, $soft_ware_name, $status);

if($row = $obj->fetch())
{
    session_start();
    unset($_SESSION['cmd']); 
    $_SESSION['cmd'] = $row['a31code'];   
     echo "{";
            echo jsonn("result", 1). ", " ;  
            echo jsonn("code", $row['a31code']);  
            echo "}";
}
}

function update_software_company_info_per_id()
{
    include_once './functions.php';
    $obj = new functions();
   
    $company_id = get_data('company_id');
    $company_name = get_data('company_name');
$contact_name1 = get_data('contact_name1');
$contact_name2 = get_data('contact_name2');
$landline = get_data('land_line');
$email1 = get_data('email1');
$email2 = get_data('email2');
$phone1 = get_data('contact_phone1');
$phone2 = get_data('contact_phone2');
$soft_ware_name = get_data('software_name');
$status = get_data('status');
$user_name = get_data('ftp_name');
$password = get_data('ftp_pass');
$rpt_password = get_data('rpt_pass');
$id = get_data('id'); 
 if($obj->update_software_company_info_per_id($company_name, $company_id, $contact_name1,
         $contact_name2, $landline, $email1, $email2, $phone1, $phone2, 
         $soft_ware_name, $status, $user_name, $password, $rpt_password,
         $id))
 {
      echo "{";
            echo jsonn("result", 1);  
           
            echo "}";
 }
 
 else
 {
      echo "{";
            echo jsonn("result", 2);  
           
            echo "}";
 }
}


function update_retailer_per_id()
{
//    var u = "../functions/action.php?cmd=18&id="+id+"&nationality="+nationality+"&name="+name+"&shop_name="+shop_name+"&contact="+owner_contact+"&retailer_id="+retailer_id;   
    include_once './functions.php';
    $obj = new functions();
    $retailer_id = get_data('retailer_id');
    $shop_name = get_data('shop_name');
    $owner_name = get_data('name');
    $owner_nationality = get_data('nationality');
    $id = get_datan('id');
    $owner_contact = get_data('contact');
    if($obj->update_retailer_per_id($retailer_id, $shop_name, $owner_name, $owner_contact, $owner_nationality, $id))
    {
            echo "{";
            echo jsonn("result", 1);  
           
            echo "}";
    }
}

function save_retailer_and_shop()
{
     include_once './functions.php';
    
//     $obj->get_kazaa_village_governorate(get_datan('id')); 
//     shop details
//     $shop_id = get_datan('shop_id'); 
      $insert_retailer = get_data('insert_id');
    $insert_retailer = get_data('insert_id');
    $shop_status = get_datan('shop_status'); 
    $village = get_data('village');
    $kazaa = get_data('kazaa');
    $governorate = get_data('governorate');
    $latitude = get_data('latitude');
    $longitude = get_data('longitude'); 
    $email = get_data('email');
    $shop_name_shop = get_data('shop_name_shop');
    $merchant_number = get_data('merchant_number');
    $location = get_data('location'); 
    $manager_contact= get_data('manager_contact');
    $landline = get_data('landline');
    $manager_name = get_data('manager_name');
    $chain = get_data('chain');
    $merchant_number_edited = substr($merchant_number,1,12);
    $merchant_code = substr($merchant_number_edited,7,6); 
    
    $shop_owner_name = get_data('owner_name');
    $owner_contact = get_data('owner_contact');
    $shop_name = get_data('shop_name');
    $country = get_datan('country');
    $owner_nationality = get_data('nationality');
    $retailer_id = get_data('retailer');
  
            
    
     $obj = new functions(); 
     if($row = $obj->save_retailer_and_shop($insert_retailer, $shop_name_shop, $shop_status, $governorate, $kazaa, $village, $location, $sub_office, $manager_name, $manager_contact, $email,
             $longitude, $latitude, $landline, $chain, $merchant_number_edited, $merchant_code, $merchant_number,
             $retailer_id, $country, $shop_name, $shop_owner_name, $owner_contact, $owner_nationality))
     {
        
            echo "{";
            echo jsonn("result", 1). ", " ;
            echo jsonn("code", $row); 
            echo "}";
     }
        
     else
     {
          echo "{";
            echo jsonn("result", 2);
           
            echo "}";
     }
          
          

           
     }
//     $obj->save_retailer_and_shop($insert_retailer, $shop_name_shop, $shop_status, $governorate, $kazaa, $village, $location, $manager_name, $manager_contact, 
//             $email, $longitude, $latitude, $landline, $merchant_number_edited, $merchant_code, $merchant_numb
//    retailer_details
 


function get_locations()
{
     include_once './functions.php';
     $obj = new functions();
     $obj->get_kazaa_village_governorate(get_datan('id'));    
     
      if ($row = $obj->fetch()) {
        echo "[";
        echo "{";
        echo jsonn("result", 1);
        echo "},";
        while ($row) {
            echo "{";
            echo jsonn("result", 1) . ",";
            echo jsons("name", $row["name"]). ",";
            echo jsonn("code", $row["code"]);  
          

            echo "}";
            $row = $obj->fetch();
            if ($row) {
                echo ',';
            }
        }
        echo "]";
        return json_encode($row);
    }
}

function save_shop_details() 
{
    include_once './functions.php';
    $sub_office = get_datan('sub_office');
    $shop_retailer_id = get_data('shop_retailer_id');
    $shop_id = get_datan('shop_id');
    $shop_status = get_data('shop_status'); 
    $village = get_data('village');
    $kazaa = get_data('kazaa');
    $governorate = get_data('governorate');
    $latitude = get_data('latitude');
    $longitude = get_data('longitude'); 
    $email = get_data('email');
    $shop_name = get_data('shop_name');
    $merchant_number = get_data('merchant_number');
    $location = get_data('location'); 
//    $manager_tel = get_data('manager_tel');
    $manager_contact= get_data('manager_contact');
    $landline = get_data('landline');
    $manager_name = get_data('manager_name');
     $pos = get_datan('pos');
    
    $merchant_number_edited = substr($merchant_number,1,12);
    $merchant_code = substr($merchant_number_edited,7,6); 
//    echo"this is the merchant code =$shop_status ";
    $obj = new functions(); 
if($obj->update_retailer_shops($village, $kazaa,$shop_status, $governorate, $location, $sub_office, $pos, $landline, $longitude, $latitude, $merchant_number, $merchant_code, $merchant_number_edited, $email, $manager_contact, $shop_name, $shop_retailer_id, $manager_name, $shop_id))
{
     echo "{";
        echo jsonn("result", 1);
        
        echo "}"; 
}

}

function set_session_id()
{
//    echo "this is the id" .  get_datan('id'); 
    session_start();
    unset($_SESSION['cmd']); 
    if(!isset($_SESSION['countrt_id']))
    {
          $_SESSION['cmd'] = get_datan('id'); 
    }
     else
     {
          $_SESSION['cmd'] =$_SESSION['countrt_id'];
     }
    
//    print 'this is the session vri : ' . $_SESSION['cmd'];
     echo "{";
        echo jsonn("result", 1) . ",";
        echo jsonn("country_id", $_SESSION['cmd']); 
        echo "}";
    
}

function test()
{
include_once './functions.php';
$obj = new functions();
$obj->get_users();
$row = $obj->fetch();
while($row)
{
  print_r($row);  
  print '<br>';
  print '<br>';
  $row = $obj->fetch(); 
}
print json_encode($row);
}





function get_family_hierarchy()
{
    include_once './functions.php';
    $obj = new functions();
    $obj->get_family_hierarchy(get_datan('id'));
    if($row = $obj->fetch())
    {
       echo "{";
       echo jsonn("result", 1) . ",";
       echo jsons("type", $row["TYPE"]) . ",";
       echo jsons("category", $row["CATEGORY"]) . ",";
       echo jsons("subcategory", $row["SUB_CATEGORY"]); 
       echo "}";  
    } 
}
function save_user_decision()
{
     include_once './functions.php';
     
     $b = get_data('barcode');
     $dec = get_datan("decision");
     $obj = new functions();
    if($obj->update_user_decision($b,$dec ))  
    {
      echo "{";
        echo jsonn("result", 1);  
        echo "}";
    } 
     
} 


function save_non_food_item()
{
    session_start();
    
     include_once './functions.php';
     // $user_id = $_SESSION['user_id'];
     $b = get_data('barcode');
     // $shop_id = get_datan('shop_id');
     $obj = new functions();
     // $obj_map = new functions();
     if($obj->save_non_food_item($b))  
     {
       
        echo "{";
        echo jsonn("result", 1);  
        echo "}";
        
       
     }
      // $obj_map->barcode_mapping($b, $shop_id);   
     
      
     
}
function add_brand() {
    include_once './functions.php';
    $obj = new functions();
    $obj_brand = new functions();
    $brand = get_data('brand');
    $man_id = get_datan('man_id');
    $obj->add_brand($brand, $man_id);
    if ($row = $obj->fetch()) {
        $obj_brand->get_brand_by_id($row["a11code"]);
        $row_brand = $obj_brand->fetch();
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsonn("insert_id", $row_brand["a11code"]) . ",";
        echo jsons("brand", $row_brand["a11brand"]);
        echo "}";  
    }
}

function add_manufacturer() {
    include_once './functions.php';
    $obj = new functions();
    $obj_man = new functions();

    $b = new functions();
    $man = get_data('manufacturer');
    $obj->add_manufacturer($man);
    if ($row = $obj->fetch()) {
        $obj_man->get_manufacturer_by_id($row['a12code']);
        $row_man = $obj_man->fetch();
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsonn("insert_id", $row_man["a12Code"]) . ",";
        echo jsons("manufacturer", $row_man["manufacturer"]);
        echo "}";
    }


//    $b->get_last_insert();
////    $b = new functions();
////    $this->get_last_id(); 
//    $row=$b->fetch();  
//      print_r($row);    
//    $b->query("Select SCOPE_IDENTITY() as 'identity'");
//    $row = $b->fetch();    
//    $row = $obj->fetch();
//     echo "this is the last id" +$row ;  
//    print_r($row);
}

function create_user() {
    include_once './functions.php';
    $obj = new functions();
     $country_id = get_datan("country_id");
    $user = get_datan("u_type");
    $fname = get_data("fname");
    $lname = get_data("lname");
    $uname = get_data("uname");
    $pass = get_data("pass");
    if ($obj->create_user($uname, $pass, $fname, $lname, $user, $country_id)) { 
        echo "{";
        echo jsonn("result", 1);
        echo "}";  
    }
}

function get_barcode_info()
{
     include_once './functions.php';
    $obj = new functions();
    $barcode = get_data("barcode");
    $decision = get_datan("decision");
       
    $obj->get_barcode_info($barcode, $decision);
    if($row = $obj->fetch())
    {   
        

        // $status = $row["status"]; 
         $status  = $row["a03status"];
        $offer_val = $row["a03offer_value"];
        $family = $row["a03family_id"];
        $weight = $row["a03unit_of_measure"];
        $brand = $row["a03brand_id"];
        $unit = $row["a03units"];
        $quality = $row["a03quality_id"];
        $packaging = $row["a03packaging_units"];
        if($offer_val == '') 
        {
            $offer_val = 'null';
//            print $offer_val;
        }
        if($status == '')  
        {
            $status = 1;
        }
        if($family == '')
        {
           $family = 0;
        }
        if($weight == '')
        {
            $weight = 0;
        }
        if($brand == '')
        {
            $brand = 0;
        }
        if ($quality ==  '')
        {
            $quality = 0;
        }
        if($unit == '')
        {
            $unit = 0;
        }
        if($packaging == '')
        {
            $packaging = 0;
        }
        
        $a03code = 0;
        // session_start();
        if(isset($_SESSION['a03code']))
        {
          // unset($_SESSION['a03code']);
         $a03code = $_SESSION['a03code']; 
        }
        // print "this is tha t code" . $a03code;
    
       echo "{";
       echo jsonn("result", 1) . ",";
       echo jsonn("family", $family) . ","; 
       // echo jsonn("status", $status) . ",";
       // echo jsons("family_value", $row["FAMILY"]). ",";
       // echo jsons("brand_value", $row["a11brand"]). ","; 
       echo jsonn("brand", $brand) . ",";
       echo jsonn("unit",$unit) . ",";
       echo jsonn("weight", $weight) . ",";
       echo jsons("comment", $row["a03comment"]) . ",";  
       echo jsonn("packaging", $packaging) . ",";
       echo jsonn("quality", $quality) . ","; 
       // echo jsons("offer_value", $offer_val) . ",";   
       echo jsons("shop_name", $row["a03shop_name"]) . ",";
       echo jsons("retailer_name", $row["a03retailer_name"]) . ",";
       echo jsons("item_description", $row["ITEM_DESCRIPTION_ENGLISH"]) . ",";
       echo jsonn("a03code", $a03code);       
      echo "}"; 
    }
    else
    { 
        echo "{";
       echo jsonn("result", 2);
      
       echo "}";  
    }
}


function save_categorisation() {
   include_once './functions.php';
   //  session_start();  
   // if(isset($_SESSION['a03code']))
   // {
   //  print  "the session is fixed";
   // }
   // else{
   //      print  "the session is not seyt";
   // }
   
   $obj = new functions();
    
    $packaging = get_datan("packaging");  
    $quality = get_datan("quality");  
    $family = get_datan('family');  
    $brand = get_datan('brand'); 
    $barcode = get_data('barcode');    
    $item_des = get_data('des'); 
    $unit = get_datan('unit'); 
    $weight = get_datan("weight");
    $status = get_datan('status');
    $comment = get_data('comment');
    $offer = get_datan('offer');

    // $a03code = 0;
    // if(isset($_SESSION['a03code']))
    // {
    //   $a03code = $_SESSION['a03code'];  
    // }
    if ($obj->save_categorisation($family, $brand, $unit, $weight, $item_des, $quality, $packaging, $barcode,$status,$comment))
    {        

        echo "{";
        echo jsonn("result", 1);  
        echo "}";    
    } 
////
//////    delete the barcodes
    // $obj_map = new functions();
    // $obj_map->barcode_mapping($barcode,$shop_id);
    // $obj_map->fetch();  


    // $shop_id = get_datan("shop_id"); 
    // $origin_id = get_datan('origin'); 
    
    // $offer_value = get_data('offer_value');
//    echo "this is the family" + $family_id; 
//     $clean = 1;               
// //   echo "you are too";  
// if($item_des == '' ||  $unit == '' || $unit_id == 0 || $family_id == '' || $brand_id == '' || $status == 2) 
//     {
    
//         $clean = 0; 
       
// //        echo "you are too";  
//     }   
    
//     if($item_des != '' && $unit_id != 0 && $family_id != '' && $brand_id != '' && $status != 2) 
//     {
//         if($unit == '' )
//         {
//             $clean = 1;
//         }
         
       
// //        echo "you are too";  
//     }
////    family 
//       
//        $obj->save_details($item_des, $unit_id, $unit, $family_id, $brand_id, $user_id, $status, $comment, $barcode, $clean);
    
        
//    
}

function get_details() {
    include_once './functions.php';

    $bc = get_data('bc');

    $obj = new functions();
    $obj->barcode_detail($bc);
    $row = $obj->fetch();
    while ($row) {
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsonn("shop_id", $row["a08retailer_shop"]) . ",";
        echo jsons("barcode", $row["BARCODE2"]) . ",";
        echo jsons("item_description", $row["ITEM_DESCRIPTION"]);
        echo "}";

        $row = $obj->fetch();
    } print_r($row);
}

function get_family() {
    include_once './functions.php';
    $obj = new functions();
    $obj->get_family();

    if ($row = $obj->fetch()) {
        echo "[";
        echo "{";
        echo jsonn("result", 1);
        echo "},";
        while ($row) {
            echo "{";
            echo jsonn("result", 1) . ",";
            echo jsonn("famiy_id", $row["a16Code"]) . ",";
            echo jsons("family", $row["a16family"]);

            echo "}";
            $row = $obj->fetch();
            if ($row) {
                echo ',';
            }
        }
        echo "]";
        return json_encode($row);
    }
}

function get_brand() {
    include_once './functions.php';
    $obj = new functions();
    $obj->get_brand();

    if ($row = $obj->fetch()) {
        echo "[";
        echo "{";
        echo jsonn("result", 1);
        echo "},";
        while ($row) {
            echo "{";
            echo jsonn("result", 1) . ",";
            echo jsonn("brand_id", $row["a11code"]) . ",";
            echo jsons("brand", $row["a11brand"]);

            echo "}";
            $row = $obj->fetch();
            if ($row) {
                echo ',';
            }
        }
        echo "]";
        return json_encode($row);
    }
}

function pay_some() {
    include_once './debt_class.php';

    $student_id = get_datan('student_id');
    $amount_paid = get_data('amount_paid');

    $debt_obj = new debt_class();

    if (!$debt_obj->pay_some($student_id, $amount_paid)) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "No person exsists with this id");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsons("message", "Successful");
        echo "}";
        return;
    }
}

function owe_more() {
    include_once './debt_class.php';

    $student_id = get_datan('student_id');
    $owe_more = get_data('owe_more');

    $debt_obj = new debt_class();

    if (!$debt_obj->owe_more($student_id, $owe_more)) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "No person exsists with this id");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsons("message", "Successful");
        echo "}";
        return;
    }
}

function add_stud() {
    include_once './debt_class.php';

    $student_id = get_datan('stud_id');
    $name = get_data('name');

    $debt_obj = new debt_class();

    if (!$debt_obj->add_student($student_id, $name)) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "Could not add person");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1) . ",";
        echo jsons("message", "Person added");
        echo "}";
        return;
    }
}

function get_all_subjects() {
    include_once '../hw_tracker_teacher/classes/subject_class.php';

    $schools_obj = new subject_class();
    if (!$schools_obj->get_all_details()) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("subjects", "No class found");
        echo "}";
        return;
    }
    $row = $schools_obj->fetch();
    if (!$row) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("subjects", "No class found1d");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1);
        echo ',"subjects":';
        echo "[";

        while ($row) {
            echo "{";
            echo jsonn("id", $row["subject_id"]) . ",";
            echo jsons("subject_name", $row["subject_name"]);
            echo "}";

            $row = $schools_obj->fetch();
            if ($row) {
                echo ",";
            }
        }
        echo "]}";
    }
}

function get_all_classes() {
    include_once '../hw_tracker_teacher/classes/class_class.php';

    $schools_obj = new class_class();
    if (!$schools_obj->get_all_details()) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("schools", "No class found");
        echo "}";
        return;
    }
    $row = $schools_obj->fetch();
    if (!$row) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("classes", "No class found1d");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1);
        echo ',"classes":';
        echo "[";

        while ($row) {
            echo "{";
            echo jsonn("id", $row["class_id"]) . ",";
            echo jsons("class_number", $row["class_number"]);
            echo "}";

            $row = $schools_obj->fetch();
            if ($row) {
                echo ",";
            }
        }
        echo "]}";
    }
}

function send_message() {
    $date_due = get_data("date");
    $teacher_id = get_datan("teacher_id");
    $url = "https://api.smsgh.com/v3/messages/send?"
            . "From=%2B233244813169"
            . "&To=%2B233502128010"
            . "&Content=Teacher+with+id:+$teacher_id+just+posted+an+assignment+due+$date_due"
            . "&ClientId=odfbifrp"
            . "&ClientSecret=rktegnml"
            . "&RegisteredDelivery=true";
// Fire the request and wait for the response
    $response = file_get_contents($url);
    print($response);
    echo "{";
    echo jsonn("result", 1) . ",";
    echo jsons("message sent", "d1d");
    echo "}";
    return;
}

function get_all_schools() {
//   session_start();
//   $_SESSION['paid']=0;


    include_once '../hw_tracker_teacher/classes/school_class.php';

    $teacher_id = get_datan("teacher_id");

    $schools_obj = new school_class();
    if (!$schools_obj->get_all_sch_teacher_teaches($teacher_id)) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("schools", "No school found");
        echo "}";
        return;
    }
    $row = $schools_obj->fetch();
    if (!$row) {

        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("schools", "No school found1d");
        echo "}";
        return;
    } else {
        echo "{";
        echo jsonn("result", 1);
        echo ',"schools":';
        echo "[";

        while ($row) {
            echo "{";
            echo jsonn("id", $row["school_id"]) . ",";
            echo jsons("school_name", $row["school_name"]);
            echo "}";

            $row = $schools_obj->fetch();
            if ($row) {
                echo ",";
            }
        }
        echo "]}";
    }
}

function transact() {
    session_start();
//   $_SESSION['paid']=0;


    $last_inserted_id = $_SESSION['last_insert_id'];

    $id = get_datan('user_id');
    $new_amount = get_datan('new_amount');
    $amount_before = get_datan('amount_before');
    $fare = get_datan('fare');
    $ticket = get_datan('ticket_num');
    $pick_up_location = get_datan("location");

    if ($id == 0) {
        return;
    }

    include_once './transaction_class.php';
    include_once './user_class.php';
    include_once './details_class.php';

    $p = new user_class();
    $q = new transaction_class();
    $d = new deatils_class();

    $row3 = 0;

//   print($d->get_isert_id($d));


    if ($d->get_details($last_inserted_id)) {
        $row3 = $d->fetch();
    }

    if ($row3 == 0 || $row3['seatsLeft'] == 0) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "No seats left");
        echo "}";
        return;
    }

//   $already_reserved = 0;
    if ($q->search_transactions($id)) {
        $already_reserved = $q->fetch();
    }
//   print_r( $already_reserved);
    if ($already_reserved['c'] != 0) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo '"trans":{';
        echo jsons("message", "Already Reserved") . ",";
        echo jsons("ticket_num", $already_reserved['c']);
        echo "}";
        echo "}";
//      $_SESSION['paid'] = 1;
        return;
    }

    $row = $p->deduction($id, $new_amount);
    $row2 = $q->transaction($id, $fare, $ticket, $new_amount, $pick_up_location);

    $row4 = $d->update_info($row3['info_id'], $row3['seatsLeft'] - 1, $row3['numOfPssngrsReserved'] + 1, $row3['numOfSeats'], $row3['numOfPssngrsBus'], $row3['longitude'], "\"" . $row3['locationAddress'] . "\"", $row3['latitude']);

    if (!$row || !$row2 || !$row4) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "Not saved");
        echo "}";
        return;
    }

    echo "{";
    echo jsonn("result", 1) . ",";
    echo '"user":{';
    echo jsons("tran", "transaction successful");
    echo "}";
    echo "}";

//    $_SESSION['paid'] = 1;
//    print $_SESSION['paid'];
}

//function login() {
//    include_once './classes/teacher_login_class.php';
////   include_once './details_class.php';
////   $details_obj = new deatils_class();
////   if (!$details_obj->get_all_details()) {
////      
////   } else {
////      $details_row = $details_obj->fetch();
////   }
////   session_start();
//    $user = get_data('user');
//    $pass = get_data('pass');
//    $p = new teacher_login_class();
//    $val = $p->loginAsTeach($user, $pass);
////   $row = 0;
//    if ($val) {
//        $row = $p->loadProfile($user);
//        if ($row) {
//            echo "{";
//            echo jsonn("result", 1);
//            echo ',"user":';
//            echo "{"; 
//            echo jsons("id", $row["teacher_id"]) . ",";
//            echo jsons("username", $row["username"]) . ",";
//            echo jsons("firstname", $row["firstname"]) . ",";
//            echo jsons("lastname", $row["lastname"]);
//            echo "}";
//            print "}";
//            return;
//        }
//    } else {
//        echo "{";
//        echo jsonn("result", 0) . ",";
//        echo jsons("message", "error, no record retrieved");
//        echo "}";
//    }
////   if it's a new day - reset all values
////   include_once './details_class.php';
////   $det_obj = new deatils_class();
////   if (!$det_obj->get_all_details()) {
////      echo "{";
////      echo jsonn("result", 0) . ",";
////      echo jsons("message", "error, no record retrieved2");
////      echo "}";
////      return;
////   }
////   $last_inserted_id = 0;
////   $row2 = $det_obj->fetch();
//////   print_r($row2);
////   $row3 = $row2;
////   while ($row2) {
//////      $row3 = $row2;
////
////      $last_inserted_id = $row2['info_id'];
////      $_SESSION['last_insert_id'] = $last_inserted_id;
////
////      $row2 = $det_obj->fetch();
////   }
////   print_r($_SESSION);
////
////   $det_obj2 = new deatils_class();
////
//////   print_r ($row3);
//////   print $row3['date_created'];
////
////   $dt = new DateTime($row3['date_created']);
////
////   $dt1 = $dt->format('d-m-Y');
//////   print "---------------" . ($row3['date_created']);
////   $dt2 = date('d-m-Y');
//////           
//////   print "dt1 " . ($dt1);
//////   print "dt2 " . ($dt2);
//////   print ($dt1 === $dt2);
//////   
//////exit();
////
////   if ($dt1 == $dt2) {
//////      print "here";
////      return;
////   } else {
//////      exit();
////      // create a new info row
////      if (!$det_obj->add_info($row3['numOfSeats'], 0, $row3['numOfSeats'], 0, $row3['longitude'], $row3['locationAddress'], $row3['latitude'])) {
//////       this should be concatenated witht the top
////         echo "{";
////         echo jsonn("result", 0) . ",";
////         echo jsons("message", "error, could not create new tuple");
////         echo "}";
//////         exit();
////      }
////      $_SESSION['last_insert_id'] = $det_obj->get_insert_id($det_obj);
//////      print "created";
////   }
////   echo jsons("last_insert_id", $_SESSION['last_insert_id']);
////   echo "}";
////   print "}";
////   return;
//}

function diver_update_bus_location() {
    $info_id = 1;
    $longitude = get_data('long');
    $latitude = get_data('lat');

    include_once './details_class.php';
    $update = new deatils_class();

    if (!$update->update_location($longitude, $latitude, $info_id)) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "error, Unsuccesful");
        echo "}";
        return;
    }
    echo "{";
    echo jsonn("result", 1) . ",";
    echo jsons("message", "Succesful");
    echo "}";
}

function get_bus_loca() {
    include_once './details_class.php';
    $det = new deatils_class();
    if (!$det->get_all_details()) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "error, Unsuccesful");
        echo "}";
        return;
    }
    $row = $det->fetch();
    echo "{";
    echo jsonn("result", 1) . ",";
    echo jsons("x", $row['longitude']) . ",";
    echo jsons("y", $row['latitude']);
    echo "}";
    return;
}

function increase() {

    session_start();
    $last_inserted_id = $_SESSION['last_insert_id'];
    $seats_left = get_data("seats_left");
    $pass_res = get_data('pass_res');
    $pass_on = get_data('pass_on');

    include_once './details_class.php';
    $d = new deatils_class();
//exit();
    $row4 = $d->update_pass($seats_left, $pass_res, $pass_on, $last_inserted_id);

    if (!$row4) {
        echo "{";
        echo jsonn("result", 0) . ",";
        echo jsons("message", "error, Unsuccesful");
        echo "}";
        return;
    }
    echo "{";
    echo jsonn("result", 1) . ",";
    echo jsons("message", "Successful");
    echo "}";
}

function decrease() {
    session_start();
//   $_SESSION['paid']=0;


    $last_inserted_id = $_SESSION['last_insert_id'];
}
