import Dispatcher from '../dispatcher/dispatcher.jsx';
import Constants from '../constants/constants.jsx';

var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var CHANGE_EVENT = 'change';
var _data = {};
//
var Store = assign({}, EventEmitter.prototype, {
	getAll: function() {
		return _data;
	},
	emitChange: function() {
		this.emit(CHANGE_EVENT);
	},
	addChangeListener: function(callback) {
		this.on(CHANGE_EVENT, callback);
	},
	removeChangeListener: function(callback) {
		this.removeListener(CHANGE_EVENT, callback);
	}
});
//
// Register callback to handle all updates
Dispatcher.register(function(action) {
	_data = assign({}, _data, action.data);
	Store.emitChange();
});

export default Store;