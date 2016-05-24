/**
 * Banner defination
 */
var Banner = React.createClass({
	id: 'banner',
	mixins: [Mixin],
	eventName : AppEvents.UPDATE_BANNER,
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
		var showBanner = appManager.showBanner();
		if (showBanner) {
			return (
				<div className={this.className()} id={this.getId()}>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.Banner = Banner;