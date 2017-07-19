
//  jQuery.noConflict();
function syncAjax(u) {
    var obj = $.ajax({url: u, async: false});
    return $.parseJSON(obj.responseText);
}

// set the active list item  on sidebar based o page load
window.onload = function(){//window.addEventListener('load',function(){...}); (for Netscape) and window.attachEvent('onload',function(){...}); (for IE and Opera) also work
   // alert("this si the name of web page: " +window.location.pathname.substring(28,window.location.pathname.length));
   var pathname = window.location.pathname.substring(28,window.location.pathname.length);
//    var str = "Hello world, welcome to the universe.";
// var n = str.includes("world");
// alert(n);  
if(pathname === 'categorisation.php')   
{
   
   $('#categorisation').addClass("active");

}
else if(pathname === 'grouping.php')
{
   $('#grouping').addClass("active");
}

else if(pathname === 'index.php')
{
   $('#dashboard').addClass("active");
}
  
else if(pathname === 'users.php')
{
   $('#admin').addClass("active");
}

else
{
  // alert("else");
}

}





function refresh_page()
{
    window.location.reload(); 
}   
  
// function set_active_class()
// {
//   alert("thgius is ");
//   $('#categorisation').addClass("active");
// }   


function no_group_barcodes()
{
    var u = "../functions/action.php?cmd=16";
    // prompt("u", u);
     var r = syncAjax(u);
     if(r.result === 1)
     {
        refresh_page();
     }
}  

function group_barcodes()  
{
  var checkboxes = document.getElementsByName("checkbox"); 
  var checkboxesChecked = [];
  // loop over them all
  var u = "../functions/action.php?cmd=15";
  var count = 0;
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        count ++;
        u += "&code" + count + "=" +checkboxes[i].id;
        // checkboxesChecked.push(checkboxes[i].id);          
     }
    
  }
  u += "&count="+ count; 
  // prompt("u", u);
  var r = syncAjax(u);
    if(r.result === 1)
    {  
     alert("items have been grouped" + checkboxesChecked.toString());   
     refresh_page(); 
    }  
}  
  
function change_manufacturer(val)     
{
    // alert(val);
    if(val != 0)
    {
        // enable button and textbox if manufacturter selected
        $('#add_brand_button').prop('disabled', false); 
        $('#brand_other').prop('disabled', false);    
    }
          
    else
    {   
        // disable textbox and button
        $('#add_brand_button').prop('disabled', true); 
        $('#brand_other').prop('disabled', true);

    }
       
}

   

function barcodes(barcode, decision)  

{   
        
    // decision is either one or 3
    // user clicked yes, or was automatically redirected to categorisation form 
    document.location.href = "categorisation_form.php?barcode=" + barcode + "&decision=" + decision;  
}


function change_select_family(id)
{
    var hierarchy = document.getElementById("family_hierarchy");
    if (id !== '0')
    {
        $('#family_hierarchy').val(''); 
        var u = "../functions/action.php?cmd=11&id=" + id;
        //          prompt("u",u);
        var r = syncAjax(u);
        if(r.result === 1)
        {
            //           alert("this idsfsdfsdfs the id" + id)
            $('#family_hierarchy').show(); 
            hierarchy.innerHTML = '<br> TYPE : ' + r.type + '<br> Category : ' + r.category + '<br> Sub-Cat : ' + r.subcategory + '<br><br>';
        }
    } else
    { 
        hierarchy.innerHTML = '';
        $('#family_hierarchy').hide(); 
    } 
}  


function toggle_item_type()
{
  // disable all inputs if 2 else enable

} 


function test()
{
    alert("done");  
}
   
function save_categorisation(barcode)   
{
 var u;
  // show loader till everythintg saved  
 var item_type = $('#item_type').val();

  // check if its food item or non food 
  if(item_type === '2')
  {

    // non food item disable all inptus and save as non food
    // alert(item_type);
    u = "../functions/action.php?cmd=9&barcode=" + barcode;  
  }

  else
  {
    var family = $('#family').val();
    var quality = $('#quality').val();
    var brand = $('#brand').val();
    var weight =  $('#weight').val();
    var english_description = $('#english_descriptions').val();
    var comment = $('#comment').val();
    var unit = $('#unit').val();  
    var packaging = $('#packaging').val();
  // alert(barcode + '2');
   var status;    
   if (document.getElementById('status_ok').checked)
   {
    status = 1;       
   }

   else if(document.getElementById('status_no').checked)
   {
    status = 2;    
   }

   var offer;
    if (document.getElementById('offer_yes').checked)
   {
    offer = 1;    
   }

   else if(document.getElementById('offer_no').checked)
   {
    offer = 2;       
   }   

   // POPULATE ITEMS IN URL TO ajax   
    u = "../functions/action.php?cmd=4&packaging="+ 
   packaging+"&des=" + english_description + "&quality=" + quality +
    "&comment=" + comment + "&brand=" + brand + "&family=" + family + 
    "&weight=" + weight + "&unit=" + unit + "&barcode=" + barcode + 
    "&status=" + status + "&offer=" + offer;
       
  }  
 // prompt("u", u);       
    var r = syncAjax(u);
   
    if(r.result === 1)
    {
        alert("categorisation saved successfully");
        $("#loader").hide();
         // document.location.href = "categorisation.php";
        refresh_page(); 
    } 
            
}  


// funcion to initialise tableau  
function initializeViz() {
  alert("smart");
  var placeholderDiv = document.getElementById("tableauViz");
  var url = "https://analytics.wfp.org/views/kk_0/Shopsoverview?:embed=y";  

  // var url = "http://public.tableau.com/views/WorldIndicators/GDPpercapita";
  var options = {
    width: placeholderDiv.offsetWidth,
    height: placeholderDiv.offsetHeight,
    hideTabs: true,
    hideToolbar: true,
    onFirstInteractive: function () {
      workbook = viz.getWorkbook();
      activeSheet = workbook.getActiveSheet();
    }
  };
  viz = new tableau.Viz(placeholderDiv, url, options);   
}      




function display_buttons()  
{
  document.getElementById('no_button').style.display = '';    
  document.getElementById('yes_button').style.display = '';             
}


