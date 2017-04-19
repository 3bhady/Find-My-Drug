/**
 * Created by muham on 4/19/2017.
 *//*
var endpoint3 = 'http://localhost/findmydrug/public/api/v1/request';
myApp.onPageInit('pharmacies',function(){

    console.log("back to pharmacies");
    myApp.params.swipePanel = 'left';
    data2={
    "drug_id":getData("drug_id"),
        "lon":2,
        "lat":5,
        "id":30000
};
    $$.post(endpoint3,data2
        ,function(succData)
        {

            succData=JSON.parse(succData);
            console.log(succData);
            //CreateList(succData);

        }
        ,function(errorData)
        {
            console.log(errorData);
            errorData=JSON.parse(errorData);

        });

});
*/

myApp.init();