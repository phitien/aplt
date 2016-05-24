/**
 * ChatBar defination
 */
var ChatBar = React.createClass({
	id: 'chatbar',
	mixins: [Mixin],
	eventName: AppEvents.UPDATE_CHATBAR,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render(){
		const users = appStore.get(this.eventName);
		if (users && users.length) {
			return (
				<div className={this.className()}>
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

module.exports = window.ChatBar = ChatBar;