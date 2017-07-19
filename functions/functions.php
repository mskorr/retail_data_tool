<?php
    
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
     
/**  
 * 
 *
 * @author Miss
 */
include_once 'adb.php'; 
    
//include_once("http://212.71.238.208/Barcode_Verification/functions/adb.php");
     session_start();
class functions extends adb { 
    
    function functions() {
        adb::adb();

    }
         
         
    function log_in($user, $pass) {  
//        $p = sha1($pass); 
        $query = " Select * from t26users u where u.a26username ='$user' and u.a26password = HASHBYTES('MD5','$pass') "; 
//        $query1 = "Select * from t26users u where  a26code = 75";
//        print  $query;
//         print  $query1;  
        if ($this->query($query)) {  
            $row = $this->fetch();  
            if ($row) 
                { 
               
               // session_start();
                $_SESSION['user_id'] = $row['a26code'];
//                if($row['a26user_type'] === 3)
//                {
//                    $_SESSION['country_id'] = $row['a26country_id'];
//                }  
                $_SESSION['country_id'] = $row['a26country_id']; 
                $_SESSION['user_name'] = $row['a26username'];
                $_SESSION['firstname'] = $row['a26firstname'];
                $_SESSION['lastname'] = $row['a26lastname'];
                $_SESSION['user_type'] = $row['a26user_type'];
                return true ;
            } else {
                return false;   
            }  
        }
     return $this->query($query);
    } 

    function delete_user($id)
    {
       $query = "delete l from t26users l where l.a26code = $id"; 
       print($query);
        return $this->query($query);
    }
    function get_shop_countries()
    {
      $query = "select distinct(c.a17country_name), c.a17Code
                    from t00retailers r
                    inner join t17countries c
                    on c.a17Code = r.a00COUNTRY_ID
               ";    
                return $this->query($query);                 
    }

    function save_non_food_item($barcode)   
    {
      if(isset($_SESSION['a03code']))  
      {
         $query = "Update b
                set b.a03group_number = -999,
                b.a03date_modified = getdate(),
                b.a03item_type = 'NON-FOOD ITEM'
                from t03barcodes b where b.a03code = $_SESSION[a03code]
                and b.a03group_number = -1";  
      }

      else
      {    
        $query = "Update b
                set b.a03group_number = -999,
                b.a03date_modified = getdate(),  
                b.a03item_type = 'NON-FOOD ITEM'
                from t03barcodes b where b.barcode2 = '$barcode'
                and b.a03group_number = -1";
      }

          
                // print $query;       
                return $this->query($query);  
    }


    function get_users()
    {
      // session_start();
        if($_SESSION['user_type'] == 1)  
        {
          // normal admin
          $query = "Select * , 
                      case when u.a26status = 1 then 'Active' 
                      else 'Inactive' 
                      end as status 
                    from t26users u 
                    where u.a26country_id = $_SESSION[country_id] ";
        }

        else
        {
          // system admin
           $query = "Select * ,case when u.a26status = 1 then 'Active' else 'Inactive' end as status from t26users u"; 
        }
        print $query;
         return $this->query($query); 

    }