function load_categorisation_form(barcode, decision)  
{      
    // alert(barcode + "   "  +  decision); 
    // show existing qualifications from db if exists
        // check by barcode
      $('#categorisation').addClass("active");
     var u = "../functions/action.php?cmd=12&barcode=" + barcode + "&decision=" + decision;
     // prompt("u", u);          
     //      alert("hell o there");  
     var  r = syncAjax(u);   
        if(r.result === 1)     
        {          
            // alert("returned");
             $("#english_descriptions").html(r.item_description);   
             $("#comment").html(r.comment);   
             $("#unit").val(r.unit);      
             $("#packaging").val(r.packaging);
             $('#family').val(r.family).change();
             $('#brand').val(r.brand).change();
             $('#quality').val(r.quality).change();
             $('#weight').val(r.weight).change();
  
             // $('#barcode').html("Barcode: " + r.a03code + " <br>");  
             // $('#retailer_name').html("Retailer Name: " + r.retailer_name + " <br>");
             // $('#shop_name').html( "Shop Name: " + r.shop_name + " <br>");
  
        }
        else if(r.result === 2)
        {
             document.location.href = "categorisation.php";
        }



             // refresh_page();
             // alert(r.a03code);
             // $('#shop_name').html("Shop namesfdfsdfsd: " + r.shop_name + "<br>");
             // $('#retailer_name').html("Retailer name: " + r.retailer_name);
             // $('#barcode').html("Barcode: " + barcode + "<br>");
       
}


function login()
{
    // alert("here");    
    var user = document.getElementById('username').value;
    var pass = document.getElementById('password').value;
    // alert(pass);  
  
    // ajax to action page for login authentication
    var u = "../functions/action.php?cmd=1&username=" + user + "&password=" + pass;
    // prompt("login", u);         
    var r = syncAjax(u); 

    if (r.result === 1)  
    {
        //          alert("here 1"); 
        if(r.user_type === 1 || r.user_type === 3 || r.user_type === 4)
        {
            //             alert("here 2");
            document.location.href = "index.php"; 
        }
        else if (r.user_type === 2)   
        { 
            //             alert("here 3");
            document.location.href = "categorisation.php";
        }
            
    } else if (r.result === 0)
 
    { 
        alert("wrong password");
        document.location.href = "login.php";  
    }
 
}       

function show_same_barcode_list(barcode)
{
    //send the barcode to the table that displays list of same barcode via a php file

     var u = "../functions/action.php?cmd=2&barcode=" + barcode;
     var r = syncAjax(u);  
     refresh_page(); 
}   

function logout()
{
    document.location.href = "login.php";       
}

  
  
//    function onchange_country()  
//    {
// //         alert("hello");
//        var str = "";
//        $( "#country_stats option:selected" ).each(function() {
//       str += $( this ).val()+ " "; 
// //       alert(str);
//     });  
//    var u = "../functions/action.php?cmd=2&country=" + str;
// //   prompt("u", u);    
//   var r = syncAjax(u);
//   if(r.result === 1)
//   {
//         refresh_page();
//   }
  
   
// // prompt("u", u);    
 
//    }

//$( "#country_stats" ).change(function () {
//    var str = "";
//    $( "#country_stats option:selected" ).each(function() {
//      str += $( this ).val()+ " "; 
//    }); 
//   alert(str);  
//   
//  }).change(); 

































// function approve_barcode(a03Code)
// {
// //    update the aprove column for that barcode and shop

// //alert ("a03code to update : " + a03Code );

//  var u = "../functions/action.php?cmd=22&a03code=" + a03Code;
// // prompt("u", u);   
// var r = syncAjax(u);
// if(r)
// {
//     document.location.href = "supervisor.php";
// }   
    
// }


// var x = 0;
// function no(val,shop_id, retailer_name, shop_name, description) 
// {   
// //                alert("desc"); 
//     if(shop_id === 0)
//     { 
//         x = val; 
         
//         $("#yes").hide();
//         $("#no").hide();
//         $(".edit").show();   
//     }
    
//     else
//     {
//         //        alert("this is the shop " + val2);
        
//         var b = document.getElementById("myModalLabel").innerHTML;  
//         showModal(b,shop_id, retailer_name, shop_name); 
// //        myModalShopName
//         //        $("#myModal").modal(); 
//         $("#myModalShop").html(shop_id); 
       
//         $("#old_description").children().remove(); 
//         $("#old_description").append('<li>' + description + '</li>' );       
        
//     } 
// }
// function save_shop_details(id)   
// { 
//     var shop_id = id;   
//          var shop_retailer_id = document.getElementById('shop_id'+id).value;
//     var latitude = document.getElementById('latitude'+id).value;
//     var shop_name = document.getElementById('shop_name'+id).value;
//     var longitude = document.getElementById('longitude'+id).value;
//     var manager_name = document.getElementById('manager_name'+id).value;
//     var email = document.getElementById('email'+id).value;
//     //     var kazaa = document.getElementById('kazaa'+id).value;
//     var landline = document.getElementById('landline'+id).value;
//     var status = document.getElementById('shop_status_select'+id);
//     var status_id = status.options[status.selectedIndex].value;
//     //      var governorate = document.getElementById('governorate_select'+id);
//     var governorate = $('#governorate_select'+id+ ' option:selected').text();  
//     var village = $('#village_select'+id+ ' option:selected').text();  
//     var kazaa = $('#kazaa_select'+id+ ' option:selected').text();  
//     var pos_doc = document.getElementById('pos_select'+id);
//             var pos = pos_doc.options[pos_doc.selectedIndex].value;
//     //     var governorate = document.getElementById('governorate_select'+id).value; 
//     //     alert("this is the governorate" + governorate_text);  
//     //     alert('#governorate_select'+id+ ' option:selected');  
//     //     var governorate = document.getElementById('governorate'+id).value; 
//     var merchant_number = document.getElementById('merchant_number'+id).value;
//     var location = document.getElementById('location'+id).value;
//     //     var manager_tel = document.getElementById('manager_tel'+id).value;
//     var manager_contact = document.getElementById('manager_contact'+id).value;
//       var sub_office_doc = document.getElementById('sub_office_select'+id);
//             var sub_office = sub_office_doc.options[sub_office_doc.selectedIndex].value;   
     
