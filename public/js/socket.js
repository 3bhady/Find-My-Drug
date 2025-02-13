var app = require('express')();
var server = require('http').Server();
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('clicked-cell-channel', function(err, count) {
});
redis.on('message', function(channel, message) {
    console.log(channel, message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
server.listen(8081, function(){
    console.log('Listening on Port 8081');
});