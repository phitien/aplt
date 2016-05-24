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
Dispatcher.register(function(action) {
	Dispatcher.EventEmitter.emit(action.actionType, appStore.get(action.actionType));
});

Dispatcher.addListener = function(actionType, callback) {
	if (AppEvents.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.on(actionType, callback);
	}
	else {
		throw('Dispatcher does not support this action ' + actionType);
	}
};

Dispatcher.removeListener = function(actionType, callback) {
	if (AppEvents.hasOwnProperty(actionType)) {
		return Dispatcher.EventEmitter.removeListener(actionType, callback);
	}
	else {
		throw('Dispatcher does not support this action ' + actionType);
	}
};

module.exports = window.Dispatcher = Dispatcher;