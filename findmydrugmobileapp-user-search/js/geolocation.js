


$$('#updateLocation').on('click',function(){
//todo update pharmacy location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            var user_id=(JSON.parse(getData("customer"))).id;
            endpoint=api+"/updateCustomerLocation";
            var data={
                "id":user_id,
                "lat":position.coords.latitude,
                "lon":position.coords.longitude
            }
            $$.post(endpoint,data,function(succ){
                console.log("location updated");
            },function(fail){
                console.log("location not updated /failed ");
            });


        }, function(error){
            console.log(error);
        });
    } else {
        myApp.alert("geolocation not supported ..sorry..");
    }





});