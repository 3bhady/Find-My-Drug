/**
 * Created by dell on 26/04/2017.
 */

var endpoint5 = api+'/pharmacy';
//Get a reference to the link on the page
// with an id of "search_pharmacies"

//Set code to run when the link is clicked
// by assigning a function to "onclick"
myApp.onPageBeforeAnimation('pharmacies',function(){

    console.log("test");
    $$.get(endpoint5
        ,function(succData)
        {

            succData=JSON.parse(succData);
            //console.log(succData);
            //CreatePharmaciesList(succData);

        }
        ,function(errorData)
        {
            console.log(errorData);
            errorData=JSON.parse(errorData);

        });


});

CreatePharmaciesList= function(data) {
    var middle = '';
    //var start = '<div class="list-block">' + ' <ul>';
    //var end = ' </ul> ' + '</div>';
   // for (var i = 0; i < data.length; i++) {
        // middleList+=" <li value="+value+">"+key+"</li>";

        /*        middle+='  <a id="'+value+'" href="drug.html" class="item-link"> ' +
         '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
         '<div class="item-inner"> ' +
         '<div class="item-title">' +
         key+
         '</div> ' +
         '</div>';
         });*/
        middle += '    <li> ' +
            '<a href="pharmacy.html" class="item-link item-content pharmacy" data-id="' + data[Object.keys(data)[0]] + '"> ' +
            '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
            '<div class="item-inner"> ' +
            '<div class="item-title">' + data[Object.keys(data)[1]] + '</div> ' +
            '<div class="item-after">View</div> ' +
            '</div> ' +
            '</a> ' +
            '</li>';
   // }

   //$$('#pharmacies-view').empty();
    $$('#pharmacies-view').prepend( middle );
    //$$('#pharmacies-view').append(start + middle + end);
    //$$('#list-view').clear();
    //$$('#list-view').append(start+middle+end);
    $$('.pharmacy').on('click', function () {
        localStorage.setItem("pharmacy_id", $$(this).data("id"));
    });
    /* $$.each(data,function(key,value) {
     var li = document.getElementById(value).onclick = function () {
     console.log(value);
     localStorage.setItem("drug_id",value);
     }
     });*/
};
