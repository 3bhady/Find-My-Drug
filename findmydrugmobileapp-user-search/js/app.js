// Initialize app
key="ff22";
var myApp = new Framework7({
pushState:true,
swipePanel:'left',
init:false
});
//used to be called once
 var firstTimeToLoad=true;
// If we need to use custom DOM library, let's save it to $$ variable:
var $$ = Dom7;
var endpoint= api+'/drug/search/';
// Add view
var mainView = myApp.addView('.view-main', {
  // Because we want to use dynamic navbar, we need to enable it for this view:
  dynamicNavbar: true
});



var indexTriggering=myApp.onPageBeforeInit('index',function(page){

    console.log("index");
    setupIndex(page);
    setupSocket();
});


//myApp.init();
/////////////////////////////////////////////////////////////////////////////////////////////////
//setupIndex will be called when initializing the app
function setupIndex(page)
{

    myApp.params.swipePanel = 'left';
    //localStorage.removeItem("customer");
    user=localStorage.getItem("customer");
    console.log(user);

    isLogin=true;
    //to be changed
    if(localStorage.getItem("customer")===null)
    {
        console.log("not login");

        isLogin=false;
    }

    if(!isLogin)
    {


        //console.log("not login");
        login();
    }


    setupSearch();



}
function setupSearch(){
    console.log("searchAgain");
mySearchbar = myApp.searchbar('.searchbar', {

    customSearch:true,
    removeDiacritics:true,
    hideDividers:true,
    onSearch:function(data)
    {
        console.log("on Search");
        Search(data.query);
    }

});
}
console.log("searchBar");

Search = function(data){
    if(data!="")
        $$.get(endpoint+data
            ,function(succData)
            {
                // console.log(succData);
                succData=JSON.parse(succData);
                CreateList(succData);

            }
            ,function(errorData)
            {
                console.log(errorData);
                errorData=JSON.parse(errorData);

            });


};

CreateList= function(data){
    var middle='';
    var start='<div class="list-block">' + ' <ul>';
    var end=' </ul> ' + '</div>';
    $$.each(data,function(key,value){

       // middleList+=" <li value="+value+">"+key+"</li>";

/*        middle+='  <a id="'+value+'" href="drug.html" class="item-link"> ' +
            '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
            '<div class="item-inner"> ' +
            '<div class="item-title">' +
             key+
            '</div> ' +
            '</div>';
    });*/
middle+='    <li> ' +
    '<a href="drug.html" class="item-link item-content drug" data-id="'+value+'"> ' +
    '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
    '<div class="item-inner"> ' +
    '<div class="item-title">'+key+'</div> ' +
    '<div class="item-after">View</div> ' +
    '</div> ' +
    '</a> ' +
    '</li>';});


        $$('#list-view').empty();
        $$('#list-view').append(start+middle+end);
        //$$('#list-view').clear();
        //$$('#list-view').append(start+middle+end);
    $$('.drug').on('click',function(){
        localStorage.setItem("drug_id",$$(this).data("id"));
    });
   /* $$.each(data,function(key,value) {
        var li = document.getElementById(value).onclick = function () {
            console.log(value);
            localStorage.setItem("drug_id",value);
        }
    });*/



};





var dropdown = myApp.autocomplete({
    input: '#dropdown',
    openIn: 'dropdown',
    preloader: true, //enable preloader
    valueProperty: 'id', //object's "value" property name
    textProperty: 'name', //object's "text" property name
    limit: 10, //limit to 20 results
    dropdownPlaceholderText: 'Try "Panadol"',
    focus:true,
    expandInput: true, // expand input
    source: function (autocomplete, query, render) {
        var results = [];
        if (query.length === 0) {
            render(results);
            return;
        }
        // Show Preloader
        autocomplete.showPreloader();


        if(query!="")
        $$.get(endpoint+query
            ,function(succData)
            {
               // console.log(succData);
                succData=JSON.parse(succData);
                //CreateList(succData);
                autocomplete.hidePreloader();

               $$.each(succData,function (key,value) {
                   results.push({'id':value,'name':key});
               });
                render(results);
            }
            ,function(errorData)
            {
                console.log(errorData);
                errorData=JSON.parse(errorData);

            });
    },
    onChange:function(name,id){
      //  console.log(id.id);
        localStorage.setItem("drug_id",id.id);
        mainView.router.loadPage("drug.html");
    }
});








function setData(key,val)
{
    return localStorage.setItem(key,val);
}
function getData(key)
{
    return localStorage.getItem(key);
}