    function save_categorisation($family, $brand, $unit, $weight, $description, $quality,$packaging,$barcode, $status,$comment)
    {
        // session_start();
        // print $_SESSION['a03code'] . "this is the id";
        $fully_categorised = "";
        $update_shop_cat = "";
        $update_t08="";
        $update_t10="";  
        $update_decision = "Update b set b.a03user_decision = 1 from t03barcodes b where b.barcode2 = '$barcode'";
        $delete_t03="";
        if($family!= 0 && $brand!= 0  && $weight != 0 && $description != '' )
        {
          $fully_categorised = " b.a03group_number = -999,";
        }

        if(isset($_SESSION['a03code'])) 
        {
            // update per a03code
          // echo "this is the sesion" . $_SESSION['a03code'];
            $update_t03 = "where b.a03code = $_SESSION[a03code];"; 
            $update_decision = "Update b set b.a03user_decision = 2 from t03barcodes b where b.barcode2 = '$barcode' ";

        }
        else 
        {
            // update per barcode and also t08;
          // echo "this is the sesion not" ;
            $update_shop_cat = " b.a03Retailer_shop = null, b.a03sku_category = 1 ,";
            $update_t03 = "where b.barcode2 = '$barcode';"; 

            // $update_t08 = "update s 
            //                 set s.a08barcode_code = tt.barcode_id
            //                 from t08sale_transactions s, 
            //                 (
            //                 Select max(b.a03Code) barcode_id
            //                  from t03barcodes b 
            //                  where b.BARCODE2 = '$barcode'
            //                 ) tt
            //                 WHERE s.BARCODE2 = '$barcode';";
            $update_t10 = "update bm  
                            set bm.a10Barcode_Id = tt.barcode_id,
                            bm.a10shop_id = null,
                            bm.a10sku_category = 1
                            from t10_barcode_mapping bm,
                            (
                                select max(b.a03Code) barcode_id
                                from t03barcodes b 
                                where b.BARCODE2 = '$barcode' 
                            )tt
                            where bm.a10Barcode = '$barcode'";
             $delete_t03 = ";delete b from t03barcodes b where b.barcode2 = '$barcode'
                            and b.a03code not in
                            (
                              Select max(b.a03code)
                              from t03barcodes b where b.barcode2 = '$barcode'

                              );";              
        }    

        $query =    "update b     
                    set b.a03family_id = nullif('$family', 0),
                    b.a03brand_id = nullif('$brand', 0), " . $update_shop_cat . "
                    b.a03units = nullif('$unit' , 0)," . $fully_categorised . "
                    b.a03status = $status,
                    b.a03unit_of_measure = nullif($weight, 0),
                    b.ITEM_DESCRIPTION_ENGLISH = nullif('$description', ''),
                    b.a03comment = nullif('$comment', ''),
                    b.a03quality_id = nullif($quality, 0),
                    b.a03date_modified = getdate(),
                    b.a03item_type = 'FOOD ITEM',
                    b.a03packaging_units = nullif($packaging, 0)
                    from t03barcodes b ". $update_t03 . $update_t10 . $delete_t03 . $update_decision;  
                    // . $update_t08   
                      
                          // print $query;    
                    return $this->query($query);        


    } 

  
    function get_similar_barcodes()
    {
        // for grouping feature
      // session_start();
      if(isset($_SESSION["group_number"]))
      {
          $query = "select * 
                  from t03barcodes b
                  left join v_categories v
                  on v.FAMILY_ID = b.a03family_id
                  left join v_brand br
                  on br.a11code = b.a03brand_id
                  where b.a03group_number = $_SESSION[group_number]
                  order by b.ITEM_DESCRIPTION_ENGLISH, b.ITEM_DESCRIPTION";
                  // print $query;  
      }

      // Select case when max(b.a03group_number) is null 
      //       then 0 
      //       else max(b.a03group_number)
      //       end
      else
        {
          $query = "select * 
                  from t03barcodes b
                  left join v_categories v
                  on v.FAMILY_ID = b.a03family_id
                  left join v_brand br
                  on br.a11code = b.a03brand_id
                  ,
                    (
                      Select min(b.a03group_number) as a03group_number
                      from t03barcodes b where b.a03group_number > 0 and b.a03group_number is not null
                      and b.a03group_number not in 
                      (
                      Select t.group_number
                      from tmp_group_number t
                      )
                    )tt
                  where b.a03group_number = tt.a03group_number
                  order by b.ITEM_DESCRIPTION_ENGLISH,b.ITEM_DESCRIPTION

                ;
                update t
                set t.group_number = tt.a03group_number
                from tmp_group_number t,
                (
                Select min(b.a03group_number) as a03group_number
                                  from t03barcodes b where b.a03group_number > -1 and b.a03group_number is not null
                                  and b.a03group_number not in 
                                  (
                                    Select t.group_number
                                    from tmp_group_number t
                                  )     
                          )tt
                "; 

        }  
        
  
         return $this->query($query);   
    }
  
