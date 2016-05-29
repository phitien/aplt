/**
 * HomePage defination
 */
var HomePage = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.UPDATE_HOMEPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render() {
		return (
			<div className={this.className('', 'homepage')} id={this.getId()}>
			</div>
		);
	}
});

module.exports = window.HomePage = HomePage;