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
                   <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                             Users
                            </div>
                            <div class="card-body no-padding">
                                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>  
                                            <!-- <th>ID</th> -->
                                            <th>#</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                             <th>Username</th>
                                            
                                               <th>Status</th>
                                               <th></th>
                                           <!--  <th>Family</th>
                                            <th>Brand</th> -->
                                          
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    <?php
                                    $obj = new functions();
                                    $obj->get_users();

                                    $row = $obj->fetch();

                                    while($row)
                                    {
                                        // print_r($row);
                                        echo "<tr>
                                        <td>$row[a26code]</td>
                                        <td>$row[a26firstname]</td>
                                        <td>$row[a26lastname]</td>
                                        <td>$row[a26username]</td>
                                       
                                        <td>$row[status]</td>
                                        <td><a href='#' data-toggle='modal' data-target='#modalDeleteUser'>Delete</a></td>
  
                                        </tr>";
                                          $row = $obj->fetch();
                                    }
                                    ?>
                                    </tbody> 
                                </table>
                                <br>
                                <br>
                                <br>

                                <div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Delete user</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this user? This action is irreversible</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-sm btn-success">Delete</button>
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
            </div>
                
        </div>
    </div>
            
            
            
    </body>
</html> 