/**
 * Util
 */
Object.assign(window, {
	l(o, o2, o3, o4, o5, o6){
		console.log(o, o2, o3, o4, o5, o6, arguments);
	},
	util: {
		clientIP: null,
		uuid (prefix) {return (prefix ? prefix : '') + Date.now().toString(36) + Math.random().toString(36).substr(2, 9);},
		ip() {return this.clientIP;},
		getAttr(name, defaultValue) {
			if (this.hasOwnProperty(name))
				return this[name];
			return defaultValue;
		},
		getClassName(o, defaultValue) {
			if (o.hasOwnProperty('className'))
				return o['className'];
			return defaultValue ? defaultValue : '';
		}
	},
	engine: (function() {
		$.getJSON('//ip-api.com/json?callback=?', function(data) {
			util.clientIP = data.query;
		});
	})(),
	token() {return $('meta[name="csrf-token"]').attr('content');},
	format: {
		currency (v) {
			var n = parseFloat(v) != NaN ? parseFloat(v) : 0; 
			return n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		},
		time (v, format) {return $.format.date(v, sessionManager.location().timeformat);},
		date (v, format) {return $.format.date(v, format ? format : sessionManager.location().dateformat);},
		datetime (v, format) {return $.format.date(v, format ? format : sessionManager.location().datetimeformat);},
		prettyDate (v) {return $.format.prettyDate(v);}
	},
	ajax: {
		exe(url, success, data, type) {
			$.ajax({
				type: type ? type : 'GET',
				url: url,
				data: Object.assign({'_token': token(), 'mode': getMode()}, data),
				success: success
			});
		},
		get(url, success, data) {this.exe(url, success, data, 'GET');},
		post(url, success, data) {this.exe(url, success, data, 'POST');},
		put(url, success, data) {this.exe(url, success, data, 'PUT');},
		delete(url, success, data) {this.exe(url, success, data, 'DELETE');}  
	}
});
