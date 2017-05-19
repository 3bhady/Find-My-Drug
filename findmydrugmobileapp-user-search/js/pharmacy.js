/**
 * Created by dell on 25/04/2017.
 */

var endpoint4=api+'/pharmacy/';

myApp.onPageBeforeAnimation('pharmacy', function (page) {

    console.log("Pharmacy profile");
    var data = getData('pharmacy_id');
    $$.get(endpoint4+data
        ,function(succData)
        {

            succData=JSON.parse(succData);
            //   console.log(succData);
            //  CreateList(succData);
            ShowPharmacy(succData[0]);


        }
        ,function(errorData)
        {
            console.log(errorData);
            errorData=JSON.parse(errorData);

        });

});

ShowPharmacy= function(data){

    $$.each(data,function(key,value){

        // middleList+=" <li value="+value+">"+key+"</li>";
        $$('#'+key).append("<p>"+value+"</p>");
    });

    // $$('#list-view').append(start+middle+end);
    //$$('#list-view').clear();
    //$$('#list-view').append(start+middle+end);



};