//     var u = "../functions/action.php?cmd=15&shop_id="+shop_id+"&sub_office="+sub_office+"&village="+village+"&latitude="+latitude
//             +"&longitude="+longitude+"&pos="+pos+"&shop_retailer_id="+shop_retailer_id+"&email="+email+"&manager_name="+manager_name+"&location="+location+ 
//             "&kazaa="+kazaa+"&shop_status="+status_id+"&shop_name="+shop_name+"&landline="+landline+"&governorate="+governorate+
//             "&merchant_number="+merchant_number+"&manager_contact="+manager_contact;   
//    alert("this is the pos valiue" + pos)
//     prompt("u", u);   
//     var r = syncAjax(u);   
//     if(r.result === 1)
//     {
//         window.location.reload();
//     }   
// }   

// function add_software_company()
// {
//      var company_name = document.getElementById('company_name').value;
//     var software_name = document.getElementById('software_name').value;
//     var contact_name1 = document.getElementById('contact_name1').value;
//     var contact_name2 = document.getElementById('contact_name2').value;
//     var contact_phone1 = document.getElementById('contact_phone1').value;
//     var contact_phone2 = document.getElementById('contact_phone2').value;
//     var ftp_name = document.getElementById('ftp_name').value;
//     var ftp_pass = document.getElementById('ftp_pass').value;
//     var rpt_pass = document.getElementById('rpt_pass').value;
//     var land_line = document.getElementById('land_line').value;
//     var email1 = document.getElementById('email1').value;
//     var email2 = document.getElementById('email2').value;
//     var status = document.getElementById('status').value; 
//      var company_id = document.getElementById('company_id').value;
   
              
//     var u = "../functions/action.php?cmd=20&company_name="+company_name+"&software_name="+software_name+"&contact_name1="+contact_name1
//     +"&contact_name2="+contact_name2+"&contact_phone1="+contact_phone1+"&contact_phone2="+contact_phone2+"&ftp_name="+ftp_name+"&ftp_pass="+ftp_pass
//     +"&rpt_pass="+rpt_pass+"&company_id="+company_id+"&land_line="+land_line+"&email1="+email1+"&email2="+email2+"&status="+status; 
// //    prompt("u", u);
    
    
//     var r = syncAjax(u);
//     if(r.result === 1)
//     { 
// //        alert ("company added");
//         document.location.href = "manage_pos.php";  
//     } 
// }

// function add_new_retailer(id) 
// { 
//     ////   get information in retailer form then disable fields  so information cannot be changed
//     // check if retailer already exists
    
//     if(id ===0)
//     {
//     $('#add_shop_owner_name').prop("disabled",true);
//     $('#add_shop_name').prop("disabled",true);
//     $('#add_owner_contact').prop("disabled",true);
//     $('#add_owner_nationality').prop("disabled",true);
//     $('#add_chain').prop("disabled",true);
//     //     $('#add_country').selectpicker('destroy'); 
//     //     $('#add_country').selectpicker('refresh'); 
//     $('#add_retailer_id').prop("disabled",true);
     
//     //     retailer details
//     var shop_owner_name = document.getElementById('add_shop_owner_name').value;  
//     var shop_name = document.getElementById('add_shop_name').value;  
//     var owner_contact = document.getElementById('add_owner_contact').value;  
//     var country = document.getElementById('add_country').value;  
//     var owner_nationality = document.getElementById('add_owner_nationality').value;
//     var chain = document.getElementById('add_chain').value; 
//     var retailer_id = document.getElementById('add_retailer_id').value;
    
//      //    shopdetails
//     var shop_status = document.getElementById('add_shop_status').value;
//     var shop_name_shop = document.getElementById('add_shop').value;
//     var manager_name = document.getElementById('add_manager_name').value;
//     var manager_contact = document.getElementById('add_manager_contact').value;
//     var landline = document.getElementById('add_landline').value;
//     var email = document.getElementById('add_email').value;
//     var pos = document.getElementById('add_pos').value;
//     var merchant_number = document.getElementById('add_merchant_number').value;
//     var location = document.getElementById('add_location').value;
//     var governorate = $('#add_governorate option:selected').text(); 
//      var sub_office = $('#add_sub_office option:selected').text();
//     var kazaa = $('#add_kazaa option:selected').text(); 
//     var village = $('#add_village option:selected').text(); 
// //    var governorate = document.getElementById('add_governorate').value;
// //    var kazaa = document.getElementById('add_kazaa').value;
// //    var village = document.getElementById('add_village').value;
// //    var insert_retailer = id;
//     var insert_retailer = document.getElementById('insert_retailer').innerHTML;
//     var longitude = document.getElementById('add_longitude').value;
//     var latitude = document.getElementById('add_latitude').value;
     
   
//     var u =  "../functions/action.php?cmd=17&owner_name="
//             +shop_owner_name+"&shop_name="+shop_name+"&owner_contact="
//             +owner_contact+"&nationality="+owner_nationality+"&chain="
//             +chain+"&retailer="+retailer_id+"&sub_office="+sub_office+ "&insert_id="+insert_retailer+"&longitude="+longitude+"&country="+country+"&latitude="
//             +latitude+"&village="+village+"&landline="+landline+"&manager_contact="+manager_contact+"&location="
//             +location+"&shop_status="+shop_status+"&merchant_number="+merchant_number+"&kazaa="+kazaa+"&email="+email+"&shop_name_shop="
//             +shop_name_shop+"&governorate="+governorate+"&manager_name="+manager_name+"&pos="+pos;
    
// //    prompt("u",u);  
//     var r = syncAjax(u);     
    
//     if(r.result === 1)
//     {
//          alert('retailer and shop added!'); 
         
//          $('#insert_retailer').html(r.code); 
//         document.location.href = "retailer_details.php?cmd="+r.code;  
            
//     }
    
//     }
//     else
//     {
        
