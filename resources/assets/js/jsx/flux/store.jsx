/**
 * @class Store
 */
module.exports = window.Store = function() {
	return {
		has : function(name) {
			return localStorage.hasOwnProperty(name);
		},
		get : function(name, defaultValue) {
			if (this.has(name))
				return JSON.parse(localStorage.getItem(name));
			return defaultValue;
		},
		set : function(name, value) {
			localStorage.setItem(name, JSON.stringify(value));
			return this;
		},
		assign : function(name, value) {
			this.set(name, Object.assign(this.get(name, {}), value));
			return this;
		},
		remove : function(name) {
			localStorage.removeItem(name);
			return this;
		}
	};
};
