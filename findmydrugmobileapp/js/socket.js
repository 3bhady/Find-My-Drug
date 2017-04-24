function setupSocket(){
    var socket = io.connect('http://localhost:8890');
    token=(JSON.parse(getData("user"))).token;
addPharmacyEndPoint=api+"/addpharmacy?token="+token;
socket.on('connect',function(){

    console.log(socket.io.engine.id);
    socketId=socket.io.engine.id;

    //call endpoint to add pharmacy
    data =JSON.parse(getData("user"));
    data.socketId=socketId; 
    $$.post(addPharmacyEndPoint, data, function (succData) {
        console.log(succData);
    },function(errorData){
        console.log(errorData);
    });
    console.log(socketId);
});

socket.on('notification',function(notification) {
//console.log(notification);
    addEvents(notification);
});
}
function addEvents(data)
{console.log("z");
myApp.alert("new notification, from user_id :"+data["user_id"]
    +" drug name "+data["drug_name"],"dr.ali32423");
}