// //        get only shop deets
//     var shop_status = document.getElementById('add_shop_status').value;
//     var shop_name_shop = document.getElementById('add_shop').value;
//     var manager_name = document.getElementById('add_manager_name').value;
//     var manager_contact = document.getElementById('add_manager_contact').value;
//     var landline = document.getElementById('add_landline').value;
//     var email = document.getElementById('add_email').value;
//     var pos = document.getElementById('add_pos').value;
//     var merchant_number = document.getElementById('add_merchant_number').value;
//     var location = document.getElementById('add_location').value;
//     var governorate = $('#add_governorate option:selected').text(); 
//     var kazaa = $('#add_kazaa option:selected').text(); 
//     var village = $('#add_village option:selected').text(); 
// //    var governorate = document.getElementById('add_governorate').value;
// //    var kazaa = document.getElementById('add_kazaa').value;
// //    var village = document.getElementById('add_village').value;
// //    var insert_retailer = id;
//     var insert_retailer = id; 
//     var longitude = document.getElementById('add_longitude').value;
//     var latitude = document.getElementById('add_latitude').value;
     
       
//     var u =  "../functions/action.php?cmd=17&owner_name="
//             +shop_owner_name+"&shop_name="+shop_name+"&owner_contact="
//             +owner_contact+"&nationality="+owner_nationality+"&chain="
//             +chain+"&retailer="+retailer_id+"&insert_id="+insert_retailer+"&longitude="+longitude+"&country="+country+"&latitude="
//             +latitude+"&village="+village+"&landline="+landline+"&manager_contact="+manager_contact+"&location="
//             +location+"&shop_status="+shop_status+"&merchant_number="+merchant_number+"&kazaa="+kazaa+"&email="+email+"&shop_name_shop="
//             +shop_name_shop+"&governorate="+governorate+"&manager_name="+manager_name+"&pos="+pos;
    
// //    prompt("u",u);
//     var r = syncAjax(u);     
    
//     if(r.result === 1)
//     {
//          alert('retailer and shop added!'); 
            
// //         $('#insert_retailer').html(r.code);  
//         document.location.href = "retailer_details.php?cmd="+id;  
            
//     }
//     }
   
//   } 

   
//    function save_retailer_changes(id)
//    {
//        var name = document.getElementById('shop_owner_name').value;
//     var nationality = document.getElementById('owner_nationality').value;
//     var shop_name = document.getElementById('shop_name').value;
//     var owner_contact = document.getElementById('owner_contact').value;
//     var retailer_id = document.getElementById('retailer_id').value;
    
//     var u = "../functions/action.php?cmd=18&id="+id+"&nationality="+nationality+"&name="+name+"&shop_name="+shop_name+"&contact="+owner_contact+"&retailer_id="+retailer_id;   
//     var r = syncAjax(u);
//     if(r.result === 1) 
//     {
//         window.location.reload();
//     }
//     else if(r.result === 2) 
//     {
//         alert("there was a problem");
//     }
//    }  
// function update_retailer()
// {
//      $('#shop_owner_name').prop("disabled",false);
//       $('#owner_nationality').prop("disabled",false);
//        $('#shop_name').prop("disabled",false);
//         $('#owner_contact').prop("disabled",false);
//          $('#retailer_id').prop("disabled",false); 

//         $('#save_retailer_changes').show() ;
//         $('#update_retailer').hide() ;
// }  

// function toggle_fields(id, bool) 
// {
//     $('#governorate_select'+id).selectpicker('hide'); 
//     $('#governorate'+id).show();   
     
//      $('#pos_select'+id).selectpicker('hide'); 
//     $('#pos'+id).show();  
    
//     $('#kazaa_select'+id).selectpicker('hide'); 
//     $('#kazaa'+id).show(); 
     
//     $('#village_select'+id).selectpicker('hide'); 
//     $('#village'+id).show();  
    
//     $('#sub_office_select'+id).selectpicker('hide'); 
//     $('#sub_office'+id).show(); 
     
//     $('#shop_status_select'+id).selectpicker('hide'); 
//     $('#shop_status'+id).show(); 
    
//      $('#shop_id'+id).prop("disabled",bool);
//     $('#edit_button').show();
//     $('#save_button').hide(); 
//     $('#latitude'+id).prop("disabled",bool);
//     $('#sub_office'+id).prop("disabled",bool);
//     $('#longitude'+id).prop("disabled",bool);
//     $('#shop_name'+id).prop("disabled",bool);
//     $('#manager_name'+id).prop("disabled",bool);
//     $('#location'+id).prop("disabled",bool);
//     $('#email'+id).prop("disabled",bool); 
//     $('#kazaa'+id).prop("disabled",bool);
//     $('#village'+id).prop("disabled",bool);
//     $('#governorate'+id).prop("disabled",bool);
//     $('#merchant_number'+id).prop("disabled",bool);
//     $('#landline'+id).prop("disabled",bool);
//     $('#manager_contact'+id).prop("disabled",bool);
// } 


// function edit_shop_details(id)  
// { 
// //     var $this = $(this);
// //  $this.button('loading');
// //    setTimeout(function() {
// //        
// //   }, 8000);  
//     //    populate governorate, kazaa, and village
//     //governorate
//     var ug = "../functions/action.php?cmd=16&id=3";   
//     var r = syncAjax(ug);
//     for (var i = 0; i < r.length; i++) {  
//         $('#governorate_select'+id).append('<option value=1>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }   
//     var governorate = document.getElementById('governorate'+id).value;
//     //    alert("#governorate_select"+id +" option"); 
//     $("#governorate_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === governorate) { 
// //            alert('governorate found');
//             $(this).attr('selected', 'selected');            
//         }                          
//     }); 
    
//     var uk = "../functions/action.php?cmd=16&id=1";   
//     var r = syncAjax(uk);
//     for (var i = 0; i < r.length; i++) {  
//         $('#kazaa_select'+id).append('<option value=1>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }   
//     var kazaa = document.getElementById('kazaa'+id).value;
//     //    alert("#governorate_select"+id +" option"); 
//     $("#kazaa_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === kazaa) { 
// //            alert('kazaa found');
//             $(this).attr('selected', 'selected');            
//         }                         
//     });  
    
