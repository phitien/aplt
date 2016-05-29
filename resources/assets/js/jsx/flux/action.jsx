/**
 * @class Store
 */
module.exports = window.Action = function(type, data) {
	this.actionType = type;
	this.data = data;
}
Object.assign(window.Action.prototype, {
	valid : function() {
		if (this.actionType && AppEvents.hasOwnProperty(this.actionType))
			return true;
		return false;
	}
});