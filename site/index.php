<!DOCTYPE html>
<html>
<head>
    <title>BookRest</title>
    <link rel="stylesheet" href="inc/lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="inc/site/style.css">
    <script type="text/javascript" src="inc/lib/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="inc/lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="inc/site/master.js"></script>
</head>
<body>

<div class="main-nav container-fluid">
    <ul class="nav navbar-nav navbar-default navbar-right">
      <li><a href="#">Home</a></li>
      <li><a href="#">Profile</a></li>
      <li><a href="#" data-toggle="modal" data-target=".loginModal">Login</a></li>
    </ul>
</div>
<div class="wide"></div>

<div class="container">
</div>



<script type="text/javascript">ajax.console()</script>
<!--modals-->
<div class="modal fade loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="userImg">
          <img src="inc/img/user_normal.png">
        </div>
      </div>
      <div class="modal-body">
      <div class="userfeedback">
          
      </div>
        <form>
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" id="username">
            <span class="glyphicon-class"></span>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" id="password">
          </div>
          <div class="form-group">
            <button type="submit" onclick="user.login(); return false;" class="btn btn-default">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>

