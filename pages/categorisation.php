<!DOCTYPE html>
<html>
<?php
include './header.php';
?>
    <body>
        <div class="app app-default">
            
            
            <div class="app-container">  
                
  <?php
  include './sidebar.php'; 
  ?> 
                 
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                               Barcode Categorisation
                            </div>
                            <div class="card-body no-padding">
                                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>  
                                            <!-- <th>ID</th> -->
                                            <th>Barcode</th>
                                            <th>Description Arabic</th>
                                            <th>Description English</th>
                                           <!--  <th>Family</th>
                                            <th>Brand</th> -->
                                            <th></th>  
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    <!-- 
                                         // <td>$row[FAMILY]</td>
                                            // <td>$row[a11brand]</td>  <td>$row[a03Code]</td> -->
                                        <?php
                                        $obj = new functions();
                                        $obj->get_barcodes_list();
                                        $row = $obj->fetch();

                                        while($row)
                                        {  
                                            // print_r($row); 
                                                // check date modified and color code 
                                            if($row['a03date_modified'] == '')
                                            {
                                                echo"<tr>
                                            
                                            <td>$row[BARCODE2]</td> 
                                            <td>$row[ITEM_DESCRIPTION]</td> 
                                            <td>$row[ITEM_DESCRIPTION_ENGLISH]</td>
                                           
                                            <td><a href='#' onclick='show_same_barcode_list(\"$row[BARCODE2]\")'>Edit</a></td>   
                                        </tr>" ;
                                                 
                                            }
                                            else
                                            {
                                                echo"<tr style='color:rgb(0, 169, 58)'> 
                                            
                                            <td>$row[BARCODE2]</td> 
                                            <td>$row[ITEM_DESCRIPTION]</td> 
                                            <td>$row[ITEM_DESCRIPTION_ENGLISH]</td>
                                           
                                            <td><a style='color:rgb(0, 169, 58)' href='#' onclick='show_same_barcode_list(\"$row[BARCODE2]\")'>Edit</a></td>   
                                        </tr>" ;
                                                  
                                            }
                                        $row = $obj->fetch();    
                                        }  
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <br>
                            </div> 
                        </div>
                     </div> 
                    <div  class="col-lg-5" id="same_barcode_list">  
                        <!-- Div containing table of same barcodes fed by same barcode list.php -->
                        <?php
                        include_once './same_barcode_list.php';   
                        ?>   
                    </div> 
                     
    
                   
               
  <?php
include './footer.php';
?>
            </div>
                
        </div>
    </div>
            
            
            
    </body>
</html> 