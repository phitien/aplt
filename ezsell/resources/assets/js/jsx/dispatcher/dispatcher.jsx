import Flux from 'flux';
import KeyMirror from 'keymirror';
import Events from 'events';
//
class EventEmitter extends Events {}
var eventEmitter = new EventEmitter();
eventEmitter.setMaxListeners(Infinity);
//
var Dispatcher = new Flux.Dispatcher();
Dispatcher.events = {
	APPL_EVENT: 'applevent',
	LIST_EVENT: 'listevent',
	LISTITEM_EVENT: 'listitemevent',
	ITEM_EVENT: 'listitemevent',
	USER_EVENT: 'userevent'
};

Dispatcher.register(function(action) {
	console.log(action.actionType);
	switch (action.actionType) {
		case Constants.CATITEMS:
		case Constants.USERITEMS:
		case Constants.ITEMDETAILS:
			eventEmitter.emit(Dispatcher.events.APPL_EVENT);
			break;
		
		case Constants.ITEMUPDATE:
			eventEmitter.emit(Dispatcher.events.LISTITEM_EVENT);
			break;
	}
	//eventEmitter.emit(Dispatcher.events.LIST_EVENT);
	//eventEmitter.emit(Dispatcher.events.USER_EVENT);
});
//
var Constants = KeyMirror({
	CATITEMS: null,
	USERITEMS: null,
	ITEMDETAILS: null,
	ITEMUPDATE: null
});
var Actions = {
	catitems: function(_data) {
		Dispatcher.dispatch({
			actionType: Constants.CATITEMS,
			data: _data
		});
	},
	useritems: function(_data) {
		Dispatcher.dispatch({
			actionType: Constants.USERITEMS,
			data: _data
		});
	},
	itemdetails: function(_data) {
		Dispatcher.dispatch({
			actionType: Constants.ITEMDETAILS,
			data: _data
		});
	},
	itemupdate: function(_data) {
		Dispatcher.dispatch({
			actionType: Constants.ITEMUPDATE,
			data: _data
		});
	}
};
var _list = null;
var _details = null;

if (sessionManager.isListPage()) 
	_list = sessionManager.get('data');
else
	_details = sessionManager.get('data');

Dispatcher.Constants = Constants;
Dispatcher.Actions = Actions;
Dispatcher.EventEmitter = eventEmitter;

Dispatcher.item = function(id) {
	if (_details) 
		return _details.itemdetails;
	if (_list)
		for (var i=0; i < _list.paginate.data.length; i++) 
			if (_list.paginate.data[i].id == id) 
				return _list.paginate.data[i];
	return null;
};
Dispatcher.list = function() {return _list;};
Dispatcher.details = function() {return _details;};

Dispatcher.emit = function(event, _data) {
	switch (event) {
		case this.events.APPL_EVENT:
		case this.events.LIST_EVENT:
			if (_data.catitems || _data.useritems) {//for the lists
				_list = _data;
				sessionManager.set('data', _list);
				if (_list.catitems) {
					Actions.catitems(_list);
				}
				else if (_list.useritems) {
					Actions.useritems(_list);
				}
			}
			else if (_data.itemdetails) {//for the detail page
				_details = Object.assign({}, _data);
				sessionManager.set('data', _details);
				Actions.itemdetails(_details);
			}
			break;

		case this.events.LISTITEM_EVENT:
			if (_data.id) {
				for (var i=0; i < _list.paginate.data.length; i++) {
					if (_list.paginate.data[i].id == _data.id) {
						_list.paginate.data[i] = Object.assign(_list.paginate.data[i], _data);
						sessionManager.set('data', _list);
						Actions.itemupdate(_list.paginate.data[i]);
						break;
					}
				}
			}
			break;
	}
};

window.Dispatcher = Dispatcher;

export default window.Dispatcher;
