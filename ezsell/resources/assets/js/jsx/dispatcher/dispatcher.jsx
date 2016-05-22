import Flux from 'flux';
import KeyMirror from 'keymirror';
import Events from 'events';
//
var Dispatcher = new Flux.Dispatcher();
//
class EventEmitter extends Events {}
Dispatcher.EventEmitter = new EventEmitter();
Dispatcher.EventEmitter.setMaxListeners(Infinity);
//
Dispatcher.Events = KeyMirror({
	UPDATE_APPLICATION: null,
	UPDATE_HOMEPAGE: null,
	UPDATE_CATITEMSPAGE: null,
	UPDATE_USERITEMSPAGE: null,
	UPDATE_ITEMDETAILSPAGE: null,
	UPDATE_LOGINPAGE: null,
	UPDATE_CHANGEACCOUNTPAGE: null,
	UPDATE_CHANGEEMAILPAGE: null,
	UPDATE_CHANGPASSWORDPAGE: null,
	UPDATE_SENDACTIVATIONPAGE: null,
	UPDATE_REGISTERPAGE: null,
	UPDATE_CHANGELOCATIONPAGE: null,
	UPDATE_DEACTIVATEPAGE: null,
	UPDATE_BUYITEMPAGE: null,
	UPDATE_SELLITEMPAGE: null,
	UPDATE_MESSAGE: null,
	
	SENT_MESSAGE: null,
	RECEIVED_MESSAGE: null,
	
	UPDATE_CATMENU: null,
	UPDATE_ITEM: null,
	UPDATE_USER: null,
	
	// MESSENGER EVENTS
	UPDATE_CHATBAR: null,
	UPDATE_CHATBOX: null,
	ADD_CHATBOX: null,
	SHOW_CHATBOX: null,
	REMOVE_CHATBOX: null,
	LOAD_RECENT_MESSAGES: null,
	LOAD_OLD_MESSAGES: null,
});

