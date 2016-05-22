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
	UPDATE_SENDACTIVATIONPAGE: null,
	UPDATE_REGISTERPAGE: null,
	UPDATE_CHANGELOCATIONPAGE: null,
	
	UPDATE_ITEM: null,
	UPDATE_USER: null,
	UPDATE_MESSAGE: null,
	UPDATE_CHATBOX: null,
	UPDATE_CHATBAR: null,
	ADD_CHATBOX: null,
});

Dispatcher.Store = (function() {
	var _data = {
		application: null,
		catitems: null,
		useritems: null,
		itemdetails: null,
		lastUpdatedUser: '',
		lastMessage: '',
		chatusers: []
	};
	function getChatUser(user_id) {
		for (var i=0; i < _data.chatusers.length; i++) {
			if (_data.chatusers[i].id == user_id) {
				return _data.chatusers[i];
			}
		}
		return null;
	}
	function setChatUser(user_id, user) {
		for (var i=0; i < _data.chatusers.length; i++) {
			if (_data.chatusers[i].id == user_id) {
				_data.chatusers[i] = user;
				break;
			}
		}
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
				case Dispatcher.Events.UPDATE_MESSAGE:
					return _data.lastMessage;
				case Dispatcher.Events.UPDATE_CHATBOX:
					return getChatUser(arguments[1]);
				case Dispatcher.Events.ADD_CHATBOX:
				case Dispatcher.Events.UPDATE_CHATBAR:
					return _data.chatusers;
			}
		},
		set: function(actionType,  data) {
			switch(actionType) {
				case Dispatcher.Events.UPDATE_APPLICATION:
					_data.application = data;
					if (_data.application.catitems) 
						_data.catitems = _data.application;
					else if (_data.application.useritems) 
						_data.useritems = _data.application;
					else if (_data.application.itemdetails) 
						_data.itemdetails = _data.application;
					break;
				case Dispatcher.Events.UPDATE_CATITEMSPAGE:
					_data.catitems = data;
					break;
				case Dispatcher.Events.UPDATE_USERITEMSPAGE:
					_data.useritems = data;
					break;
				case Dispatcher.Events.UPDATE_ITEMDETAILSPAGE:
					_data.itemdetails = data;
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
					break;
				case Dispatcher.Events.UPDATE_USER:
					_data.lastUpdatedUser = data;
					break;
				case Dispatcher.Events.UPDATE_MESSAGE:
					var json = JSON.parse(data);
					if (json && json.user) {
						_data.lastMessage = json;
						var user = getChatUser(json.user.id);
						if (!user && !isCurrentUser(json.user)) {
							Dispatcher.emit(Dispatcher.Events.ADD_CHATBOX, json.user);
						}
					}
					break;
				case Dispatcher.Events.ADD_CHATBOX:
					if (data && data.id && data.displayname && _data.chatusers.indexOf(data) < 0) {
						var user = getChatUser(data.id);
						if (!user)
							_data.chatusers.push(data);
					}
					actionType = Dispatcher.Events.UPDATE_CHATBAR;
					break;
			}
			sessionManager.set('data', _data);
			Dispatcher.dispatch({
				actionType: actionType,
				data: Dispatcher.Store.get(actionType)
			});
		}
	};
})();

Dispatcher.register(function(action) {
	//console.log(action.actionType, Dispatcher.Store.get(action.actionType));
	Dispatcher.EventEmitter.emit(action.actionType, Dispatcher.Store.get(action.actionType));
});

Dispatcher.emit = function(actionType, _data) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.Store.set(actionType, _data);
	}
	else {
		console.log('Dispatcher does not support this action ' + actionType);
	}
};

Dispatcher.addListener = function(actionType, callback) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.on(actionType, callback);
	}
	else {
		console.log('Dispatcher does not support this action ' + actionType);
	}
};

Dispatcher.removeListener = function(actionType, callback) {
	if (Dispatcher.Events.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.removeListener(actionType, callback);
	}
	else {
		console.log('Dispatcher does not support this action ' + actionType);
	}
};

window.Dispatcher = Dispatcher;

export default window.Dispatcher;