    function group_barcodes($a03code_arrray)
    {
      // parameter is array of a03 codes to group.
      // print_r($a03code_arrray);
      $a03_codes = " ";
      $j = 0;
      $a03_codes2 = " ";

        for($i = 0; $i<sizeof($a03code_arrray); $i++)
        {
          $j++;
          $a03_codes .=  $a03code_arrray[$i] ;
          $a03_codes2 .= "(" .$a03code_arrray[$i] .")";  
          if($j < sizeof($a03code_arrray) )
          {
            $a03_codes .= ',';  
            $a03_codes2 .= ',';  
          }
        
        }
     session_start();     

        $query = "update b
          set b.ITEM_DESCRIPTION_ENGLISH = ff.item_description_english,
          b.a03group_number = -1,
          b.a03user_id = $_SESSION[user_id],
          b.a03brand_id = ff.brand_id, 
          b.a03family_id = ff.family_id,
          b.a03units = ff.units,
          b.a03unit_of_measure = ff.units_of_measure
          from t03barcodes b 
          cross apply   
              (Select min(bc.ITEM_DESCRIPTION_ENGLISH) item_description_english, 
              max(bc.a03family_id) family_id , 
              max(bc.a03brand_id) brand_id, 
              max(a03units) units,
              max(a03unit_of_measure) units_of_measure
              from t03barcodes bc 
              where bc.a03Code in ($a03_codes) 
              )ff,
            (
            Select max(bc.a03Code) a03code
            from t03barcodes bc
            where bc.a03Code in ($a03_codes)
            )tt
          where b.a03Code = tt.a03code;

          update s
          set s.a08barcode_code = tt.a03code
          from t08sale_transactions s,
            (
            Select max(bc.a03Code) a03code
            from t03barcodes bc
            where bc.a03Code in ($a03_codes)
            )tt

          where s.a08barcode_code in ($a03_codes);

          update bm
          set bm.a10Barcode_Id = tt.a03code
          from t10_barcode_mapping bm,
          (
            Select max(bc.a03Code) a03code
            from t03barcodes bc
            where bc.a03Code in ($a03_codes)
            )tt
          where bm.a10Barcode_Id in ($a03_codes);
          delete b
          from t03barcodes b      
          cross apply
          (Select Max(a03code) As max_a03
             From (Values $a03_codes2) B(a03code)
          )c
          where b.a03Code in ($a03_codes)
          and b.a03Code <> c.max_a03
          delete bm 
          from t10_barcode_mapping bm 
          cross apply
          (Select Max(a03code) As max_a03
             From (Values $a03_codes2) B(a03code)
          )c
          where bm.a10Barcode_Id in ($a03_codes)  
          and bm.a10Barcode_Id <> c.max_a03
          ";

        if(isset($_SESSION['group_number']))
        {
            $num = $this->check_group_number($_SESSION['group_number']);
            if($num == 0)
            {
                unset($_SESSION['group_number']);
            }  
        } 
        return $this->query($query);     
    }

    function no_group_barcodes()
    {
      session_start();
       $query = "update b
                set b.a03user_id = $_SESSION[user_id],
                b.a03group_number = -1 
                from t03barcodes b 
                where b.a03group_number = $_SESSION[group_number]";
                // print $query;  
        unset($_SESSION['group_number']);  

        return $this->query($query);
    }



    function get_brand_by_id($id) {
        $query = "Select * from t11brands where a11code = $id";
        return $this->query($query);
    } 

    function get_manufacturer_by_id($id) {
        $query = "Select * from t12manufacturer where a12code = $id";
        return $this->query($query);
    }

    
    function add_brand($brand, $man_id) {
        $brand = strtoupper($brand);  
        $query = "insert into t11brands (a11brand ,a11manufacturer_id) OUTPUT INSERTED.a11code values ('$brand',$man_id)";
        return $this->query($query);
    }

     function get_manufacturer() {     
        
        $query = "Select * from t12manufacturer order by manufacturer asc ";
        return $this->query($query);
    }
   

    function add_manufacturer($manufacturer) {
        $manufacturer = strtoupper($manufacturer);  
        $query = "insert into t12manufacturer (manufacturer) OUTPUT INSERTED.a12code values ('$manufacturer')";
        return $this->query($query);
    }

