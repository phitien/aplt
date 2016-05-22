/**
 * Util
 */
Object.assign(window, {
	l : function(o, o2, o3, o4, o5, o6) {
		console.log(o, o2, o3, o4, o5, o6, arguments);
	},
	util : {
		clientIP : null,
		uuid : function(prefix) {
			return (prefix ? prefix : '') + Date.now().toString(36)
					+ Math.random().toString(36).substr(2, 9);
		},
		ip : function() {
			return this.clientIP;
		},
		getAttr : function(name, defaultValue) {
			if (this.hasOwnProperty(name))
				return this[name];
			return defaultValue;
		},
		getClassName : function(o, defaultValue) {
			if (o.hasOwnProperty('className'))
				return o['className'];
			return defaultValue ? defaultValue : '';
		}
	},
	engine : (function() {
		$.getJSON('//ip-api.com/json?callback=?', function(data) {
			util.clientIP = data.query;
		});
	})(),
	token : function() {
		return $('meta[name="csrf-token"]').attr('content');
	},
	format : {
		currency : function(v) {
			var n = parseFloat(v) != NaN ? parseFloat(v) : 0;
			return n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		},
		time : function(v, format) {
			return $.format.date(v, sessionManager.location().timeformat);
		},
		date : function(v, format) {
			return $.format.date(v, format ? format
					: sessionManager.location().dateformat);
		},
		datetime : function(v, format) {
			return $.format.date(v, format ? format
					: sessionManager.location().datetimeformat);
		},
		prettyDate : function(v) {
			return $.format.prettyDate(v);
		}
	},
	ajax : {
		exe : function(url, success, data, type) {
			$.ajax({
				type : type ? type : 'GET',
				url : url,
				data : Object.assign({
					'_token' : token(),
					'mode' : getMode()
				}, data),
				success : success
			});
		},
		get : function(url, success, data) {
			this.exe(url, success, data, 'GET');
		},
		post : function(url, success, data) {
			this.exe(url, success, data, 'POST');
		},
		put : function(url, success, data) {
			this.exe(url, success, data, 'PUT');
		},
		del : function(url, success, data) {
			this.exe(url, success, data, 'DELETE');
		}
	}
});
