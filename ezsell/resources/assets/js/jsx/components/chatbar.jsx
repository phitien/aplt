import ChatBox from './chatbox.jsx';
/**
 * ChatBar defination
 */
var ChatBar = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHATBAR,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
		Dispatcher.removeListener(Dispatcher.Events.ADD_CHATBOX, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(Dispatcher.Events.ADD_CHATBOX, this.refresh);
	},
	render(){
		const users = Dispatcher.Store.get(this.eventName);
		if (users && users.length) {
			const className = 'chatbar ' + util.getClassName(this.props);
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

window.ChatBar = ChatBar;
export default window.ChatBar;