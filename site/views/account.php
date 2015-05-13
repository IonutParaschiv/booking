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
</head>
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
    <ul class='nav navbar-nav navbar-default navbar-left'>
      <li><a href="#">Bookings</a></li>
      <li><a href="#">Settings</a></li>
      <li><a href="#">Company</a></li>
      <li><a href="#">Widget</a></li>
        
    </ul>
</div>

<div class="container">
    <div class="bookingsView">
        <div class="calendarContainer">
            <iframe src="/bachelor/site/inc/lib/fullcalendar/demos/default.html"></iframe>
        </div>
    </div>
</div>