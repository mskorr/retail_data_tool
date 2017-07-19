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

  <div class="col-lg-12"> 
      <a class="card card-banner card-blue-light">
  <div class="card-body">
    <!--<i class="icon fa fa-thumbs-o-up fa-4x"></i>-->
    <div class="content">
      
      <!--<div class="title">Total Sales Value</div>-->
      <div style="float:left" class="value">Welcome <?php print $_SESSION['firstname'] . "!" ?></div>
    </div>
  </div>
</a>

  </div>

</div>

<div class="row">
<div class="col-lg-12"> 
  <!-- <div class='tableauPlaceholder'> -->
<object class='tableauViz' width='1030px' height='570' style='display:none;'>
  <param name='host_url' value='https%3A%2F%2Fanalytics.wfp.org%2F' /> 
  <param name='site_root' value='' /><param name='name' value='kk_0&#47;Shopsoverview' />
  <param name='tabs' value='no' /><param name='toolbar' value='yes' />
  <param name='showShareOptions' value='true' /></object>
<!-- </div> -->
</div>



<button onclick="initializeViz()">  
 if this works in a geius
  </button>
<?php 
// if($_SESSION['user_type'] === 3)
// {

// }
?>
  <!-- <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-tab card-mini">
      <div class="card-header">
        <ul class="nav nav-tabs tab-stats">
          <?php
          // include ''
          // $obj = new functions();   
          // $obj->get_shop_countries();     
          // $row = $obj->fetch();

          // while($row)
          // {
          //   echo "<li role='tab_'$row[a17Code] class=''>
          //   <a href='#tab1' aria-controls='tab1' role='tab' data-toggle='tab'>$row[a17country_name]</a> 
          // </li>";   
          //   // echo"tab_$row[a17Code]";  
          //    $row = $obj->fetch();
          // }
          ?>
        </ul>
      </div>
      <div class="card-body tab-content">

        <div role="tabpanel" class="tab-pane active" id="tab1"> 

        </div>

        <div role="tabpanel" class="tab-pane" id="tab2">
          
        </div>
        <div role="tabpanel" class="tab-pane" id="tab3">

        </div>


      </div>
    </div>
  </div> -->
</div>
 <?php
include './footer.php';
 ?>

</div>

  </div>
  
  

</body>
</html> 