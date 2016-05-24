/**
 * @variable appStore
 */
module.exports = window.appStore = new Store();
//
Object.assign(appStore, {
	chatusers : function() {
		return this.get('chatusers');
	},
	chatuser : function(id) {
		var chatusers = this.get('chatusers');
		if (id && chatusers.length > 0) {
			for (var i = 0; i < chatusers.length; i++) {
				if (chatusers[i].id == id) {
					return chatusers[i];
				}
			}
		}
		return null;
	},
	currentChatuser : function(val) {
		if (val)
			this.set('currentChatuser', val);
		return this.get('currentChatuser');
	},
	upsertChatuser : function(user) {
		var chatusers = this.get('chatusers');
		if (user && chatusers.length > 0) {
			for (var i = 0; i < chatusers.length; i++) {
				if (chatusers[i].id == user.id) {
					return Object.assign(chatusers[i], user);
				}
			}
			chatusers.push(user);
			return chatusers[chatusers.length - 1];
		}
		return null;
	},
	messages : function(id, origin, newer, older) {
		var messages = this.get('messages');
		if (!messages)
			this.set('messages', message = {});
		var usermessages = attr.bind(messages)(id);
		if (!usermessages)
			messages[id] = usermessages = [];
		if (origin)
			usermessages = origin;
		else if (newer)
			usermessages.push(newer);
		else if (newer)
			usermessages = older.concat(usermessages);
		return usermessages;
	},
	addMessage : function(data) {
	},
	addNotification : function(data) {
	},
	currentUrl : function(val) {
		if (!val) {
			this.set('currentUrl', val);
		}
		return this.get('currentUrl');
	},
	currentPage : function(val) {
		if (!val) {
			this.set('currentPage', val);
		}
		return this.get('currentPage');
	}
});