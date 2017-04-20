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