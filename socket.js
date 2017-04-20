
app = require('express')();
server = require('http').Server(app);
io = require('socket.io')(server);
redis = require('redis');
request=require('request');

//online users and pharmacies
user=[];
//holding key as socket
pharmacySocket={valid_key:  undefined};
//holding id as key
pharmacyId={valid_key:  undefined};


server.listen(8890);
io.on('connection', function (socket) {

    console.log("new client connected");
    user.push(socket.id);
    // console.log(socket.id);



    socket.on('disconnect', function() {

        redisClient.quit();

        request('http://localhost/findmydrug/public/api/v1/setonline', function (error, response, body) {
            console.log('error:', response.body); // Print the error if one occurred

        });

        //io.emit("goOffline","new notification available..");

        pharmaId=(pharmacySocket[socket.id]).id;
        delete   pharmacySocket[socket.id];
        delete   pharmacyId[pharmaId];
        console.log(pharmacySocket);
        console.log(pharmacyId);
    });


});

redisClient = redis.createClient();

redisClient.subscribe('message');
redisClient.subscribe('notification');
redisClient.subscribe('addPharmacy');

redisClient.on("message", function(channel, message) {
    //console.log("new message in queue "+ channel + "channel");
    //console.log(message);
    // console.log("new request sent");
    message=JSON.parse(message);
    if(channel=="addPharmacy"){
        addPharmacy(message);
    }
    if(channel=="notification"){
        console.log("again");
        // io.emit("notification","ok");
        for(var i of message.pharmacies) {
            console.log("i" + i);

            if (i != undefined) {
                console.log("phrmacyID[i]:" + pharmacyId[i].socketId);
                io.to(pharmacyId[i].socketId).emit("notification", message);

            }
        }
        /*  if(pharmacyId!=undefined)
         {
         console.log('i:'+i);
         console.log(pharmacyId[i]);
         io.socket.connected[pharmacyId[i].socketId].emit("notification",message);}
         }*/
    }
});
//add pharmacy
function addPharmacy(pharmacyJsonData)
{


    pharmacySocketId=pharmacyJsonData.socketId;
    pharmaId=pharmacyJsonData.id;

    pharmacySocket[pharmacySocketId]=pharmacyJsonData;
    pharmacyId[pharmaId]=pharmacyJsonData;
    console.log(" new user added with socket->"+pharmacySocketId);
    console.log(" id->"+pharmaId);
    //io.emit("notification","new notification available");
    // console.log(pharmacyId);
    //console.log(pharmacySocket);

}

