<?php ?>

<!DOCTYPE html>
<html>
<head>
    <title>BookRest</title>
    <link rel="stylesheet" href="/bachelor/site/inc/lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bachelor/site/inc/site/style.css">
    <link rel="stylesheet" type="text/css" href="/bachelor/site/inc/site/subnav.css">
    <link rel="stylesheet" type="text/css" href="/bachelor/site/inc/lib/bootstrap_select/dist/css/bootstrap-select.css">
    <script type="text/javascript" src="/bachelor/site/inc/lib/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/bachelor/site/inc/lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="/bachelor/site/inc/site/master.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script type="text/javascript" src="/bachelor/site/inc/lib/bootstrap_select/dist/js/bootstrap-select.js"></script>

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
      <ul class='nav navbar-nav navbar-default navbar-left subnav'>
        <li><a href="/bachelor/site/views/account.php">Bookings</a></li>
        <li><a href="/bachelor/site/views/settings.php">Settings</a></li>
        <li><a href="/bachelor/site/views/company.php">Company</a></li>
        <li><a href="#">Widget</a></li>
      </ul>
  </div>
  <div class="stackedNav">
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a data-target='companyForm' class='subnav_node' href="">Manage Company</a></li>
        <li><a data-target='staffForm' class='subnav_node' href="#">Manage Staff</a></li>
        <li><a data-target='servicesForm' class='subnav_node' href="#">Manage Services</a></li>
        <li><a href="#">Menu 3</a></li>
      </ul>
  </div>



<div class="container companyContainer">

<!-- COMPANY BLOCK -->
    <div class="submenu_item visible">

      <div class="companyBlocks availableCompanies">
        <h5 class="formTitle"> Available Companies</h5>
        <div class="userfeedback_company_edit"></div>
        <script>company.getAll();</script>
        <form id="companyEditForm">
            <div class="form-group">
              <select onchange="company.get()" class="availableCompaniesSelect" data-style="btn-primary" name="companyId" id="availableCompaniesSelect">
                <option value="0">Nothing selected</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="name" name="name"  placeholder=" Company name" value="">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="email" name="email"  placeholder="Company email" value="">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="address" name="address"  placeholder="Company address" value="">
            </div>
            <div class="form-group">
              <textarea class="form-control" id="openingH" name="openingH"  placeholder="Company Opening Hours"></textarea>
            </div>
            <br/>
            <button type="submit" onclick="company.edit(); return false;" class="btn companyControlBtn btn-default button-half">Save</button>
            <button type="submit" onclick="company.delete(); return false;" class="btn companyControlBtn btn-danger button-half">Delete</button>
        </form>
      </div>
      <div class="createCompany companyForm companyBlocks">
        <h5 class="formTitle"> Create new company</h5>
        <div class="userfeedback_company_create"></div>
        <form id="companyCreateForm">
            <div class="form-group">
              <input type="text" class="form-control" id="name" name="name"  placeholder=" Company name" value="">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="email" name="email"  placeholder="Company email" value="">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="address" name="address"  placeholder="Company address" value="">
            </div>
            <div class="form-group">
              <textarea class="form-control" id="openingH" name="openingH"  placeholder="Company Opening Hours"></textarea>
            </div>
            <br/>
            <button type="submit" onclick="company.create(); return false;" class="btn btn-default button-wide">Save</button>
        </form>
      </div>
    </div>
    
<!-- STAFF BLOCK -->
    <div class="staffForm submenu_item hidden">
    <div class="form-group">
        <select onchange="service.getAll('availableCompaniesStaffSelect');" class="availableCompaniesSelect" data-style="btn-primary" name="companyId" id="availableCompaniesStaffSelect">
          <option value="">Nothing selected</option>
        </select>
    </div>
    <div class='createStaff staffForm'>
    <div class="userfeedback_staff_create"></div>
      <form id="staffCreateForm">
          <div class="form-group">
            <input type="text" class="form-control" id="name" name="name"  placeholder=" Staff name" value="Jax">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="surname" name="surname"  placeholder=" Staff surname" value="Seymour">
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="email" name="email"  placeholder="Staff email" value="jax@seymour.com">
          </div>
          <div class="form-group" id="availableServices">
          <label for="email">Services Available</label>
            
          </div>
          <br/>
          <button type="submit" onclick="staff.create();return false;" class="btn btn-default button-wide">Save</button>
      </form>
    </div>
    </div>
<!-- Services BLOCK -->
    
    <div class="createService servicesForm submenu_item hidden">
    <div class="form-group">
        <select onchange="service.getAll('availableCompaniesServiceSelect');" class="availableCompaniesSelect" data-style="btn-primary" name="companyId" id="availableCompaniesServiceSelect">
          <option value="">Nothing selected</option>
        </select>
    </div>
    <div class="servicesContainer">
      <ul id='servicesList'>
        
      </ul>
    </div>
    <div class="createServices servicesForm">
      <div class="userfeedback_service_create"></div>
        <form id="serviceCreateForm">
            <div class="form-group">
              <input type="text" class="form-control" id="name" name="name"  placeholder="Service name" value="Service #1">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="price" name="price"  placeholder="Price" value="20">
            </div>
            <div class="form-group">
              <textarea class="form-control" id="description" name="description"  placeholder="Service Description">This is an awesome service</textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="duration" name="duration"  placeholder="Duration" value="120">
            </div>
            <br/>
            <button type="submit" onclick="service.create(); return false;" class="btn btn-default button-wide">Save</button>
        </form>
      </div>
    </div>
  </div>

    <script type="text/javascript" src="/bachelor/site/inc/lib/js/subnav.js"></script>
</body>
</html>