import ChatBox from './chatbox.jsx';
/**
 * ChatBar defination
 */
var ChatBar = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHATBAR,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(this.eventName, function() {});
		Dispatcher.EventEmitter.removeListener(Dispatcher.Events.ADD_CHATBOX, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(this.eventName, this.refresh);
		Dispatcher.EventEmitter.on(Dispatcher.Events.ADD_CHATBOX, this.refresh);
	},
	render(){
		const users = Dispatcher.Store.get(this.eventName);
		if (users && users.length) {
			const className = 'chatbar ' + getPropValue(this.props, 'className', '');
			return (
				<div className={className}>
					{users.map(function (user, i) {
						return <ChatBox user={user} key={i} />;
					})}
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

export default ChatBar;