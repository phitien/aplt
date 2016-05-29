var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var EVN = process.env;

var port = 8890;// EVN.SOCKET_IO_PORT;
server.listen(port);
console.log("server is running on port " + port);

var users = {};
function removeUser(socket) {
	for ( var k in users) {
		if (users[k].id == socket.id) {
			delete users[k];
			return;
		}
	}
}

io.on('connection', function(socket) {
	console.log("new client connected: ", socket.id);

	var clientKey = '';

	socket.on('join',
			function(clientKey) {
				console.log("new user joined: ", clientKey, ", socket.id: ",
						socket.id);
				users[clientKey] = socket;
				socket.emit('accepted', socket.id);
			});

	socket.on('disconnect', function() {
		if (clientKey) {
			delete users[clientKey];
		}
		// redisClient.quit();
		console.log("client disconnected: ", clientKey);
	});

});

var redisClient = redis.createClient();
redisClient.subscribe('message');
redisClient.on("message", function(channel, jsonStr) {
	if (channel == 'message') {
		var data = JSON.parse(jsonStr);
		if (data) {
			console.log("message from: ", data.from, ", to: ", data.to);
			if (users.hasOwnProperty(data.to)) {
				users[data.to].emit('message', JSON.stringify({
					'sender' : data.sender,
					'message' : data.message,
					'created_at' : data.created_at,
					'status' : data.status
				}));
			}
		}
	}
});
