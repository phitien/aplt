/**
 * ChatBox defination
 */
var ChatBox = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHATBOX,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	onKeyPress(e) {
		if (e.which == 13) {
			this.send(e.currentTarget.value);
			$(e.currentTarget).val('');
		}
	},
	onSend(e) {
		this.send($(e.currentTarget).parents().find('input[type=text]').val());
		$(e.currentTarget).parents().find('input[type=text]').val('');
	},
	send(message) {
		const receiver = Dispatcher.Store.get(this.eventName, this.props.user.id);
		if (receiver && message) {
			if (sessionManager.isLogged()) {
				ajax.post('/sendmessage', function(response) {
					Dispatcher.emit(Dispatcher.Events.SENT_MESSAGE, response.data);
				}, {'message': message, code: receiver.id, id: receiver.itemId});
			}
		}
	},
	render(){
		const user = Dispatcher.Store.get(this.eventName, this.props.user.id);
		if (user) {
			const className = 'chatbox ' + util.getClassName(this.props);
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? sessionManager.get('noavatarman') : sessionManager.get('noavatarwoman'));
			const href = '/' + user.name; 
			const messages = util.getAttr.bind(user)('messages', []);
			return (
				<div className={className}>
					<div className='header'>
						<div className='name'>{user.displayname}</div>
						<div className='close'>{localization.close_sign}</div>
						<div className='minimize'>{localization.minimize_sign}</div>
						<div className='maximize'>{localization.maximize_sign}</div>
						<div className='clearfix'></div>
					</div>
					<div className='messages'>
						{messages.map(function(item, i) {
							return <MessageItem message={item} key={i} />;
						})}
					</div>
					<div className='send'>
						<input type='text' className='' onKeyPress={this.onKeyPress} />
						<input type='button' value={localization.send} onClick={this.onSend} />
						<div className='clearfix'></div>
					</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

window.ChatBox = ChatBox;
export default window.ChatBox;