Dispatcher.Store = (function() {
	var _data = {
		application: null,
		catitems: null,
		useritems: null,
		itemdetails: null,
		lastUpdatedUser: '',
		lastMessage: '',
		chatusers: [],
		currentchatuser: null
	};
	function getChatUser(user_id) {
		if (_data.chatusers.length > 0) {
			for (var i=0; i < _data.chatusers.length; i++) {
				if (_data.chatusers[i].id == user_id) {
					return _data.chatusers[i];
				}
			}
		}
		return null;
	}
	function setChatUser(user_id, user) {
		if (_data.chatusers.length > 0) {
			for (var i=0; i < _data.chatusers.length; i++) {
				if (_data.chatusers[i].id == user_id) {
					_data.chatusers[i] = user;
					return;
				}
			}
		}
		_data.chatusers.push(user);
	}
	return {
		get: function(actionType) {
			switch(actionType) {
				case Dispatcher.Events.UPDATE_APPLICATION:
					return _data.application;
				case Dispatcher.Events.UPDATE_CATITEMSPAGE:
					return _data.catitems;;
				case Dispatcher.Events.UPDATE_USERITEMSPAGE:
					return _data.useritems;
				case Dispatcher.Events.UPDATE_ITEMDETAILSPAGE:
					return _data.itemdetails;
					break;
				case Dispatcher.Events.UPDATE_ITEM:
					var item_id = arguments[1];
					if (item_id) {
						if (_data.catitems) {
							for (var i=0; i < _data.catitems.paginate.data.length; i++) {
								if (_data.catitems.paginate.data[i].id == item_id) {
									return _data.catitems.paginate.data[i];
								}
							}
						}
						else if (_data.useritems) {
							for (var i=0; i < _data.useritems.paginate.data.length; i++) {
								if (_data.useritems.paginate.data[i].id == item_id) {
									return _data.useritems.paginate.data[i];
								}
							}
						}
						else if (_data.itemdetails) {
							return _data.itemdetails.itemdetails;
						}
					}
					return null;
				case Dispatcher.Events.UPDATE_USER:
					return _data.lastUpdatedUser;
				case Dispatcher.Events.UPDATE_CHATBOX:
				case Dispatcher.Events.SHOW_CHATBOX:
					return getChatUser(arguments[1]);
				case Dispatcher.Events.UPDATE_CHATBAR:
					return _data.chatusers;
			}
		},
		set: function(actionType,  data, params) {
			console.log('set', actionType, data);
			switch(actionType) {
				case Dispatcher.Events.UPDATE_APPLICATION:
					_data.application = data;
					if (_data.application.catitems) 
						_data.catitems = _data.application;
					else if (_data.application.useritems) 
						_data.useritems = _data.application;
					else if (_data.application.itemdetails) 
						_data.itemdetails = _data.application;
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.UPDATE_CATITEMSPAGE:
					_data.catitems = data;
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.UPDATE_USERITEMSPAGE:
					_data.useritems = data;
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.UPDATE_ITEMDETAILSPAGE:
					_data.itemdetails = data;
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.UPDATE_ITEM:
					if (data && data.id) {
						if (_data.catitems) {
							for (var i=0; i < _data.catitems.paginate.data.length; i++) {
								if (_data.catitems.paginate.data[i].id == data.id) {
									_data.catitems.paginate.data[i] = Object.assign(_data.catitems.paginate.data[i], data);
									break;
								}
							}
						}
						else if (_data.useritems) {
							for (var i=0; i < _data.useritems.paginate.data.length; i++) {
								if (_data.useritems.paginate.data[i].id == data.id) {
									_data.useritems.paginate.data[i] = Object.assign(_data.useritems.paginate.data[i], data);
									break;
								}
							}
						}
						else if (_data.itemdetails) {
							_data.itemdetails.itemdetails = data;
						}
					}
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.UPDATE_USER:
					_data.lastUpdatedUser = data;
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
				case Dispatcher.Events.SENT_MESSAGE:
					var receiver = data.receiver;
					if (receiver) {
						var chattingUser = getChatUser(receiver.id);
						if (chattingUser) {
							if (!chattingUser.messages)
								chattingUser.messages = [];
							chattingUser.messages.push(data);
							_data.currentchatuser = chattingUser;
							Dispatcher.dispatch({actionType: Dispatcher.Events.UPDATE_CHATBOX, data: _data.currentchatuser});
						}
					}
					break;
				case Dispatcher.Events.RECEIVED_MESSAGE:
					var sender = data.sender;
					if (sender) {
						var chattingUser = getChatUser(sender.id);
						if (chattingUser) {
							if (!chattingUser.messages)
								chattingUser.messages = [];
							chattingUser.messages.push(data);
							Dispatcher.dispatch({actionType: Dispatcher.Events.UPDATE_CHATBOX, data: chattingUser});
						}
						else {
							Dispatcher.emit(Dispatcher.Events.ADD_CHATBOX, sender);
						}
					}
					break;
				case Dispatcher.Events.ADD_CHATBOX:
					if (data && data.id && data.displayname) {
						var user = getChatUser(data.id);
						if (!user) {
							if (params[2])
								data.itemId = params[2];
							_data.chatusers.push(data);
							_data.currentchatuser = getChatUser(data.id);
							Dispatcher.emit(Dispatcher.Events.UPDATE_CHATBAR);
						}
						else {
							_data.currentchatuser = user;
							Dispatcher.dispatch({actionType: Dispatcher.Events.SHOW_CHATBOX, data: user});
						}
					}
					break;
				case Dispatcher.Events.LOAD_RECENT_MESSAGES:
					var owner = sessionManager.isLogged();
					if (owner && data && data.id && data.displayname) {
						ajax.post('/messages', function(response) {
							if (response.data) {
								data.messages = response.data.messages;
								data.paginate = response.data.paginate;
								Dispatcher.dispatch({actionType: Dispatcher.Events.UPDATE_CHATBOX, data: data});
							}
						}, {code: data.id});
					}
					break;
				case Dispatcher.Events.REMOVE_CHATBOX:
					if (data && data.id && data.displayname) {
						var index = _data.chatusers.indexOf(data);
						if (index >= 0) {
							_data.chatusers.splice(index, 1);
							Dispatcher.emit(Dispatcher.Events.UPDATE_CHATBAR);
						}
					}
					break;
				case Dispatcher.Events.UPDATE_CHATBAR:
					Dispatcher.dispatch({actionType: actionType, data: Dispatcher.Store.get(actionType)});
					break;
			}
			sessionManager.set('data', _data);
		}
	};
})();

Dispatcher.register(function(action) {
	Dispatcher.EventEmitter.emit(action.actionType, Dispatcher.Store.get(action.actionType));
});

Dispatcher.emit = function(actionType, data) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.Store.set(actionType, data, arguments);
	}
	else {
		throw('Dispatcher does not support this action ' + actionType);
	}
};

Dispatcher.addListener = function(actionType, callback) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.on(actionType, callback);
	}
	else {
		throw('Dispatcher does not support this action ' + actionType);
	}
};

Dispatcher.removeListener = function(actionType, callback) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.removeListener(actionType, callback);
	}
	else {
		throw('Dispatcher does not support this action ' + actionType);
	}
};

window.Dispatcher = Dispatcher;

export default window.Dispatcher;
