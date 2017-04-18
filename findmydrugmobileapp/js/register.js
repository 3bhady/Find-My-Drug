myApp.onPageInit('register', function (page) {
    $$('#submitRegisterForm').on('click',function(){
        

        var endpoint='http://localhost/findmydrug/public/api/v1/pharmacyform';
        data= myApp.formToData('#registerForm');
        console.log(data);

        emptyElement=false;
    $$.each(data,function(key,val){
       if(val==""&&key!="delivery"){
           emptyElement=true;
       }

    });
        if(emptyElement){
            myApp.alert('all fields must be filled',"Dear Pharmacist");
        }
        else {


            $$.post(endpoint, data,function(succData) {
		

                succData=JSON.parse(succData);
                console.log(succData);
                if(succData["status"]=="success"){
                myApp.alert('registeration completed, we will email you soon',"Dear Pharmacist");
                }
                else
            myApp.alert('something went wrong, you might have been registered with the same' +
                'information before.',"Dear Pharmacist");

        },function(errorData){
                jsonResponse=JSON.parse(errorData.responseText);
                //console.log(jsonResponse);
                $$.each(jsonResponse,function(key,val){
                    myApp.alert(key+' not valid .. : '+val,"Dear Pharmacist");

                });
            });
        }
    //console.log(data,emptyElement);
    });
});
