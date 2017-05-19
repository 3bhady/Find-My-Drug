/**
 * Created by muham on 4/19/2017.
 */
var endpoint3 = api +'/request';
myApp.onPageBeforeAnimation('pharmacies',function(){

    console.log("back to pharmacies");
    myApp.params.swipePanel = 'left';
    data2={
        "drug_id":getData("drug_id"),
        "lon":2,
        "lat":5,
        "user_id":(JSON.parse(getData("customer"))).id

        };
console.log(data2);
    $$.post(endpoint3,data2
        ,function(succData)
        {
           console.log(succData);
            succData=JSON.parse(succData);

            //CreateList(succData);

        }
        ,function(errorData)
        {
            console.log(errorData);
            errorData=JSON.parse(errorData);

        });

});


myApp.init();
//we want to remove triggering index page on page init because we need initializing only one time ..
    