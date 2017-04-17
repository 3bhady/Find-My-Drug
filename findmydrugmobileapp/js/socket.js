function setupSocket(){
    var socket = io.connect('http://localhost:8890');
    token=(JSON.parse(getData("user"))).token;
addPharmacyEndPoint="http://localhost/findmydrug/public/api/v1/addpharmacy?token="+token;
socket.on('connect',function(){

   // console.log(socket.io.engine.id);
    socketId=socket.io.engine.id;

    //call endpoint to add pharmacy
    data =JSON.parse(getData("user"));
    data.socketId=socketId; 
    $$.post(addPharmacyEndPoint, data, function (succData) {
        console.log(succData);
    },function(errorData){
        console.log(errorData);
    });

});

socket.on('notification',function(notification) {
console.log(notification);
    addEvents(socket);
});
}
function addEvents(socket)
{
    socket.on('notification',function(data){
        myApp.alert(data,"realtime yahooo!!");
    });
}
