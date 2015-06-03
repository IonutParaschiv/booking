function openBooking(companyId){
    appendServices(companyId);
    var form = '<form id="registerForm"> <div class="form-group"> <input type="text" class="form-control" name="name" placeholder="Name*" id="name"> <span class="glyphicon-class"></span> </div><div class="form-group"> <input type="text" class="form-control" name="surname" placeholder="Surname*" id="Surname"> <span class="glyphicon-class"></span> </div><div class="form-group"> <input type="text" class="form-control" name="email" placeholder="Email*" id="email"> <span class="glyphicon-class"></span> </div><div class="form-group"><label for="services">Select a service</label><br/>     <select name="services" id="services" onchange="showServiceDetails(20,$(this).val())"></select> </div><div id="showServiceDetails"></div><div class="form-group"> <button type="submit" onclick="createBooking(); return false;" class="btn btn-default">Submit</button> </div></form>';
    document.getElementById('formContainer').innerHTML = form;
}

function openOverlay(url){

}

function createBooking(){
    alert('booking created');
}

function appendServices(companyId){
    var args = "method=getServices&company_id="+companyId;
    $.ajax({
      type:"POST",
      url: "/bachelor/site/widget/web/booking.php",
      data: args,
      success: function(data){
        data = JSON.parse(data);
        if(data.success){
            var services = JSON.parse(data.data);
            var option = "<option value='null'>No service selected</option>"
            for(var i = 0;  i<services.length; i++){
                option = option + '<option value="'+services[i].id+'">'+services[i].name+'</option>';
            }
            $('#services').html(option);                    
        }
      }
    });
}

function showServiceDetails(companyId, serviceId){
    var args = "method=getServices&company_id="+companyId;
    $.ajax({
      type:"POST",
      url: "/bachelor/site/widget/web/booking.php",
      data: args,
      success: function(data){
        data = JSON.parse(data);
        if(data.success){
            var services = JSON.parse(data.data);
            for(var i = 0;  i<services.length; i++){
                if(services[i].id == serviceId){
                    $('#showServiceDetails').css( "background-color", "gray" );
                    var html = "<p>"+services[i].name+"</p>";
                    html += "<p><i>Description:</i><br/>"+services[i].description+"</p>";
                    $('#showServiceDetails').html(html);    
                }
                // option = option + '<option value="'+services[i].id+'">'+services[i].name+'</option>';
            }
            // $('#showServiceDetails').html(option);                    
        }
      }
    });
    // showServiceDetails
}