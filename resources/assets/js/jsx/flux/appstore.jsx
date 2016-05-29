/**
 * @variable appStore
 */
module.exports = window.appStore = new Store();
//
Object.assign(appStore, {
	chatusers : function() {
		var chatusers = this.get('chatusers');
		if (!chatusers) {
			this.set('chatusers', chatusers = []);
		}
		return chatusers;
	},
	currentChatuser : function(val) {
		if (val) {
			this.set('currentChatuser', val);
			Dispatcher.dispatch(new Action(AppEvents.CURRENTCHATUSER_UPDATE,
					chatusers));
		}
		return this.get('currentChatuser');
	},
	chatuser : function(id, val) {
		var chatusers = this.chatusers();
		if (id && chatusers) {
			for (var i = 0; i < chatusers.length; i++) {
				if (chatusers[i].id == id) {
					var user = chatusers[i];
					if (val) {
						Object.assign(user, val);
						Dispatcher.dispatch(new Action(AppEvents.CHATUSER_UPDATE, user));
					}
					return user;
				}
			}
			if (val) {
				chatusers.push(val);
				var user = chatusers[chatusers.length - 1];
				Dispatcher.dispatch(new Action(AppEvents.CHATUSERS_UPDATE, user));
				//load user messages
				ajax.post('/messages', function(response) {
					if (response.data && response.data.messages) {
						appStore.messages(user.id, response.data);
					}
				}, {
					'id' : user.id
				});
				return user;
			}
		}
		return null;
	},
	removechatuser : function(id) {
		var chatusers = this.chatusers();
		if (id && chatusers) {
			for (var i = 0; i < chatusers.length; i++) {
				if (chatusers[i].id == id) {
					var allmessages = this.get('messages');
					var usermessages = allmessages[id];
					delete allmessages[id];
					var user = chatusers.splice(i, 1);
					Dispatcher.dispatch(new Action(AppEvents.CHATUSERS_UPDATE, user));
					return {'user': user, 'messages': usermessages};
				}
			}
		}
		return null;
	},
	messages : function(id, origin, newer, older) {
		if (newer && newer.sender) {
			var user = this.chatuser(newer.sender.id);
			if (!user) {
				this.chatuser(newer.sender.id, newer.sender);
				return;
			}
		}
		var field = '+' + id;
		var allmessages = this.get('messages');
		if (!allmessages)
			this.set('messages', allmessages = {});
		var usermessages = attr.bind(allmessages)(field);
		if (!usermessages)
			allmessages[field] = usermessages = {};
		if (origin) {
			allmessages[field] = usermessages = origin;
			Dispatcher.dispatch(new Action(AppEvents.USERMESSAGES_LOADED, usermessages.messages));
		}
		else if (newer) {
			if (!usermessages.messages)
				usermessages.messages = [];
			usermessages.messages.push(newer);
			Dispatcher.dispatch(new Action(AppEvents.USERMESSAGES_ADDED_NEW, usermessages.messages));
		}
		else if (older) {
			if (!usermessages.messages)
				usermessages.messages = [];
			usermessages.messages = older.concat(usermessages.messages);
			Dispatcher.dispatch(new Action(AppEvents.USERMESSAGES_ADDED_OLD, usermessages.messages));
		}
		return attr.bind(usermessages)('messages', []);
	},
	addMessage : function(id, val) {
		return this.messages(id, null, val);
	},
	addNotification : function(val) {
	}
});