//        var us = "../functions/action.php?cmd=16&id=5";   
//     var r = syncAjax(us);
//     for (var i = 0; i < r.length; i++) {  
//         $('#pos_select'+id).append('<option value=' +r[i].code + '>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }     
//     var pos = document.getElementById('pos'+id).value;
//     //    alert("#governorate_select"+id +" option"); 
//     $("#pos_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === pos) { 
// //            alert('pos found');
//             $(this).attr('selected', 'selected');            
//         }                         
//     });  
    
//     var uo = "../functions/action.php?cmd=16&id=6";   
//     var r = syncAjax(uo);
//     for (var i = 0; i < r.length; i++) {  
//         $('#sub_office_select'+id).append('<option value=' +r[i].code + '>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }     
//     var office = document.getElementById('sub_office'+id).value;
//     //    alert("#governorate_select"+id +" option"); 
//     $("#sub_office_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === office) { 
// //            alert('pos found');
//             $(this).attr('selected', 'selected');            
//         }                         
//     });  
        
    
//     var uv = "../functions/action.php?cmd=16&id=2";   
//     var r = syncAjax(uv);
//     for (var i = 0; i < r.length; i++) {  
//         $('#village_select'+id).append('<option value=1>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }   
//     var village = document.getElementById('village'+id).value;
//     //    alert("#governorate_select"+id +" option"); 
//     $("#village_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === village) { 
// //            alert('village found'); 
//             $(this).attr('selected', 'selected');            
//         }                         
//     });  
        
        
//     var us = "../functions/action.php?cmd=16&id=4";   
//     var r = syncAjax(us);
//     for (var i = 0; i < r.length; i++) {  
//         $('#shop_status_select'+id).append('<option value='+r[i].code+'>'+r[i].name+'</option>').selectpicker('refresh'); 
//     }   
//     var status = document.getElementById('shop_status'+id).value; 
//     //    alert("#governorate_select"+id +" option"); 
//     $("#shop_status_select"+id +" option").each(function() {
//         //         alert('governorate found'); 
//         if($(this).text() === status) {   
// //            alert('status found'); 
//             $(this).attr('selected', 'selected');             
//         }                         
//     });    
      
        
 
//     toggle_fields(id, false);    
//     $('#edit_button').hide();
//     $('#save_button').show();  
//     //    govenorate
//     $('#governorate_select'+id).selectpicker('refresh');  
//     $('#governorate_select'+id).selectpicker('show'); 
//     $('#governorate'+id).hide();   
    
//     //    kazaa
//     $('#kazaa_select'+id).selectpicker('refresh');  
//     $('#kazaa_select'+id).selectpicker('show'); 
//     $('#kazaa'+id).hide();
    
//     //    village
//     $('#village_select'+id).selectpicker('refresh');  
//     $('#village_select'+id).selectpicker('show'); 
//     $('#village'+id).hide(); 
    
    
//     //    shop_status
//     $('#shop_status_select'+id).selectpicker('refresh');  
//     $('#shop_status_select'+id).selectpicker('show'); 
//     $('#shop_status'+id).hide();   
    
// //    sofware company
//  $('#pos_select'+id).selectpicker('refresh');  
//     $('#pos_select'+id).selectpicker('show'); 
//     $('#pos'+id).hide();   
    
// //    sub offcie
//      $('#sub_office_select'+id).selectpicker('refresh');  
//     $('#sub_office_select'+id).selectpicker('show'); 
//     $('#sub_office'+id).hide();   
    
    
     
// }

// function save_pos_details(id) 
// {
//     var company_id = document.getElementById('company_id'+id).value;
//     var company_name = document.getElementById('company_name'+id).value;
//     var software_name = document.getElementById('software_name'+id).value;
//     var contact_name1 = document.getElementById('contact_name1'+id).value;
//     var contact_name2 = document.getElementById('contact_name2'+id).value;
//     var contact_phone1 = document.getElementById('contact_phone1'+id).value;
//     var contact_phone2 = document.getElementById('contact_phone2'+id).value;
//     var ftp_name = document.getElementById('ftp_name'+id).value;
//     var ftp_pass = document.getElementById('ftp_pass'+id).value;
//     var rpt_pass = document.getElementById('rpt_pass'+id).value;
//     var land_line = document.getElementById('land_line'+id).value;
//     var email1 = document.getElementById('email1'+id).value;
//     var email2 = document.getElementById('email2'+id).value;
//     var status = document.getElementById('status'+id).value; 
    
  
              
//     var u = "../functions/action.php?cmd=19&id="+id+"&company_name="+company_name+"&software_name="+software_name+"&contact_name1="+contact_name1
//     +"&contact_name2="+contact_name2+"&contact_phone1="+contact_phone1+"&contact_phone2="+contact_phone2+"&ftp_name="+ftp_name+"&ftp_pass="+ftp_pass
//     +"&rpt_pass="+rpt_pass+"&land_line="+land_line+"&company_id="+company_id+"&email1="+email1+"&email2="+email2+"&status="+status; 
// //    prompt("u", u); 
//     var r = syncAjax(u);
    
//     if(r.result === 1)
//     {
//     $('#company_id'+id).prop('disabled', true);
//     $('#company_name'+id).prop('disabled', true);
//     $('#software_name'+id).prop('disabled', true);
//     $('#contact_name1'+id).prop('disabled', true);
//     $('#contact_name2'+id).prop('disabled', true);
//     $('#contact_phone1'+id).prop('disabled', true);
//     $('#contact_phone2'+id).prop('disabled', true);
//     $('#ftp_name'+id).prop('disabled', true);
//     $('#ftp_pass'+id).prop('disabled', true);
//     $('#rpt_pass'+id).prop('disabled', true);
//     $('#land_line'+id).prop('disabled', true);
//     $('#email1'+id).prop('disabled', true);
//     $('#email2'+id).prop('disabled', true);
//     $('#status'+id).prop('disabled', true);  
//     $('#save_pos_details'+id).hide();  
//     $('#toggle_pos_fields'+id).show();  
//      window.location.reload(); 
     
//     } 
     
// }

