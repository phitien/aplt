/**
 * Util
 */
Object.assign(window, {
	l : function(o, o2, o3, o4, o5, o6) {
		console.log(o, o2, o3, o4, o5, o6, arguments);
	},
	uuid : function(prefix) {
		return (prefix ? prefix : '') + Date.now().toString(36)
				+ Math.random().toString(36).substr(2, 9);
	},
	attr : function(name, defaultValue) {
		if (this.hasOwnProperty(name))
			return this[name];
		return defaultValue;
	},
	token : function() {
		return $('meta[name="csrf-token"]').attr('content');
	},
	format : {
		currency : function(v) {
			var n = parseFloat(v) != NaN ? parseFloat(v) : 0;
			return n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		},
		time : function(v, format) {
			return $.format.date(v, appManager.location().timeformat);
		},
		date : function(v, format) {
			return $.format.date(v, format ? format
					: appManager.location().dateformat);
		},
		datetime : function(v, format) {
			return $.format.date(v, format ? format
					: appManager.location().datetimeformat);
		},
		prettyDate : function(v) {
			return $.format.prettyDate(v);
		}
	},
	ajax : {
		exe : function(url, callback, data, type) {
			$.ajax({
				type : type ? type : 'GET',
				url : url,
				data : Object.assign({
					'_token' : token(),
					'mode' : mode()
				}, data),
				xhrFields: {
				    withCredentials: true
				},
				success : callback,
			}).fail(callback);
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
	},
	ArrayToObject : function(arr) {
		var o = {};
		for (var i = 0; i < arr.length; i++) {
			o[arr[i]] = arr[i];
		}
		return o;
	},
});
