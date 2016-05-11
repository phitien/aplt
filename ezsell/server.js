var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

var port = 8890;
console.log("port " + port);
server.listen(port );
io.on('connection', function(socket) {

	console.log("new client connected");
	var redisClient = redis.createClient();
	redisClient.subscribe('message');

	redisClient.on("message", function(channel, message) {
		console.log("mew message in queue " + message + "channel");
		socket.emit(channel, message);
	});

	socket.on('disconnect', function() {
		redisClient.quit();
	});

});