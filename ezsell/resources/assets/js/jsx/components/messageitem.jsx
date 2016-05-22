/**
 * MessageItem defination
 */
var MessageItem = React.createClass({
	eventName: Dispatcher.Events.UPDATE_MESSAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
        ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	toggleTime(e) {
		$(e.currentTarget).parents('.chatitem').find('.created').slideToggle();
	},
	render(){
		const message = this.props.message;
		if (message) {
			var className = 'clearfix chatitem ' + (message.receiver ? 'myitem' : (message.sender.gender == 'MALE' ? 'hisitem' : 'heritem'));
			var statusClassName = 'status '+ util.getAttr.bind(message)('status', '');
			return (
				<div className={className}>
					<div className='message' onClick={this.toggleTime}>
						<div className={statusClassName}></div>
						{message.message}
					</div>
					<div className='datetimeformat created'>{message.created_at.date}</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

window.MessageItem = MessageItem;
export default window.MessageItem;