<!DOCTYPE HTML>
<?php
session_start();
if(!isset($_SESSION["country"]))
{
   $_SESSION["country"] = "Lebanon"; 
} 
//$hello =  $_SESSION["country"]; 

//  print $_SESSION["country"]; 
?> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>STATISTICS</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
/*${demo.css}*/
		</style>
	</head>
        
<?php
 include_once './sidebar.php'; 
 include_once './header.php';
 
 
   
     ?>
       <body>  
             <!--<body onload="load_graphs()">-->  
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<?php
//transactions
$obj_transactions = new functions();
    $obj_transactions->get_total_values_graph(1);
    $row_transactions = $obj_transactions->fetch(); 
//    $transactions_array = array();
     while ($row_transactions)
    {
         
        $data[] = $row_transactions['x_axis']; 
        $data_y_axis[] = $row_transactions['y_axis'];
        $row_transactions = $obj_transactions->fetch();
    } 
    
    $obj_benef = new functions();
    $obj_benef->get_total_values_graph(2);
    $row_benef = $obj_benef->fetch(); 
//    $benef_array = array();
     while ($row_benef)
    {
         
        $data_benef[] = $row_benef['x_axis']; 
        $data_y_axis_benef[] = $row_benef['y_axis'];
        $row_benef = $obj_benef->fetch();
    }
    
    $obj_stats = new functions();
    $obj_stats->get_country_stats_per_period($_SESSION['country']);
    $row_stats = $obj_stats->fetch();
    while($row_stats)
    {  
        $data_stats[] = $row_stats['period'];
        $data_y_axis_stats_benef[] = $row_stats['num_beneficiaries']; 
        $data_y_axis_stats_transactions[] = $row_stats['num_records']; 
        $data_y_axis_stats_barcodes[] = $row_stats['num_barcodes']; 
         $row_stats = $obj_stats->fetch();
    }
//    print json_encode($data); 
?> 

<div class="app app-default">
    <div class="app-container">
         <div class="row"> 
                    <div class="col-xs-12">   
                        <div class="card"> 
                            <div class="card-header">
                                <H3>Reports</H3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <!--transactions graph-->
                                        <div id="graph_transactions" style="min-width: 310px; height: 400px; margin: 0 auto">      
                                        </div>                                       
                                      </div>
                                    
                                    <div class="col-md-6">
                                        <!--transactions graph-->
                                        <div id="graph_beneficiaries" style="min-width: 310px; height: 400px; margin: 0 auto">      
                                        </div>                                       
                                      </div>
                                    
                                    </div>
                                
                                  <div class="row">
                                    
                                    <div class="col-md-6">
                                        <!--country stats graph-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                        <h5>Country:</h5>
                                        <select onchange="onchange_country()" id="country_stats" class="form-control" >
                                            <?php
                                            $obj= new functions();
                                            $obj->get_countries();
                                            $row = $obj->fetch();
                                            while($row)
                                            {
                                                echo "<option>$row[country]</option>";
                                                $row = $obj->fetch(); 
                                            }
                                            ?>
                                        </select> 
                                      </div>
                                            </div>
                                        </div> 
                                        <br>
                                        <br>
                                        
                                        <div id="graph_country_stats_transactions" style="min-width: 310px; height: 400px; margin: 0 auto">  
                                        </div>                                       
                                      </div>
                                       <br>
                                        <br>
                                        <br>
                                         <br>
                                        <br>
                                        <br>
                                      <div class="col-md-6">
                                        <!--country stats graph-->
                                        
                                       
                                        
                                        <div id="graph_country_stats_beneficiaries" style="min-width: 310px; height: 400px; margin: 0 auto">  
                                        </div>                                       
                                      </div>
                                    
                                    
                                    
                                    </div>
                                
                                </div>
                            </div>
                    </div>
             </div>
    </div> 
