/**
 * ChatBar defination
 */
var ChatBar = React.createClass({
	id: 'chatbar',
	mixins: [createMixin()],
	eventName: AppEvents.CHATUSERS_UPDATE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render(){
		const users = appStore.chatusers();
		if (users && users.length) {
			return (
				<div className={this.className('', 'chatbar')} id={this.getId()}>
					{users.map(function (user, i) {
						return <div className='chatbox-wrapper' key={i}>
								<ChatBox user={user}></ChatBox>
							</div>;
					})}
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.ChatBar = ChatBar;