// function toggle_pos_fields(id)
// {
//     $('#company_id'+id).prop('disabled', false);
//     $('#company_name'+id).prop('disabled', false);
//     $('#software_name'+id).prop('disabled', false);
//     $('#contact_name1'+id).prop('disabled', false);
//     $('#contact_name2'+id).prop('disabled', false);
//     $('#contact_phone1'+id).prop('disabled', false);
//     $('#contact_phone2'+id).prop('disabled', false);
//     $('#ftp_name'+id).prop('disabled', false);
//     $('#ftp_pass'+id).prop('disabled', false);
//     $('#rpt_pass'+id).prop('disabled', false);
//     $('#land_line'+id).prop('disabled', false);
//     $('#email1'+id).prop('disabled', false);
//     $('#email2'+id).prop('disabled', false);
// //    var status = document
//      $('#status'+id).removeAttr('disabled');
// //    $('#status'+id).attr(':enabled')
// //    $('#status'+id).prop('disabled', true);
//     $('#save_pos_details'+id).show();  
//      $('#toggle_pos_fields'+id).hide();    
// //      $(this).hide();  
    
    
   
// }

// function set_session_id(id)
// {
//     $(this).addClass('active');
//     //    alert('hello'); 
//     var u = "../functions/action.php?cmd=14&id="+id; 
//     //    prompt("login", u);
//     var r = syncAjax(u);
//     if(r.result === 1)
//     {
//         //        alert('variable set to: ' + r.country_id); 
// //        document.location.href = "manage_shops.php"; 
//         window.location.reload();
//         //         alert('variable set tod: ' + r.country_id);  
//     }
// }

// function change_select_item_type(val)
// {
//     //    alert(val);
//     if (val === '1')
//     {
//         //        alert(val + "thi is the vle");
// //        var comment = docum
//         $('#comment').prop('disabled', true);
//         $('#unit_value').prop('disabled', true);
//         $('#unit').prop('disabled', true);
//         $('.selectpicker').selectpicker('destroy');
//         //        $('#family').prop('disabled', true);
//         //        $('#brand').prop('disabled', true);
//         $('#brand_link').prop('disabled', true);  
//         $('#description').prop('disabled', true);
//         $('#packaging').prop('disabled', true);
//         $('#offer_value').prop('disabled', true);
//         $('#quality').prop('disabled', true);
//     } else 
//     {
//         $('.selectpicker').selectpicker('render');
//         $('#comment').prop('disabled', false);
//         $('#unit_value').prop('disabled', false);
//         $('#unit').prop('disabled', false);
//         $('#family').prop('disabled', false);
//         $('#quality').prop('disabled', false);
//         $('#brand').prop('disabled', false);
//         $('#brand_link').prop('disabled', false);  
//         $('#description').prop('disabled', false);
//         $('#packaging').prop('disabled', false); 
//         $('#offer_value').prop('disabled', false);
//     }
 
// }

// function login()
// {
//     //            alert("here");  
//     var user = document.getElementById('user').value;
//     var pass = document.getElementById('pass').value;
//     //alert(pass);
//     var u = "../functions/action.php?cmd=7&user=" + user + "&pass=" + pass;
// //                prompt("login", u);  
//     var r = syncAjax(u); 

//     if (r.result === 1)
//     {
//         //          alert("here 1"); 
//         if(r.user_type === 1 || r.user_type === 3 || r.user_type === 4)
//         {
//             //             alert("here 2");
//             document.location.href = "index.php"; 
//         }
//         else if (r.user_type === 2)   
//         {
//             //             alert("here 3");
//             document.location.href = "tables.php";
//         }
            
//     } else if (r.result === 0)
//     {
//         document.location.href = "login.php";
//     }

//     //    alert(user + " " + pass);
// }

function generate_password()
{
    //    alert("here"); 
    var len = 9;
    var text = " ";

    var charset = "!abcdefghi012345jklmnopqrstuvwxyz6789";

    for (var i = 0; i < len; i++)
        text += charset.charAt(Math.floor(Math.random() * charset.length));
    var generated_password = document.getElementById('generated_password');
    $('#generated_password').show(); 
    generated_password.innerHTML = text; 
    //    alert(text);
}

 

function add_user()
{
    var fname = document.getElementById("firstname").value;
    var lname = document.getElementById("lastname").value;
    var country = document.getElementById("country");
    var u_type = document.getElementById('user_type');
    var u_name = document.getElementById('user_name').value;
    var user_type = u_type.options[u_type.selectedIndex].value;
    var country_id = country.options[country.selectedIndex].value;
    var password = document.getElementById('generated_password').innerHTML;
//    alert("this is the country " + country_id); 
    var u = "../functions/action.php?cmd=5&fname=" + fname + "&lname=" + lname + "&u_type=" + user_type + "&uname=" + u_name +"&country_id="+country_id + "&pass=" + password.trim();
    //            prompt("creae user", u); 
    var r = syncAjax(u);
 
    if (r.result === 1)
    {
        alert("user succesfuly created!!");
        document.location.href = "manage_users.php";
    }
}

// function change_select_family(id)
// {
//     document.getElementById("family_id").innerHTML = id; 
//     //    alert(id); 
//     var hierarchy = document.getElementById("family_hierarchy");
//     if (id !== '0')
//     {
//         $('#family_hierarchy').val(''); 
//         var u = "../functions/action.php?cmd=11&id=" + id;
//         //          prompt("u",u);
//         var r = syncAjax(u);
//         if(r.result === 1)
//         {
//             //           alert("this idsfsdfsdfs the id" + id)
//             $('#family_hierarchy').show(); 
//             hierarchy.innerHTML = '<br> TYPE : ' + r.type + '<br> Category : ' + r.category + '<br> Sub-Cat :' + r.subcategory + '<br><br>';
//             //            hierarchy.innerHTML = '<ul><li>Type</li><li><ul>' + r.type + '</ul></li></ul>';
//             //            $('#family_hierarchy').val("" + r.subcategory);  
//         }
//     } else
//     {
//         hierarchy.innerHTML = '';
//         $('#family_hierarchy').hide(); 
//         //        $('#family_other').prop('disabled', true);
//         //        $('#family_hierarchy').val(''); 
//         //       
      
//         //        $('#family_other').prop('disabled', false);
//         //        $('#family_other').val('');
//     } 
// }



