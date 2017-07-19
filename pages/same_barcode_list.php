
  <?php
  // $_SERVER['PHP_SELF'];
  if(!isset($_SESSION['barcode']))
  {
      $barcode = '';
      // ECHO"SESSION IS NOT SET";
  }
  else
  {
    $barcode = $_SESSION['barcode'];
     // ECHO"SESSION IS  SET " .$barcode; 
  }





  


  ?>  
<div class="card">     
                            <div class="card-header">
                             List  
                            </div>
                            <div class="card-body no-padding">
                                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Description Arabic</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                       
                                        include_once '../functions/functions.php';
                                            $obj_num = new functions();
                                            $obj_num->get_num_barcodes($barcode); 
                                            $row_num = $obj_num->fetch();
                                            $row_dec = $obj->get_user_decision($barcode);

                                         
                                          if($row_num['c'] === 1 || $row_dec != '' )
                                          {
                                            // no decision to be made user isdirected
                                             // to form if there is only one barcode ior barcode hass already been decided
                                              echo "<script type='text/javascript'>
                                                   barcodes(\"$barcode\", 3)  
                                                   </script>";
                                              
                                          } 
                                          else
                                          { 

                                                $obj = new functions();
                                                $obj->show_same_barcode_list($barcode);
                                                $row= $obj->fetch();
                                                 $show_buttons = false;
                                                if($row)
                                                {
                                                  $show_buttons = true;
                                                  // echo"<script type='text/javascript'>display_buttons()</script>";
                                                }    
                                                while($row)  
                                                {
                                            echo"<tr>      
                                            <td>$row[BARCODE2]</td> 
                                            <td>$row[ITEM_DESCRIPTION]</td> 
                                            </tr>" ;  
                                         $row = $obj->fetch();   
                                               }      
                                          } 
                                        ?>  
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <div id="buttons_div"  class="col-md-12 col-xs-offset-1">
                                         <button style="display:none" type="button" onclick="barcodes(<?php print $barcode?>, 1)" id="yes_button" class="btn btn-primary">Yes</button>
                                        <button style="display:none" type="button" id="no_button" onclick="barcodes(<?php print $barcode?>, 2)" class="btn btn-default">No</button>
                                    </div>  
                                    <?php
                                    if($show_buttons)
                                    {
                                      echo"<script type='text/javascript'>display_buttons()</script>";
                                    }
                                    ?>
                                </div> 
                                <br>
                                <br>
                            </div> 
                        </div>

                    </div>

































    <!--  // echo $_REQUEST['barcode']; 
     // $barcode = $_REQUEST['barcode'];
     //                                      $obj_num = new functions();
     //                                      $obj_num->get_num_barcodes($barcode); 
     //                                      $row_num = $obj_num->fetch();

     //                                      // if($row_num['c'] === 1)
     //                                      // {

     //                                      // }
     //                                      // else
     //                                      // {

     //                                            $obj = new functions();
     //                                            $obj->show_same_barcode_list($barcode);
     //                                            $row= $obj->fetch();   
     //                                            while($row)
     //                                            {
     //                                               echo"<tr>    
                                          
     //                                        <td>$row[BARCODE2]</td> 
     //                                        <td>$row[ITEM_DESCRIPTION]</td> 
     //                                        <td>$row[ITEM_DESCRIPTION_ENGLISH]</td>
                                           
     //                                        <td><a href='#' onclick='show_same_barcode_list(\"$row[BARCODE2]\")'>Edit</a></td>   
     //                                    </tr>" ;  

                                                  
                                                 
     //                                    $row = $obj->fetch();   
     //                                           }      
                                          // } 
  

 // include_once 'header.php'; -->

<?php
                                        //   include_once '../functions/functions.php';
                                        //   $barcode = $_REQUEST['barcode'];
                                        //   $obj_num = new functions();
                                        //   $obj_num->get_num_barcodes($barcode); 
                                        //   $row_num = $obj_num->fetch();

                                        //   // if($row_num['c'] === 1)
                                        //   // {

                                        //   // }
                                        //   // else
                                        //   // {

                                        //         $obj = new functions();
                                        //         $obj->show_same_barcode_list($barcode);
                                        //         $row= $obj->fetch();   
                                        //         while($row)
                                        //         {
                                        //            echo"<tr>
                                          
                                        //     <td>$row[BARCODE2]</td> 
                                        //     <td>$row[ITEM_DESCRIPTION]</td> 
                                        //     <td>$row[ITEM_DESCRIPTION_ENGLISH]</td>
                                           
                                        //     <td><a href='#' onclick='show_same_barcode_list(\"$row[BARCODE2]\")'>Edit</a></td>   
                                        // </tr>" ;  

                                                  
                                                 
                                        // $row = $obj->fetch();   
                                        //        }      
                                          // } 
                                          ?>  
 

                     




 