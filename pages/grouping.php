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
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                Similar Barcodes
                            </div>
                            <div class="card-body no-padding">
                                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Barcode</th>
                                            <th>Description Arabic</th>
                                            <th>Description English</th>
                                            <th>Family</th>
                                            <th>Brand</th>
                                            <th></th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $obj = new functions();
                                        $obj->get_similar_barcodes();
                                        $row = $obj->fetch();
                                        $count = 1;
                                        // session_start();
                                        // print "this is the codes" . $_SESSION['group_number'];
                                        $_SESSION['group_number'] = $row['a03group_number'];
                                        // print "thi si the code" . $row['a03group_number'];
                                        while($row)
                                        {  
                                                echo"<tr>
                                            <td>$row[a03Code]</td>
                                            <td>$row[BARCODE2]</td> 
                                            <td>$row[ITEM_DESCRIPTION]</td>
                                            <td>$row[ITEM_DESCRIPTION_ENGLISH]</td>
                                            <td>$row[FAMILY]</td>
                                            <td>$row[a11brand]</td>
                                            <td>  
                                                <div class='checkbox'>
                                                <input type='checkbox' name='checkbox' id='$row[a03Code]'> 
                                                <label for='$row[a03Code]'></label>
                                                </div>
                                            </td> 
                                        </tr>";
                                                $count++;
                                        $row = $obj->fetch();  
                                        }  
                                        ?>   
                                        
                                        
                                    </tbody> 
                                </table>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-offset-8">
                                         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalGroupConfirm">Group</button>
                                       <!--  <button  type="submit" class="btn btn-primary">Group</button> -->
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModalNoGroupConfirm">No Group</button>
                                        </div>  
                                    
                                    </div> 
                                <br>
                                
        
     
                            </div> 
                            
                        </div>

                    </div>

                    
   
    <div class="modal fade" id="myModalGroupConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">  
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button onclick="group_barcodes()" type="button" class="btn btn-sm btn-success">Group</button>  
          </div>
        </div>   
      </div> 
    </div>

    <div class="modal fade" id="myModalNoGroupConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">  
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button onclick="no_group_barcodes()" type="button" class="btn btn-sm btn-success">No Group</button>  
          </div>
        </div>   
      </div> 
    </div>

                        
                    <!--<div class="col-lg-1"> </div>-->
                    <div class="col-lg-2">
                        <div class="card card-tab card-mini">
                            
                            <div class="card-body tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab1">
                                    <div class="row">
                                        
                                        
                                    </div>
                                </div>
                                    
                                    
                            </div>
                        </div>
                    </div>
               
  
            </div>
                
        </div>
  <?php
include './footer.php';
?>          
            
            
    </body>
</html> 