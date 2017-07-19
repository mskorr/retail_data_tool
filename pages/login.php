<?php
session_start();
session_destroy(); 
?> 
<!DOCTYPE html>
  <title>Flat Admin V.3 - Free flat-design bootstrap administrator templates</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/yellow.css">

<html>  
  
<body>
  <div class="app app-default">

<div class="app-container app-login">
  <div class="flex-center">
    <div class="app-header"></div>
    <div class="app-body">
      <div class="loader-container text-center">
          <div class="icon">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div> 
            </div>
          <div class="title">Logging in...</div>
      </div>
      <div class="app-block">   
      <div class="app-form">
        <div class="form-header">
          <div class="app-brand"><span class="highlight">Retail Data Tool</span> Admin</div>
        </div>
          <form >  
            <div class="input-group">
              <span class="input-group-addon" >
                <i class="fa fa-user" aria-hidden="true"></i></span>
              <input id="username" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
              <span class="input-group-addon" >
                <i class="fa fa-key" aria-hidden="true"></i></span>
              <input id="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
            </div>
            <div class="text-center">
                <input onclick="login()" type="submit" class="btn btn-success btn-submit" value="Login">
            </div>
        </form>
      </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>

  </div>
  
  <script type="text/javascript" src="../assets/js/vendor.js"></script>
  <script type="text/javascript" src="../assets/js/app.js"></script>
  <script type="text/javascript" src="../functions/functions.js"></script>  

</body>
</html>