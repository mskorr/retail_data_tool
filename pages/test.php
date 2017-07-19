<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

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
//    $obj_transactions = new functions();
//    $obj_transactions->get_total_values_graph(1);
//    $row_transactions = $obj_transactions->fetch(); 
//     while ($row_transactions)
//    {
//        $data[] = "[$row_transactions[x_axis], $row_transactions[y_axis]]";
//        $row_transactions = $obj_transactions->fetch();
//    } 
//    print_r($data);
$obj_transactions = new functions();
    $obj_transactions->get_total_values_graph(1);
    $row_transactions = $obj_transactions->fetch(); 
    $transactions_array = array();
     while ($row_transactions)
    {
         
        $data[] = $row_transactions['x_axis']; 
        $data_y_axis[] = $row_transactions['y_axis'];
        $row_transactions = $obj_transactions->fetch();
    } 
//    print json_encode($data); 
?> 

<div class="app app-default">
    <div class="app-container">
         <div class="row"> 
                    <div class="col-xs-12">   
                        <div class="card"> 
                            <div class="card-header">
                                <H3>Some heading</H3>
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
                                </div>
                            </div>
                    </div>
             </div>
    </div> 
</div>
<script language="JavaScript">
$(document).ready(function() {
   var title = {
      text: 'Total Number of transactions per month'   
   };
   var subtitle = {
      text: ''
   };
   var xAxis = {
      categories: <?php print json_encode($data)?>   
   };
   var yAxis = {
      title: {
         text: 'No. transactions'
      },
      plotLines: [{
         value: 0,
         width: 1,
         color: '#808080'
      }]
   };   

   var tooltip = {
      valueSuffix: ''   
   }

   var legend = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };

   var series =  [
      {
         name: 'Number of transactions',
         data: <?php print json_encode($data_y_axis)?> 
      } 
   ];

   var json = {};

   json.title = title;
   json.subtitle = subtitle;
   json.xAxis = xAxis;
   json.yAxis = yAxis;
   json.tooltip = tooltip;
   json.legend = legend;
   json.series = series; 

   $('#graph_transactions').highcharts(json); 
});
</script>
		
	</body>
</html>