</div>
<script language="JavaScript">
$(document).ready(function() {
   
    
   var title_transactions = {
      text: 'Total Number of transactions per month'   
   };
   var subtitle_transactions = {
      text: ''
   };
   var xAxis_transactions = {
      categories: <?php print json_encode($data)?>   
   };
   var yAxis_transactions = {
      title: {
         text: 'No. transactions'
      },
      plotLines: [{ 
         value: 0,
         width: 1,
         color: '#808080'
      }]
   };   

   var tooltip_transactions = {
      valueSuffix: ''   
   }

   var legend_transactions = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   }; 

   var series_transactions =  [ 
      {
         name: 'Number of transactions',
         data: <?php print json_encode($data_y_axis)?> 
      } 
   ];

   var json_transactions = {};

   json_transactions.title = title_transactions; 
   json_transactions.subtitle = subtitle_transactions;
   json_transactions.xAxis = xAxis_transactions;  
   json_transactions.yAxis = yAxis_transactions;
   json_transactions.tooltip = tooltip_transactions;
   json_transactions.legend = legend_transactions;
   json_transactions.series = series_transactions;  

   $('#graph_transactions').highcharts(json_transactions); 
   
   
    
   //   graph beneficiaries
 var title_beneficiaries = {
      text: 'Total Number of beneficiaries per month'   
   };
   var subtitle_beneficiaries = {
      text: ''
   };
   var xAxis_beneficiaries = {
      categories: <?php print json_encode($data_benef)?>    
   };
   var yAxis_beneficiaries = {
      title: {
         text: 'No. beneficiaries' 
      },
      plotLines: [{ 
         value: 0,
         width: 1,
         color: '#808080'
      }]
   };   

   var tooltip_beneficiaries = {
      valueSuffix: ''   
   }

   var legend_beneficiaries = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };

   var series_beneficiaries =  [
      {
         name: 'Number of beneficiaries',
         data: <?php  print json_encode($data_y_axis_benef)?>  
      } 
   ];

   var json_beneficiaries = {};

   json_beneficiaries.title = title_beneficiaries; 
   json_beneficiaries.subtitle = subtitle_beneficiaries;
   json_beneficiaries.xAxis = xAxis_beneficiaries;  
   json_beneficiaries.yAxis = yAxis_beneficiaries;
   json_beneficiaries.tooltip = tooltip_beneficiaries; 
   json_beneficiaries.legend = legend_beneficiaries;
   json_beneficiaries.series = series_beneficiaries;  

   $('#graph_beneficiaries').highcharts(json_beneficiaries);  
   
   
   
// graph stats  

var title_stats = {
      text: 'Total Number of transactions per month'   
   };
   var subtitle_stats = {
      text: ''
   };
   var xAxis_stats = {
      categories: <?php print json_encode($data_stats)?>    
   };
   var yAxis_stats = {
      title: {
         text: 'No. transactions'  
      },
      plotLines: [{ 
         value: 0,
         width: 1,
         color: '#808080'
      }]
   };   

   var tooltip_stats = {
      valueSuffix: ''   
   } 

   var legend_stats = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };

   var series_stats =  [
    {
         name: 'Number of transactions',
         data: <?php  print json_encode($data_y_axis_stats_transactions)?>    
      }
            
   ]; 

   var json_stats = {};

   json_stats.title = title_stats; 
   json_stats.subtitle = subtitle_stats;
   json_stats.xAxis = xAxis_stats;  
   json_stats.yAxis = yAxis_stats;
   json_stats.tooltip = tooltip_stats; 
   json_stats.legend = legend_stats;
   json_stats.series = series_stats;  

   $('#graph_country_stats_transactions').highcharts(json_stats);  
 
 
 
//graph beneficiareis
var title_stats_ben = {
      text: 'Total Number of beneficiaries per month'   
   };
   var subtitle_stats_ben = {
      text: ''
   };
   var xAxis_stats_ben = {
      categories: <?php print json_encode($data_stats)?>    
   };
   var yAxis_stats_ben = {
      title: {
         text: 'No. beneficiaries'  
      },
      plotLines: [{ 
         value: 0,
         width: 1,
         color: '#808080'
      }]
   };   

   var tooltip_stats_ben = {
      valueSuffix: ''   
   } 

   var legend_stats_ben = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };

   var series_stats_ben =  [
    {
         name: 'Number of beneficiaries',
         data: <?php  print json_encode($data_y_axis_stats_benef)?>    
    }
            
   ]; 

   var json_stats_ben = {};

   json_stats_ben.title = title_stats_ben; 
   json_stats_ben.subtitle = subtitle_stats_ben;
   json_stats_ben.xAxis = xAxis_stats_ben;  
   json_stats_ben.yAxis = yAxis_stats_ben;
   json_stats_ben.tooltip = tooltip_stats_ben; 
   json_stats_ben.legend = legend_stats_ben;
   json_stats_ben.series = series_stats_ben;  

   $('#graph_country_stats_beneficiaries').highcharts(json_stats_ben);  
    $("#country_stats").val("<?php print $_SESSION['country']?>");

//var country = <
//    alert();  
});

 

  
//$( "#country_stats" ).change(function () {
//    var str = "";
//    $( "#country_stats option:selected" ).each(function() {
//      str += $( this ).val()+ " "; 
//    }); 
//   alert(str);  
//   
//  }).change(); 
//  
//  
//  
//  
//function on_country_change()
//{
//    country_stats
//} 
</script>
		
	</body>
</html>
