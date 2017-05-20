// Initialize app

var myApp = new Framework7({
    swipePanel: 'left',
    init: false
});
console.log("start...");


/*
 socket.on('message', function (data) {
 $( "#messages" ).append( "<p>"+data+"</p>" );
 });*/
// If we need to use custom DOM library, let's save it to $$ variable:
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    // Because we want to use dynamic navbar, we need to enable it for this view:
    dynamicNavbar: true
});
localStorage.removeItem("user");

myApp.onPageBeforeInit('index',function(){
    console.log("index");




    //setup socket.io
    //need to check if valid token..
    myApp.params.swipePanel = 'left';
    user=localStorage.getItem("user");
    isLogin=true;
    //to be changed
    if(user==null)
    {
        isLogin=false;
    }
    if(!isLogin)
    {

        console.log("not login");
        addLoginUi();
    }
    else {
        console.log("login...");
        user=JSON.parse(user);
        // console.log(user);
        setupSocket();
        setupInfiniteScroll();

    };


    $$('.notification-callback').on('click', function () {
        myApp.addNotification({
            title: 'My Awesome App',
            subtitle: 'New message from John Doe',
            message: '<a id="take"> testttttttttttttttttttttt</a>',
            media: '<img width="44" height="44" style="border-radius:100%" src="http://lorempixel.com/output/people-q-c-100-100-9.jpg">',
            onClose: function () {
                myApp.alert('Notification closed');
            }

        });
    });




});

function updateHistory(historyEndpoint)
{
    if(currentPage>=lastPage&&lastPage!=-1)
    {
        console.log("we are in our last page ");
        return;
    }
  //  console.log(historyEndpoint);
    $$.get(historyEndpoint, function (succData) {
        currentPage++;

        console.log("curent page -> "+currentPage);
        succData=JSON.parse(succData);
        lastPage=succData.last_page;
        console.log("pagination successed");
        //console.log(succData);
        // Generate new items HTML


    //    console.log(succData.data);

        html='';
        $$.each(succData.data,function(key,val){
        if(val.status==0)
        {
            status='<i class="material-icons">error</i>';
        }
        else {
            status='<i class="material-icons">done_all</i>';
        }
        html += '<li class="swipeout">' +
            '<div class="swipeout-content item-content">' +
            '<div class="item-media">' +
            '<i class="material-icons">history</i>' +
            val.created_at+'</div>' +
            '<div class="item-inner">' +
            status +

            '</div></div><div class="swipeout-actions-right">' +
            '<a href="#" class="swipeout-delete swipeout-overswipe">Hide</a>' +
            '</div>'+
            '</li>';
        // Append new items
        });

        console.log(html);
        $$('.list-block ul').append(html);

    },function(errorData){
        console.log(errorData);
    });
}
function setupInfiniteScroll()
{
     currentPage=1;
    lastPage=-1;
    var token=(JSON.parse(getData("user"))).token;
     Historyendpoint=api+"/history?page="+currentPage+"&token="+token;
    //get initial pagination values;
    //to make things scrollable we need to init. our first primary list
    updateHistory(Historyendpoint);


// Loading flag
    var loading = false;

// Last loaded index
    var lastIndex = $$('.list-block li').length;

// Max items to load
    var maxItems = 200;

// Append items per load
    var itemsPerLoad = 20;

// Attach 'infinite' event handler
    $$('.infinite-scroll').on('infinite', function () {

        // Exit, if loading in progress
        if (loading) return;

        // Set loading flag
        loading = true;

        // Emulate 1s loading
        setTimeout(function () {
            // Reset loading flag
            loading = false;
            Historyendpoint=api+"/history?page="+currentPage+"&token="+token;
            updateHistory(Historyendpoint);




        }, 1000);
    });
}
$$('.hide').on('click',function(){
//myApp.alert("ok","sadsadas");
});
function addLoginUi()
{
    var html='<div class="page" data-page="login"  >'+
        '<p>Page content goes here</p>'+
        '<!-- Link to another page -->'+
        '<a href="register.html">register as a pharmacist</a><br>'+
        '<a href="login.html" class="open-login-screen">Login as a pharmacist</a>'+
        '</div>';
    console.log("in add login ui");
    mainView.router.loadPage("login.html");

}

function setData(key,val)
{
    return localStorage.setItem(key,val);
}
function getData(key)
{
    return localStorage.getItem(key);
}
myApp.init();