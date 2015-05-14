<?php ?>

<!DOCTYPE html>
<html>
<head>
    <title>BookRest</title>
    <link rel="stylesheet" href="/bachelor/site/inc/lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bachelor/site/inc/site/style.css">
    <script type="text/javascript" src="/bachelor/site/inc/lib/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/bachelor/site/inc/lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="/bachelor/site/inc/site/master.js"></script>
    <script type="text/javascript" src="/bachelor/site/inc/site/miscFunctions.js"></script>
</head>

<?php
if(!empty($_COOKIE['userSession'])){
    $cookie = json_decode($_COOKIE['userSession']);
    $userId = $cookie->uid;
    echo " <script> fill.accountForm(".$userId."); </script>";
}
?>

<body>
<div class="main-nav container-fluid">
    <ul class="nav navbar-nav navbar-default navbar-right">
      <li><a href="/bachelor/site">Home</a></li>
      <?php if(empty($_COOKIE['userSession'])){
        echo '<li><a href="#" data-toggle="modal" data-target=".loginModal">Login</a></li>
      <li><a href="#" data-toggle="modal" data-target=".registerModal">Register</a></li>';
      }else{
        echo '<li><a href="#">My Account</a></li>';
      }
      ?>
    </ul>
</div>
<div class="wide-nav">
    <ul class='nav navbar-nav navbar-default navbar-left subnav'>
      <li><a href="/bachelor/site/views/account.php">Bookings</a></li>
      <li><a href="/bachelor/site/views/settings.php">Settings</a></li>
      <li><a href="/bachelor/site/views/company.php">Company</a></li>
      <li><a href="#">Widget</a></li>
        
    </ul>
</div>

<div class="container">
    <div class="accountForm">
        <form id="editAccountForm">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name"  placeholder="Name" value="">
          </div>
          <div class="form-group">
            <label for="email">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="">
          </div>
      <!--     <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div> -->
          
          <button type="submit" onclick="user.edit(); return false;" class="btn btn-default">Edit</button>
        </form>
    </div>
</div>