    function check_group_number($group_number)
    {
        $query = "Select count(1) as count_barcodes from t03barcodes b where b.a03group_number = $group_number";
        $this->query($query);
        $row = $this->fetch();

        return $row['count_barcodes'];

    }
    function get_barcodes_list()  
    { 
        // show list of uncategorised barcodes 
            $query = "select top 50 b.BARCODE2, max(b.ITEM_DESCRIPTION) as ITEM_DESCRIPTION, 
            max(b.ITEM_DESCRIPTION_ENGLISH) as ITEM_DESCRIPTION_ENGLISH, 
            max(a03date_modified) as a03date_modified
            from t03barcodes b 
                        left join v_categories v 
                        on v.FAMILY_ID = b.a03family_id  
                        left join v_brand vb
                        on vb.a11code = b.a03brand_id
                        where b.a03user_id = $_SESSION[user_id]
                        and b.a03group_number = -1
                        group by b.BARCODE2
                        order by b.BARCODE2 desc";  
            // print $query;
                         // and(b.a03family_id is null or b.a03brand_id is null
            // or b.a03units is null or b.a03unit_of_measure is null or b.ITEM_DESCRIPTION_ENGLISH is null)
                        // and b.a03date_modified is null 
            return $this->query($query);     
    }

    function show_same_barcode_list($barcode)  
    {

            $query = "select * from t03barcodes b where b.BARCODE2 = '$barcode' and b.a03group_number = -1"; 
             // print $query;       
            return  $this->query($query);     
    }   


    function get_num_barcodes($barcode) 
    { 
        $query = "select count(1) as c from t03barcodes b where b.BARCODE2 = '$barcode'";
        // print $query;
         return  $this->query($query);   
    }

     function get_family() {
        $query = "Select * from v_categories where FAMILY <> 'NON AVAILABLE' order by FAMILY asc"; 
        return $this->query($query);
    }

      function get_brand() {
        $query = "Select * from t11brands order by a11brand asc ";
        return $this->query($query);
    }

     function get_units() { 
        
        $query = "Select * from t25units_of_measure";
        return $this->query($query);
    }
 
    function get_family_hierarchy($id)
    {
        $query = "Select * from v_categories c where c.family_id =$id"; 
//            print($query_clean);
            $this->query($query);    
    }

     function get_quality()
    {
        $query = "Select * from t28quality"; 
        return $this->query($query);
    }
   
   function get_barcode_description($barcode)
   {
      // session_start();
      if(isset($_SESSION['a03code']))
      {
         $query = "Select * 
                  from t03barcodes bv 
                  where bv.a03code = $_SESSION[a03code]";
      }
      else
      {
        $query = "Select * 
                  from t03barcodes bv 
                  where bv.Barcode2 ='$barcode'";
                }  
        
        // print $query;
                  return $this->query($query);
                  
   }

    function get_barcode_info($barcode, $decision)
    {
         // print("hello there");
        if($decision == 1)  
        {
            // get barcode info based on barcode
        $query = "Select top 1 * 
                  from t03barcodes bv 
                  left join v_categories v 
                  on v.FAMILY_ID = bv.a03family_id
                  left join t11brands b   
                  on b.a11code = bv.a03brand_id
                  where bv.Barcode2 ='$barcode'"; 
                   // print("hello there");

                  // and bv.a03date_modified is null

        }

        else if($decision == 3)
        {
           

           // check the table to see if that barcode already has a decision... could be one or two
            // print("hello 1 there");
            $user_descion = $this->get_user_decision($barcode);
            // print("hello there" . $user_descion);
            
            if($user_descion == 1 || $user_descion == '')
            {
                $query = "Select top 1 *
                  from t03barcodes bv 
                  left join v_categories v 
                  on v.FAMILY_ID = bv.a03family_id
                  left join t11brands b   
                  on b.a11code = bv.a03brand_id
                  where bv.Barcode2 ='$barcode' 
                  and bv.a03group_number = -1";   
                  // print "i am here 1";
                  // and bv.a03date_modified is null
            }
            else if($user_descion == 2)
            {
                 // print "i am here two";
                $query = "Select *
                from t03barcodes bv  
                left join v_categories v on 
                v.FAMILY_ID = bv.a03family_id 
                left join t11brands b 
                on b.a11code = bv.a03brand_id 
                where bv.Barcode2 ='$barcode' 
                and bv.a03Code in
                (
                    Select max(b.a03Code)
                    from t03barcodes b
                    where b.BARCODE2 = '$barcode'
                    and b.a03group_number = -1

                )";
            // b.a03date_modified is null
                  // print $query; 
                   $this->query($query);
                   $row = $this->fetch();
                   // set session with a03 code   
                    // print "i am here "; 
                  
                   if(isset($_SESSION['a03code']))
                   {    
                    
                        unset($_SESSION['a03code']);
                   }    
                   // print "i am here ftrt";
                   $_SESSION['a03code'] = $row['a03Code'];  
                         // print "this is the a03CODE " .$_SESSION['a03code'];
                   // print ("this is the session " . $_SESSION['a03code']); 
            }  
           
        }

        else 
        {

          $query = "Select top 1 *
                from t03barcodes bv 
                left join v_categories v on 
                v.FAMILY_ID = bv.a03family_id 
                left join t11brands b 
                on b.a11code = bv.a03brand_id 
                where bv.Barcode2 ='$barcode' and 
                bv.a03group_number = -1
                and bv.a03Code in
                (
                    Select max(b.a03Code)
                    from t03barcodes b
                    where b.BARCODE2 = '$barcode'
                    and b.a03group_number = -1
                )";

                  $this->query($query);
                   $row = $this->fetch();
                   // set session with a03 code    
                    // print "i am here "; 
                   // session_start();
                   if(isset($_SESSION['a03code']))
                   {    
                        unset($_SESSION['a03code']);
                   }    
                   // print "i am here ftrt";
                   $_SESSION['a03code'] = $row['a03Code'];   
             // $query = "Select top 1 * from t23_staging bv left join v_categories v on v.FAMILY_ID = bv.family_id left join t11brands b on b.a11code = bv.brand_id where bv.Barcode2 ='$barcode' and bv.a08retailer_shop = $shop_id"; 
        }  
               
            
       // print $query; 
        return $this->query($query);
    } 

