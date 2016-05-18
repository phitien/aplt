import Flux from 'flux';
import KeyMirror from 'keymirror';
import Events from 'events';
//
class EventEmitter extends Events {}
var eventEmitter = new EventEmitter();
var CHANGE_EVENT = 'datachange';
var LIST_CHANGE = 'listchange';
//
var Dispatcher = new Flux.Dispatcher();
Dispatcher.register(function(action) {
	console.log(action);
	eventEmitter.emit(CHANGE_EVENT);
	eventEmitter.emit(LIST_CHANGE);
});
//
var Constants = KeyMirror({
	CATITEMS: null,
	USERITEMS: null,
	ITEMDETAILS: null
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
	}
};
Dispatcher.Constants = Constants;
Dispatcher.Actions = Actions;
Dispatcher.EventEmitter = eventEmitter;
Dispatcher.emit = function(_data) {
	window.data = Object.assign({}, data, _data);
	if (data) {
		if (data.catitems) {
			Actions.catitems(data);
		}
		else if (data.useritems) {
			Actions.useritems(data);
		}
		else if (data.itemdetails) {
			Actions.itemdetails(data);
		}
	}
};
Dispatcher.CHANGE_EVENT = CHANGE_EVENT;
Dispatcher.LIST_CHANGE = LIST_CHANGE;

export default Dispatcher;
