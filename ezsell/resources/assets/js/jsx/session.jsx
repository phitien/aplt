/**
 * Session manager
 */
Object.assign(window, {
	sessionManager: (function() {
		var me = this;
		var _data = {};
		return {
			location() {
				return _data.location;
			},
			cats() {
				return _data.cats;
			},
			user() {
				return JSON.parse($.base64.decode(_data.user));
			},
			rawdata() {
				return _data.rawdata;
			},
			getCurrentPage() {
				return _data.page;
			},
			isLogged() {
				if (!this.get('isGuest', true))
					return this.get('user');
				return false;
			},
			isListPage() {
				if (this.has('rawdata'))
					return this.get('rawdata').paginate;
				return false;
			},
			has(name) {return _data.hasOwnProperty(name);},
			get(name, defaultValue) {
				if (this.has(name))
					return _data[name];
				return defaultValue;
			},
			set(name, value) {_data[name] = value;return this;},
			assign(name, value) {
				if (this.has(name))
					Object.assign(_data[name], value);
				else
					_data[name] = Object.assign({}, value);
				return this;
			},
			remove(name) {
				if (this.has(name))
					delete _data[name];
				return this;
			}
		};
	})()
});
