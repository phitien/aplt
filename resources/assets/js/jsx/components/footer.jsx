/**
 * Footer defination
 */
var Footer = React.createClass({
	id: 'footer',
	mixins: [createMixin()],
	eventName : AppEvents.UPDATE_FOOTER,
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
		return (
			<div className={this.className()} id={this.getId()}>
			</div>
		);
		return null;
	}
});

module.exports = window.Footer = Footer;