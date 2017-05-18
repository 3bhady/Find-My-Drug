/**
 * Created by mohamed on 4/18/17.
 */

var endpoint2=api + '/drug/';
myApp.onPageBeforeAnimation('drug', function (page) {
    console.log("back to the drug");
var data = getData('drug_id');
    $$.get(endpoint2+data
        ,function(succData)
        {

            succData=JSON.parse(succData);
         //   console.log(succData);
          //  CreateList(succData);
            ShowDrug(succData[0]);


        }
        ,function(errorData)
        {
            console.log(errorData);
            errorData=JSON.parse(errorData);

        });

});

ShowDrug= function(data){

    $$.each(data,function(key,value){

        // middleList+=" <li value="+value+">"+key+"</li>";
        if(key=='price')
            value+=" LE";
      $$('#'+key).append("<p>"+value+"</p>");
    });

   // $$('#list-view').append(start+middle+end);
    //$$('#list-view').clear();
    //$$('#list-view').append(start+middle+end);



};