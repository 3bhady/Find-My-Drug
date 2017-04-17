
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

//online users and pharmacies
var user=[];
//holding key as socket
var pharmacySocket={};
//holding id as key
var pharmacyId={};


server.listen(8890);
io.on('connection', function (socket) {

    console.log("new client connected");
    user.push(socket.id);
    console.log(socket.id);
    var redisClient = redis.createClient();

        redisClient.subscribe('message');
        redisClient.subscribe('notification');
        redisClient.subscribe('addPharmacy');


    redisClient.on("message", function(channel, message) {
        //console.log("new message in queue "+ channel + "channel");
        //console.log(message);
        message=JSON.parse(message);
        if(channel=="addPharmacy"){
        addPharmacy(message);
        }
        if(channel=="notification"){
            io.emit("notification","new notification available..");
        }
    });
    //add pharmacy
    function addPharmacy(pharmacyJsonData)
    {


         pharmacySocketId=pharmacyJsonData.socketId;
         pharmaId=pharmacyJsonData.id;

         pharmacySocket[pharmacySocketId]=pharmacyJsonData;
         pharmacyId[pharmaId]=pharmacyJsonData;

          //io.emit("notification","new notification available");
          console.log(pharmacyId);
          console.log(pharmacySocket);

    }



    socket.on('disconnect', function() {
        redisClient.quit();
        console.log("new client disconnected");
        pharmaId=(pharmacySocket[socket.id]).id;
        delete   pharmacySocket[socket.id];
        delete   pharmacyId[pharmaId];
        console.log(pharmacySocket);
        console.log(pharmacyId);
    });

});