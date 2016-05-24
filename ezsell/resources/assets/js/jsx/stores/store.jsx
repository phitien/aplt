/**
 * @class Store
 */
module.exports = window.Store = function() {
	var _data = {};
	return {
		has : function(name) {
			return _data.hasOwnProperty(name);
		},
		get : function(name, defaultValue) {
			if (this.has(name))
				return _data[name];
			return defaultValue;
		},
		set : function(name, value) {
			_data[name] = value;
			return this;
		},
		assign : function(name, value) {
			if (this.has(name))
				Object.assign(_data[name], value);
			else
				_data[name] = Object.assign({}, value);
			return this;
		},
		remove : function(name) {
			if (this.has(name))
				delete _data[name];
			return this;
		}
	};
};
