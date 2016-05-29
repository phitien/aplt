module.exports = window.createMixin = function(name, cpn) {
	var mixin = {};
	if (name && cpn) {
		var makeState = function(data) {
			var o = {};
			o[name] = data;
			return o
		};
		mixin.getInitialState = function() {
			return makeState(cpn.getState());
		};
	}
	return Object.assign(mixin, {
		className : function(defaultClassName, prefix, subfix) {
			return (prefix ? prefix : '')
					+ ' '
					+ this.attr('className',
							defaultClassName ? defaultClassName : '') + ' '
					+ (subfix ? subfix : '');
		},
		attr : function(name, defaultValue) {
			return attr.bind(this.props)(name, defaultValue)
		},
		getId : function(prefix) {
			return this.id ? this.id : attr.bind(this.props)
					('id', uuid(prefix));
		},
		getRootDom : function() {
			return ReactDOM.findDOMNode(this);
		},
		isCurrentUser : function(_user) {
			var user = appManager.isLogged();
			if (user && user.id == _user.id) {
				return true;
			}
			return false;
		},
		isFollowingTo : function(_user) {
			var user = appManager.isLogged();
			if (user) {
				return user.following.indexOf(_user.id) >= 0;
			}
			return false;
		},
		isFollowerOf : function(_user) {
			var user = appManager.isLogged();
			if (user) {
				return user.followers.indexOf(_user.id) >= 0;
			}
			return false;
		},
		onOpenLink() {
			if (this.href)
				applicationSwitch(this.href);
		},
	});
};