    function get_user_decision($barcode)
    { 
        // print("helloasjkdhksjdhjks there");
        $query = "Select top 1 b.a03user_decision from t03barcodes b where b.Barcode2 = '$barcode'";
        // print $query;
        $this->query($query);
        $row = $this->fetch();

        return $row['a03user_decision'];

    }



















    
//     function get_total_sales_value_per_year($id)
//     {
//         if($id === 1 )
//         {
            
//             $query = "Select v.sale_value
//                   from tmp_total_sale_per_year v";
//         }
//          return $this->query($query);
        
//     }
	
// 	function get_sale_value_per_country()
// 	{
// 		$query=" select v.Country, v.total_sale_value
//                 from tmp_sale_value_country v
//                 order by v.Country desc";
// 		return $this->query($query); 
// 	}
     
//         function get_country_stats() 
//         {
//             $query = " select v.Country,  v.num_records,  v.num_beneficiaries , v.num_barcodes
//             from tmp_country_stats v  order by v.Country desc";
// //            print $query; 
//             return $this->query($query); 
//         }
        
//         function get_country_stats_per_period($country)
//         {
//             $query = "select v.Country, v.period,  v.num_records,  v.num_beneficiaries , v.num_barcodes
//             from tmp_country_stats_per_period v where v.country = '$country' order by v.period asc";
// //            print $query; 
//             return $this->query($query);
//         }
//         function get_total_values_graph($id)
//         {
//             if($id === 1)
//             { 
//                 $query = "select v.year_month as x_axis, v.number_of_transactions as y_axis from  tmp_transactions_per_month v 
//                 where v.number_of_transactions > 800";  
//             }
//             if($id === 2)
//             {
//                 $query = "select v.year_month as x_axis, v.num_beneficiaries as y_axis from tmp_number_ben_per_month v where v.num_beneficiaries > 30";
//             }
            
//             return $this->query($query); 
//         }
        
//         function get_countries()
//         {
//             $query = "Select distinct(v.country) from tmp_country_stats_per_period v order by v.country desc";
//             return $this->query($query); 
//         }
        
        
//    function barcode_mapping_update($barcode)
//    {
//        
//    }]
    
    
        
    
}
    
// $obj = new category();
// 
// if($obj->get_all_categories())
// {
//     echo"cannot find categories";
// }
// 
//  echo"fetching";
//     $row = $obj->fetch();
//     while ($row)
//     {
//         echo $row['name'];
//     }
// else
// {  
//      
// }
// ecdeleteho"fetching";
//  
?>     