function showModal(barcode,shop_id, retailer_name, shop_name)  
{
    
     $("#myModalShopName").html('Shop Name: ' + shop_name);
        $("#myModalRetailerName").html('Retailer Name: ' + retailer_name);
//        $("#myModalShop").html(shop_id); 
    //        alert('dsfdfdfdfsdfsd');
    //  $("#no").hide();
    alert("cannot show")
    $("#myModal").modal();
      
    alert("cannot show 2")
    $("#yes").hide();
    $("#no").hide(); 

    var u = "../functions/action.php?cmd=12&barcode=" + barcode + "&shop_id=" + shop_id;
//        
//         prompt("this is to test",u);   
    var r = syncAjax(u);
    if(r.result === 1)
    {
//                        alert("the result is 1" + r.family);   
        document.getElementById("family_id").innerHTML = r.family; 
        $("#description").html(r.item_description);   
        $("#comment").html(r.comment);   
        $("#unit_value").val(r.unit);  
//         $("#family").val(r.r.family); 
//        alert("ythis is the family value " + r.family_value); 
        //        $("#family").select();  
//        
//        $('.selectpicker').selectpicker('val', r.family);
        
//        $('.selectpicker').selectpicker({
//           title:  'this is the value' 
////        });  
        $("#family option").each(function() {
            if($(this).text() === r.family_value) {
                $(this).attr('selected', 'selected');            
            }                         
        });   
//        
         $("#brand option").each(function() {
            if($(this).text() === r.brand_value) {
                $(this).attr('selected', 'selected');            
            }                         
        });  
//        $("#brand").val(r.brand);
if(r.offer_value !== 'null')
{
     $("#offer_value").show();
     $("#radio_yes").prop("checked", true); 
     $("#offer_value").val(r.offer_value);
      
}
else if (r.offer_value === 'null')
{
//    alert("the offer is null") 
    $("#offer_value").val(' ');  
}

if(r.status === 1)
{
     $("#radio_ok").prop("checked", true);
}
else if (r.status === 2)
{
    $("#radio_not_clear").prop("checked", true); 
}
//else if(r.offer_value ==='')
//{
//     $("#radio_no").prop("checked", true);
//}
//        $("#offer_value").val(r.offer_value);
        $("#quality").val(r.quality_id);
        $("#unit").val(r.unit_id);
        $("#packaging").val(r.packaging); 

            
        //            setSelectedIndex(document.getElementById("family"),r.family);  
            
//                     $("#family").val(r.family_id);   
        //             $("#unit").val(r.unit); 
        //             $("#selectBox").val(3);
           
    }
    
    //        if(shop_id === 0)
    //        {
    //            
    //        }  
    
} 



function change_select_m(val)
{
    if (val !== '0')
    {
        $("#add_manufacturer").hide();
       
        $('#brand_add').prop('disabled', false); 
        $('#brand_other').prop('disabled', false);
        $('#brand_other').val('');
    } else
    {
        $('#brand_add').prop('disabled', true); 
        $('#brand_other').prop('disabled', true);
        $('#brand_other').val('');
    }
}

function add_brand()
{
    var brand = document.getElementById('brand_other').value;
    if(brand === '')
    {
        alert("Cannot create empty brand.");
    } 

    else
    {
        var man = document.getElementById('manufacturer');
    var value_man = man.options[man.selectedIndex].value;
       alert("this is the selecte dmanufacturer :" + value_man);
    
       alert("this is the selecte dmanufacturer :" + value_man + "this is the brand :" + brand);
    var u = "../functions/action.php?cmd=8&brand=" + brand + "&man_id=" + value_man;
           prompt("u", u);
    var r = syncAjax(u);

    if (r.result === 1)
    {
        $('#collapseBrand').collapse("toggle");
        // fix this toggle toggel 2x because not closing on first toggle
        $('#collapseBrand').collapse("toggle");

         $("#brand_other").val('');
        var x = document.createElement("OPTION");
        x.setAttribute("value", ' +r.insert_id+');
        var t = document.createTextNode(r.brand);
        x.appendChild(t);
        document.getElementById("brand").appendChild(x);  
        
    }
    }

}

function change_select_manufacturer()
{
    $('#brand_add').prop('disabled', true); 
    $('#brand_other').prop('disabled', true);
    $('#brand_other').val('');
    $("#add_manufacturer").show();
    $("#manufacturer option").each(function() {
        if($(this).text() === "No manufacturer selected") {
            $(this).attr('selected', 'selected');            
        }                         
    });  
   
}

function refresh()
{
    document.location.href = "tables.php";  
}
var y = 0;
function hideButton()
{
    if(y === 0)
    {  
        //        alert("SCROLLING");
        $("#myModal").scrollTop(5000);
        //         alert("SCROLLINawsdeasdadasdG");
        //        window.scrollBy(0,1500);   
        $("#save_changes").hide();
        y = 1;
      
    }
  
    else if (y === 1) 
    {
        $("#save_changes").show();
        y = 0;
    }
}

function add_manufacturer()
{ 
    var man = document.getElementById('manufacturer_other').value;
      if(man === '')
    {
        alert("Cannot create empty manufacturer.If manufacturer is unknown please select the UNKNOWN option in the drop down before creating hte brand");
    }

    else
    {
         var u = "../functions/action.php?cmd=6&manufacturer=" + man;
               prompt("u", u);
            var r = syncAjax(u);
            if (r.result === 1)
            {
                 $('#collapseManufacturer').collapse("toggle");

                 $("#manufacturer_other").val('');  
                var x = document.createElement("OPTION");
                x.setAttribute("value", r.insert_id);   
                var t = document.createTextNode(r.manufacturer);
                x.appendChild(t);
                document.getElementById("manufacturer").appendChild(x);  
            }

    }
    
      
   
}

function offerValue(offer_radio)   
{
    if(offer_radio === 1)
    {
        $("#offer_value").show();    
    }
    else if(offer_radio === 2)
    {
        $("#offer_value").hide();
    }
}

function jsfunction()
{
    alert("lets hope this workds");
}


