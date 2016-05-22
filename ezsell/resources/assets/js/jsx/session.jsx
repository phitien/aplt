/**
 * Session manager
 */
Object.assign(window, {
	sessionManager : (function() {
		var me = this;
		var _data = {};
		return {
			appMessage : function() {
				return _data.appMessage;
			},
			location : function() {
				return _data.location;
			},
			cats : function() {
				return _data.cats;
			},
			user : function() {
				return JSON.parse($.base64.decode(_data.user));
			},
			rawdata : function() {
				return _data.rawdata;
			},
			getCurrentPage : function() {
				return _data.page;
			},
			isLogged : function() {
				if (!this.get('isGuest', true))
					return this.user();
				return false;
			},
			isListPage : function() {
				if (this.has('rawdata'))
					return this.get('rawdata').paginate;
				return false;
			},
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
	})()
});
