myApp.onPageInit('register', function (page) {
    $$('#submit').on('click',function(){
        
        var endpoint='http://localhost/findmydrug/public/api/v1/pharmacyform';
   data= myApp.formToData('#register');
        emptyElement=false;
    $$.each(data,function(key,val){
       if(val==""&&key!="delivery"){
           emptyElement=true;
       }

    });
        if(emptyElement){
            myApp.alert('mtmla dek om el form kolha ybn el klb',"Dear Pharmacist");
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