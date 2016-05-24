module.exports = window.Mixin = {
	className : function(defaultClassName, prefix, subfix) {
		return (prefix ? prefix : '') + ' ' + this.attr('className', defaultClassName ? defaultClassName : '')
				+ ' ' + (subfix ? subfix : '');
	},
	attr : function(name, defaultValue) {
		return attr.bind(this.props)(name, defaultValue)
	},
	getId : function(prefix) {
		return this.id ? this.id : attr.bind(this.props)('id', uuid(prefix));
	},
};
