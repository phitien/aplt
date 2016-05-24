/**
 * @class AppManager
 */
/**
 * @variable appManager
 */
module.exports = window.appManager = new Store();
//
Object.assign(appManager, {
	socketId : function(val) {
		if (val)
			this.set('socketId', val);
		return this.get('socketId');
	},
	clientKey : function() {
		return this.user().id + '+' + location.hostname;
	},
	showLeft : function(val) {
		if (val)
			this.set('showLeft', parseInt(val));
		return this.get('showLeft', 0);
	},
	showRight : function(val) {
		if (val)
			this.set('showRight', parseInt(val));
		return this.get('showRight', 0);
	},
	showBanner : function(val) {
		if (val)
			this.set('showBanner', parseInt(val));
		return this.get('showBanner', 0);
	},
	mode : function(val) {
		if (val)
			this.set('mode', val);
		return this.get('mode');
	},
	appMessage : function(val) {
		if (val)
			this.set('appMessage', val);
		return this.get('appMessage');
	},
	location : function(val) {
		if (val)
			this.set('location', val);
		return this.get('location');
	},
	cats : function(val) {
		if (val)
			this.set('cats', val);
		return this.get('cats');
	},
	isGuest : function(val) {
		if (val)
			this.set('isGuest', parseInt(val));
		return this.get('isGuest', true);
	},
	isLogged : function() {
		if (!this.isGuest())
			return this.user();
		return false;
	},
	user : function(val) {
		if (val) {
			this.set('user', JSON.parse($.base64.decode(val)));
		}
		return this.get('user');
	},
	socketUri : function(val) {
		if (val)
			this.set('socketUri', val);
		return this.get('socketUri');
	},
	type : function(val) {
		if (val)
			this.set('type', val);
		return this.get('type', 'HomePage');
	},
	data : function(val) {
		if (val)
			this.set('data', val);
		return this.get('data');
	},
	paginate : function(val) {
		if (val)
			this.set('paginate', val);
		return this.get('paginate');
	},
	configurations : function(configurations) {
		for ( var k in configurations) {
			try {
				this[k](configurations[k]);
			} catch (e) {
				this.set(k, configurations[k]);
			}
		}
	}
});
