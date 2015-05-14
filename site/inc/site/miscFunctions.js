var fill = {
    accountForm: function(id){
        var args = "method=getAccount&id="+id;
        $.ajax({
          type: "POST",
          url: "/bachelor/site/inc/lib/php/RequestHandler.php",
          data: args,
          success: function(data){
            var dataArray = JSON.parse(data);
            for(var i = 0; i<dataArray.length; i++ ){
                $('#name').val(dataArray[i].name);
                $('#surname').val(dataArray[i].surname);
                $('#email').val(dataArray[i].email);
            }
          },
        });
    }
};