function supervisor_form(barcode,shop_id, retailer_name, shop_name)  
{
    
   
    var u = "../functions/action.php?cmd=21&barcode=" + barcode + "&shop_id=" + shop_id;
    //        
    //         prompt("this is to dsdsdfsdftest",u);     
    var r = syncAjax(u);
    if(r.result === 1) 
    {
        //                        alert("the result is 1" + r.family);   
        document.getElementById("family_id").innerHTML = r.family; 
        $("#description").html(r.item_description);   
        $("#comment").html(r.comment);   
        $("#unit_value").val(r.unit);  
        //         $("#family").val(r.r.family); 
        //        alert("ythis is the family value " + r.family_value); 
        //        $("#family").select();  
        //        
        //        $('.selectpicker').selectpicker('val', r.family);
             
        //        $('.selectpicker').selectpicker({
        //           title:  'this is the value' 
        ////        });  
        $("#family option").each(function() {
            if($(this).text() === r.family_value) {
                $(this).attr('selected', 'selected');            
            }                         
        });   
        //        
        $("#brand option").each(function() {
            if($(this).text() === r.brand_value) {
                $(this).attr('selected', 'selected');            
            }                         
        });  
        //        $("#brand").val(r.brand);
        if(r.offer_value !== 'null')
        {
            $("#offer_value").show();
            $("#radio_yes").prop("checked", true); 
            $("#offer_value").val(r.offer_value);
      
        }
        else if (r.offer_value === 'null')  
        {
            //    alert("the offer is null") 
            $("#offer_value").val(' ');  
        }

        if(r.status === 1)
        {
            $("#radio_ok").prop("checked", true);
        }
        else if (r.status === 2)
        {
            $("#radio_not_clear").prop("checked", true); 
        }
        //else if(r.offer_value ==='')
        //{
        //     $("#radio_no").prop("checked", true);
        //}
        //        $("#offer_value").val(r.offer_value);
        $("#quality").val(r.quality_id);
        $("#unit").val(r.unit_id);
        $("#packaging").val(r.packaging); 

             
//        
           
    }
    
   
    
}


function saveDetail(barcode, id) 
{
    //        alert("saving");
    var regex = '^[0-9]*(\.[0-9]{1,2})?$';
    var b = barcode; 
    var shop_id = 0;
    if(x===1) 
    {
        shop_id  = document.getElementById('myModalShop').innerHTML;  
        var t =  "../functions/action.php?cmd=10&barcode=" + b + "&decision=" + 2 ;  
//         prompt("t", t); 
        var a = syncAjax(t);  
        
        //        alert("modal"); 
        //        alert("modal" + shop_id);  
    }
    else
    {
        //        alert("this is value of x" + x);
        var t =  "../functions/action.php?cmd=10&barcode=" + b + "&decision=" + 1 ;  
        var a = syncAjax(t);
    }
    var packaging = document.getElementById("packaging").value;
    var p = true;
    var u;
    var item = document.getElementById("item_type");
    var item_type = item.options[item.selectedIndex].value;
   
    
    //    alert(item_type + "this is thy type");
    if(item_type === "1")
    {  
        //        alert(b);
        u = "../functions/action.php?cmd=9&barcode=" + b + "&shop_id=" + shop_id;
        //                 prompt("tis sithe non food item save",u);
    }
    else if (item_type === "0")
    {
        //        alert("no");
   
        if(packaging !== '')
        {
            if(packaging.toString().match(regex)) 
            {
                p = true;  
            }
            else
            {
                p = false;
                alert("Please enter the right format for  'PACKAGING'");
            }
        }
        if(p) 
        {
            //            alert("p wprds");
            var offer = 0;
            var offer_value= '';
                   
            var quality = document.getElementById("quality");
            var quality_id = quality.options[quality.selectedIndex].value;
            
             var origin = document.getElementById("origin");
            var origin_id = origin.options[origin.selectedIndex].value;
            
            var status;
            var item_des = document.getElementById('description').value;
            var brand = document.getElementById('brand');
            var brand_id = brand.options[brand.selectedIndex].value;
            //    alert(item_des + "item_description");
            var family = document.getElementById('family');
            var family_id = family.options[family.selectedIndex].value;
            //            var family_id = document.getElementById("family_id").innerHTML;
            var comment = document.getElementById('comment').value;
            var unit_v = document.getElementById('unit_value').value;
            var unit = document.getElementById('unit');
            var unit_id = unit.options[unit.selectedIndex].value;
     
            u = "../functions/action.php?cmd=4&origin="+origin_id+"&packaging="+ packaging+"&des=" + item_des + "&quality=" + quality_id + "&shop_id="+shop_id + "&comment=" + comment + "&brand=" + brand_id + "&family=" + family_id + "&unit_v=" + unit_v + "&unit_id=" + unit_id + "&barcode=" + barcode;
        
            if (document.getElementById('radio_ok').checked) 
            {
                status = 1;

            } else if (document.getElementById('radio_not_clear').checked)
            {
                status = 2; 
            }
             
            if (document.getElementById('radio_yes').checked) 
            {
                offer_value = document.getElementById("offer_value").value; 
                offer = 1;
                //                alert("the offer is yes and this is the value " + offer_value);
                

            } else if (document.getElementById('radio_no').checked)
            {
                offer = 2; 
                //                alert("the offer is no");
            }
            
           

            u = u + "&status=" + status + "&offer=" + offer + "&offer_value=" + offer_value; 
        }
    }    
//            prompt("u",u);       
    var r = syncAjax(u); 
 
    if (r.result === 1)  
    {
        //        alert("this is x " + x);  
        if(x === 0)
        {
            if(id === 1 )
            {    
                document.location.href = "tables.php"; 
            }
            else
            {
                //                sho2w approval modal
                if(family_id !== "0" && item_des !== "" && brand_id !=="0" && unit_id !== "0")        
                {
                   
                    $("#modalApprove").modal();    

            
   
                }
                else
                { 
                    $('#warning_label').show();
                    document.location.href = "supervisor.php"; 
                }
               
            }
            //            alert("this is x");
             
        }
        else if(x === 1)
        { 
            //            alert("this is y");
            document.location.href = location.href; 
        }
        
    } 
} 

