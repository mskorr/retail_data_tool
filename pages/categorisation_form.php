<!DOCTYPE html>
<html>
<?php
include './header.php';
$barcode = $_REQUEST['barcode'];
$decision = $_REQUEST['decision'];
?>
    <body onload="load_categorisation_form(<?php print $barcode ?>, <?php print $decision?> )">  
        <div class="app app-default"> 
            
            
            <div class="app-container">  
                
              <?php
              include './sidebar.php'; 
                        $obj = new functions();
                        $obj->get_barcode_description($barcode);
                        $row = $obj->fetch();

              unset($_SESSION['barcode']);  
 
              ?>        
          <div class="row">
        <div class="col-md-12">
      <div class="card">
        <!-- <div class="card-header">    -->
         
         
        <!-- </div> -->
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <h5 id="barcode"></h5> 
                    <h5 id="retailer_name"></h5>
                    <h5 id="shop_name"></h5>
                </div>
            </div>
          <div class="row">
              <div class="col-md-6">
               
            <br>
                    <h5>Item Type</h5>
                    <select name="item_type" id="item_type" class="select2">
                      <option value='1'>Food item </option>
                      <option value='2'>Non Food Item</option> 
                    </select>

                    <h5>Old descripitions</h5>
                    <a  name="old_descriptions" id="old_descriptions" class="list-group-item">      
                        <ol>
                          <?php
                        while($row)
                        {
                            print "<li>$row[ITEM_DESCRIPTION]</li>";
                            $row = $obj->fetch();
                        }  
                       
                       ?>
                        
                        </ol>
                        
                    </a> 
                    
                    <h5>Family</h5>
                    <select onchange="change_select_family(this.value)" name="family" id="family" class="select2">
                     <option value='0'>No family selected</option>
                        <?php
                        $obj = new functions();
                        $obj->get_family();  
                        $row = $obj->fetch(); 

                        while ($row) {
                        echo "<option value='$row[FAMILY_ID]'>$row[FAMILY]</option>"; 
                        $row = $obj->fetch(); 
                        }
                        ?>
                    </select>
                          
                    <h5>Brand</h5>
                    <select name="brand" id="brand" class="select2">
                      <option value='0'>No brand selected</option>
                           <?php
                        $obj = new functions();
                        $obj->get_brand();
                        $row = $obj->fetch();

                        while ($row) {
                        echo " <option value='$row[a11code]'>$row[a11brand]</option>";
                        $row = $obj->fetch();
                        }  
                        ?>                                                                                        
                    </select>
                    <br>
                    <a  id="brand_link" tabindex="23" onclick="hideButton()" href="#collapseBrand" data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample"> + Add new brand</a>

                    <br>
                     <br>
                    <h5>Units</h5>
                <div class="row">  
                    <div class="col-lg-6">
                        <input name="unit" id="unit" type="text" class="form-control" placeholder="Input">
                    </div>
                     <div class="col-lg-6">
                         <select name="weight" id="weight" class="select2">
                         <option value='0'>No weight selected</option>
                        <?php
                        $obj = new functions();
                        $obj->get_units();
                        $row = $obj->fetch(); 

                        while ($row) {
                        echo "<option value='$row[a25code]'>$row[a25unit]</option>";
                        $row = $obj->fetch();  
                        }
                        ?>
                        </select>
                    </div>
                </div>
                
                <h5>Status</h5>   
          <div class="radio">
          <input type="radio" name="radio_status" id="status_ok" value="option1" checked>
          <label for="status_ok">
              OK
          </label>
      </div>
      <div class="radio">
          <input type="radio" name="radio_status" id="status_no" value="option2" >
          <label for="status_no">
              Not Clear
          </label>
      </div>
  </div>
        <br>
         <div class="col-md-6">
            <h5>Is this item on offer?</h5>
            <input style="display:none" type="text" name="offer_value" id="offer_value" class="form-control" placeholder="Input">
     
            <div> 
      <div class="radio radio-inline">
          <input type="radio" name="radio_offer" id="offer_yes" value="option1">
          <label for="offer_yes">
             Yes
          </label>
      </div>
      <div class="radio radio-inline">
          <input type="radio" name="radio_offer" id="offer_no" value="option2" checked>
          <label for="offer_no">
              No  
          </label>
      </div>
    </div>
 <br>
     <h5>English Description</h5>
        <textarea name="english_descriptions" id="english_descriptions" rows="3" class="form-control"></textarea>

