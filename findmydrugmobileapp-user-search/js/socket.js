function setupSocket(){
    var socket = io.connect('http://localhost:8890');
    socket.on('connect',function(){
        //adding socketId to user
        console.log(socket.io.engine.id);
        socketId=socket.io.engine.id;
        user=getData("customer");
        console.log(user);
        userModified=JSON.parse(user);
        userModified.socket_id=socketId;
        setData("customer",JSON.stringify(userModified));
        console.log("customer------>",getData("customer"));
        socket.emit("addCustomer",JSON.parse(getData("customer")));
    });


};

