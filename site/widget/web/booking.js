function openBooking(companyId){
    // appendServices(companyId);
   
    var iframe = "<iframe frameborder='0' src='/bachelor/site/widget/web/iframe.html' style='width:60%; height:500px; margin-left:20%; margin-top:5%; overflow-x:hidden;'> </iframe>";
    var iframeContainer = "<div id='fader' style='width:100%; height:100%; background-color:rgba(76, 76, 76, 0.4);position:absolute;top:0; z-index:99;'></div>";
    var bodyHtml = document.body.innerHTML;
    document.body.innerHTML = bodyHtml + iframeContainer;

    document.getElementById('fader').innerHTML = iframe;
}

function openOverlay(url){

}

// function createBooking(){
//     alert('booking created');
// }

// function appendServices(companyId){
//     var args = "method=getServices&company_id="+companyId;
//     $.ajax({
//       type:"POST",
//       url: "/bachelor/site/widget/web/booking.php",
//       data: args,
//       success: function(data){
//         data = JSON.parse(data);
//         if(data.success){
//             var services = JSON.parse(data.data);
//             var option = "<option value='null'>No service selected</option>"
//             for(var i = 0;  i<services.length; i++){
//                 option = option + '<option value="'+services[i].id+'">'+services[i].name+'</option>';
//             }
//             $('#services').html(option);                    
//         }
//       }
//     });
// }

// function showServiceDetails(companyId, serviceId){
//     var args = "method=getServices&company_id="+companyId;
//     $.ajax({
//       type:"POST",
//       url: "/bachelor/site/widget/web/booking.php",
//       data: args,
//       success: function(data){
//         data = JSON.parse(data);
//         if(data.success){
//             var services = JSON.parse(data.data);
//             for(var i = 0;  i<services.length; i++){
//                 if(services[i].id == serviceId){
//                     $('#showServiceDetails').css( "background-color", "gray" );
//                     var html = "<p>"+services[i].name+"</p>";
//                     html += "<p><i>Description:</i><br/>"+services[i].description+"</p>";
//                     $('#showServiceDetails').html(html);    
//                 }
//                 // option = option + '<option value="'+services[i].id+'">'+services[i].name+'</option>';
//             }
//             // $('#showServiceDetails').html(option);                    
//         }
//       }
//     });
//     // showServiceDetails
// }