<!-- family hierachy div -->
        <a style="display:none"   name="family_hierarchy" id="family_hierarchy" class="list-group-item">
      
      </a>

 <h5>Quality</h5>
<select name="quality" id="quality" class="select2">
        <option value='0'>No quality type selected</option>                           
         <?php
        $obj = new functions();
        $obj->get_quality();
        $row = $obj->fetch();

        while ($row) {
        echo "<option value='$row[a28code]'>$row[a28quality]</option>";
        $row = $obj->fetch();
        }
        ?>   
</select>


 <h5>Packaging</h5> 
<input type="text" name="packaging" id="packaging" class="form-control" placeholder="Input">
        
     <br>
    <h5>Comments</h5>  
        <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>      

        <br>
        <br>
        <div class="row">
                <div class="col-md-12 col-xs-offset-7">
                    <?php
                         $a03code = 0; 
                        if(isset($_SESSION['a03code']))
                        {
                            $a03code = $_SESSION['a03code'];

                        }
                    ?>
                    <!-- \"$row_decision[a00retailer_name]\" -->
                <button type="button" onclick="save_categorisation(<?php print $barcode?>)" id="yes_button" class="btn btn-primary">Save</button>  
                                                       <!--  <button type="button" id="no_button" class="btn btn-default">No<#e7edee/button> -->
                  </div>  
                </div> 
                 <div id="loader" style=" display:none;  width: 23%;
    height: 20%;
    background-color: transparent;
    position: fixed; 
   
    top: 20%;
    left: 45%;" class="card-body __loading">
        <div class="loader-container text-center">
            <div class="icon">
                <div class="sk-wave">
                    <div class="sk-rect sk-rect1"></div>
                    <div class="sk-rect sk-rect2"></div>
                    <div class="sk-rect sk-rect3"></div>
                    <div class="sk-rect sk-rect4"></div>
                    <div class="sk-rect sk-rect5"></div>
                  </div>
            </div>
            <div class="title">Saving</div>  
        </div>
        <!-- <div class="text-indent">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla</div> -->
    </div>  
        </div>
    </div>
    <div class="row">
                <div class="col-lg-4">
                     <div   id="collapseBrand">  
                       
                                    
                    <h5>Manufacturer</h5>  

                     <select onchange="change_manufacturer(this.value)" name="manufacturer" id="manufacturer" class="select2"> 
                     <option value='0'>No manufacturer  selected</option>
                             <?php
                            $obj = new functions();
                            $obj->get_manufacturer();
                            $row = $obj->fetch(); 
                             
                            while ($row) {  
                            echo "<option value='$row[a12Code]'>$row[manufacturer]</option>";
                            $row = $obj->fetch();
                            }
                            ?>  
                
                </select>  
                <a id="manufacturer_link" tabindex="23" href="#collapseManufacturer" data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample"> + Add new manufacturer</a>
                <br>
                <br>
                  <h5>Brand</h5>  
                  <input name="brand_other" id="brand_other" type="text" class="form-control" disabled>    
                  <button type="button" onclick="add_brand()" id="add_brand_button" class="btn btn-primary" >Add</button>  
    </div> 

   

                </div>
                 <div class="col-lg-4 col-lg-offset-2">
        <div class="collapse" id="collapseManufacturer">  
                       
                                       
                    
                
                  <h5>Add new Manufacturer</h5>  
                  <input name="manufacturer_other" id="manufacturer_other" type="text" class="form-control" >    
                  <button type="button" onclick="add_manufacturer()" id="add_manufacturer_button" class="btn btn-primary">Add</button>  
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
            
            
            
    </body>
</html> 