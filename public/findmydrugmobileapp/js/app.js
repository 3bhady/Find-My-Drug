// Initialize app
var myApp = new Framework7({

});
console.log("start...");
var socket = io.connect('http://localhost:8890');
socket.on('connect',function(){
    console.log(socket.io.engine.id);
});
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
$$('.hide').on('click',function(){
//myApp.alert("ok","sadsadas");
});

