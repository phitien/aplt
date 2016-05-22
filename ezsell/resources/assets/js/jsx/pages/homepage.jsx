/**
 * HomePage defination
 */
var HomePage = React.createClass({
	eventName: Dispatcher.Events.UPDATE_HOMEPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	id() {return this._id ? this._id : util.uuid('auto');},
	render() {
		const className = 'homepage ' + util.getClassName(this.props);
		return (
			<div className={className} id={this.id()}>
			</div>
		);
	}
});

window.HomePage = HomePage;
export default window.HomePage;