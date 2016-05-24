/**
 * Right defination
 */
var Right = React.createClass({
	id: 'right',
	mixins: [Mixin],
	eventName : AppEvents.UPDATE_RIGHT,
	refreshCount : 0,
	refresh : function() {
		this.setState({
			refreshCount : this.refreshCount++
		});
	},
	componentWillUnmount : function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount : function() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render : function() {
		var showRight = appManager.showRight();
		if (showRight) {
			return (
				<div className={this.className('col-xs-12 col-sm-6 col-md-' + showRight)} id={this.getId()}>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.Right = Right;