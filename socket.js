
app = require('express')();
server = require('http').Server(app);
io = require('socket.io')(server);
redis = require('redis');
request=require('request');

//online users and pharmacies
user=[];
//holding key as socket

customerSocket={valid_key:  undefined};
//holding id as key
customerId={valid_key:  undefined};
//holding key as socket

pharmacySocket={valid_key:  undefined};
//holding id as key
pharmacyId={valid_key:  undefined};


server.listen(8890);
io.on('connection', function (socket) {

    socket.on('addCustomer',function(data){
        console.log("new customer"+data);
        customerSocket[data.socket_id]=data;
        customerId[data.id]=data;
        console.log(customerSocket);
        console.log(customerId);
        }
    );
   

    // console.log(socket.id);
//init redis
    redisClient = redis.createClient();

    redisClient.subscribe('message');
    redisClient.subscribe('notification');
    redisClient.subscribe('addPharmacy');
    redisClient.subscribe('pharmacyToCustomerResponse');


    socket.on('disconnect', function() {
        if(customerSocket.hasOwnProperty(socket.id))
        {
            console.log("customer disconnected");
             CustomerId=(customerSocket[socket.id]).id;
            delete   customerSocket[socket.id];
            delete   customerId[CustomerId];
            console.log(customerSocket);
            console.log(customerId);
            return;
        }

        var json = {
            "user":pharmacySocket[socket.id]
        };
        var options = {
            url: 'http://Localhost/Find-My-Drug/public/api/v1/setoffline?token='+
        //    url: 'http://192.168.1.7/public/api/v1/setoffline?token='+
            pharmacySocket[socket.id].token,
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            json: json
        };
        request(options, function(err, res, body) {
            if (res && (res.statusCode === 200 || res.statusCode === 201)) {
                console.log(body);
            }
            else {
                console.log(err);
                console.log(res.body);
            }
        });
        //io.emit("goOffline","new notification available..");

        pharmaId=(pharmacySocket[socket.id]).id;
        delete   pharmacySocket[socket.id];
        delete   pharmacyId[pharmaId];

        redisClient.quit();
    });


});


redisClient = redis.createClient();

redisClient.subscribe('message');
redisClient.subscribe('notification');
redisClient.subscribe('addPharmacy');
redisClient.subscribe('pharmacyToCustomerResponse');


redisClient.on("message", function(channel, message) {
    //console.log("new message in queue "+ channel + "channel");
    //console.log(message);
    // console.log("new request sent");
    message=JSON.parse(message);
    console.log(channel);
    if(channel=="pharmacyToCustomerResponse"){
        console.log("pharmacy customer response");
        pharmacyToCustomerResponse(message);
    }
    if(channel=="addPharmacy"){
        addPharmacy(message);
    }
    if(channel=="notification"){

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
  //  console.log(" new user added with socket->"+pharmacySocketId);
   // console.log(" id->"+pharmaId);
    //io.emit("notification","new notification available");
    // console.log(pharmacyId);
    //console.log(pharmacySocket);

}
function pharmacyToCustomerResponse(data)
{
    //sending request back to customer
    console.log("data sent "+data.user_id);
    var CustomerSocketId=customerId[data.user_id].socket_id;
    dataToSend={
        "pharmacy_id":data.pharmacy.id,
        "pharmacy_name":data.pharmacy.name,
        "drug_id":data.drug_id,
        "drug_name":data.drug_name,
        "user_id":data.user_id
    };
    console.log(dataToSend);
    if(CustomerSocketId!=null) {
        if(CustomerSocketId!=undefined)
        io.to(CustomerSocketId).emit("pharmacyResponse", dataToSend);
    }
}

