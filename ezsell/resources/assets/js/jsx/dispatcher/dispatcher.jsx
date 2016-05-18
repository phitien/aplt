import Flux from 'flux';
import KeyMirror from 'keymirror';
import Events from 'events';
//
class EventEmitter extends Events {}
var eventEmitter = new EventEmitter();
var EVENT = 'listchange';
//
var Dispatcher = new Flux.Dispatcher();
Dispatcher.register(function(action) {
	eventEmitter.emit(EVENT);
});
//
var Constants = KeyMirror({
	CATITEMS: null,
	USERITEMS: null,
	ITEMDETAILS: null,
	ITEMUPDATE: null
});
var Actions = {
	catitems: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.CATITEMS,
			data: data
		});
	},
	useritems: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.USERITEMS,
			data: data
		});
	},
	itemdetails: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.ITEMDETAILS,
			data: data
		});
	},
	itemupdate: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.ITEMUPDATE,
			data: data
		});
	}
};
var _item = null;
var _list = window.data ? window.data : null;

Dispatcher.Constants = Constants;
Dispatcher.Actions = Actions;
Dispatcher.EventEmitter = eventEmitter;
Dispatcher.item = function() {return _item;};
Dispatcher.list = function() {return _list;};
Dispatcher.emit = function(_data) {
	if (_data.catitems || _data.useritems || _data.itemdetails) {
		_list = Object.assign({}, _list, _data);
		if (data.catitems) {
			Actions.catitems(_list);
		}
		else if (data.useritems) {
			Actions.useritems(_list);
		}
		else if (data.itemdetails) {
			Actions.itemdetails(_list);
		}
	}
	else {
		_item = _data;
		Actions.itemupdate(_item);
	}
};
Dispatcher.EVENT = EVENT;

export default Dispatcher;
