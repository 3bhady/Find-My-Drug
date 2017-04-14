
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var users=[];

server.listen(8890);
io.on('connection', function (socket) {

    console.log("new client connected");
    users.push(socket.id);
    console.log(socket.id);
    var redisClient = redis.createClient();

      redisClient.subscribe('message');
    console.log("ok iam ali ");
    redisClient.on("message", function(channel, message) {
        console.log("mew message in queue "+ channel + "channel");
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
        console.log("new client disconnected");
    });

});