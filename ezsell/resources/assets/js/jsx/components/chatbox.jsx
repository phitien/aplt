/**
 * ChatBox defination
 */
var ChatBox = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHATBOX,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(Dispatcher.Events.UPDATE_USER, function() {});
		Dispatcher.removeListener(Dispatcher.Events.UPDATE_MESSAGE, function() {});
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(Dispatcher.Events.UPDATE_USER, this.refresh);
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(Dispatcher.Events.UPDATE_MESSAGE, this.addMessage);
	},
	onKeyPress(e) {
		if (e.which == 13) {
			this.send(e.currentTarget.value);
		}
	},
	onSend(e) {
		this.send($(e.currentTarget).parents().find('input[type=text]').val());
	},
	send(message) {
		sendMessage(message, this);
	},
	messageSentCallbalk(message, user) {
		var $o = $(ReactDOM.findDOMNode(this));
		//add sent message
		$o.find('.messages').append('<div class="myitem">' + message + '</div>');
		//clear textbox
		$o.find('input[type=text]').val('');
	},
	addMessage(data) {
		const user = Dispatcher.Store.get(this.eventName, this.props.user.id);
		var _isCurrentUser = isCurrentUser(data.user);
		if (!_isCurrentUser && data.message && data.user && data.user.id == user.id) {
			var $o = $(ReactDOM.findDOMNode(this));
			var classname = data.user.gender == 'MALE' ? 'hisitem' : 'heritem';
			$o.find('.messages').append('<div class="' + classname + '">' + data.message + '</div>');
		}
	},
	render(){
		const user = Dispatcher.Store.get(this.eventName, this.props.user.id);
		if (user) {
			const _isGuest = sessionManager.get('isGuest', true);
			const _isCurrentUser = isCurrentUser(user);
			const _isFollowingTo = isFollowingTo(user);
			const _isFollowerOf = isFollowerOf(user);

			const className = 'chatbox ' + util.getAttr(this.props, 'className', '');
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? sessionManager.get('noavatarman') : sessionManager.get('noavatarwoman'));
			const href = '/' + user.name; 
			return (
				<div className={className}>
					<div className='header'>
						<div className='name'>{user.displayname}</div>
						<div className='close'>{localization.close_sign}</div>
						<div className='minimize'>{localization.minimize_sign}</div>
						<div className='maximize'>{localization.maximize_sign}</div>
						<div className='clearfix'></div>
					</div>
					<div className='messages'></div>
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