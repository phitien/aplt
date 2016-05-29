/**
 * @class AppSocket
 */
module.exports = window.AppSocket = function(uri, clientKey, options) {
	this.setParams(uri, clientKey, options);
};

Object.assign(window.AppSocket.prototype, {
	init : function() {
		if (!this.socket) {
			var me = this;
			this.socket = io.connect(this.uri, this.options);
			this.socket.on('connect', function() {
				if (appManager.isLogged()) {
					me.socket.emit('join', me.clientKey);
				}
			});
			this.socket.on('accepted', function(socketId) {
				appManager.socketId(socketId);
			});
			this.socket.on('message', function(data) {
				var response = JSON.parse(data);
				appStore.addMessage(response.sender.id, response);
			});
			this.socket.on('notification', function(data) {
				appStore.addNotification(JSON.parse(data));
			});
			this.socket.on('disconnect', function() {
				console.log('disconnected');
			});
		}
	},
	setParams : function(uri, clientKey, options) {
		if (uri && clientKey) {
			this.uri = uri;
			this.clientKey = clientKey;
			this.options = options;
			this.init();
		}
	}
});
