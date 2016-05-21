/**
 * UserBox defination
 */
var UserBox = React.createClass({
	eventName: Dispatcher.Events.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(this.eventName, function() {});
		Dispatcher.EventEmitter.removeListener(Dispatcher.Events.USER_EVENT, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(this.eventName, this.refresh);
		Dispatcher.EventEmitter.on(Dispatcher.Events.UPDATE_USER, this.refresh);
	},
	onChatClick(e) {
		const user = this.props.user;
		if (user) {
			const _isGuest = sessionManager.get('isGuest', true);
			const _isCurrentUser = isCurrentUser(user);
			if (!_isGuest && !_isCurrentUser) {
				Dispatcher.emit(Dispatcher.Events.ADD_CHATBOX, user);
			}
		}
	},
	onFollowClick(e) {
		const user = this.props.user;
		if (user) {
			const _isGuest = sessionManager.get('isGuest', true);
			const _isCurrentUser = isCurrentUser(user);
			if (!_isGuest && !_isCurrentUser) {
				const _isFollowingTo = isFollowingTo(user);
				if (_isFollowingTo) {//unfollow
					ajax.post('/unfollow/' + user.id, function(o) {
						Dispatcher.emit(Dispatcher.Events.USER_EVENT, o.data);
					});
				}
				else {//follow
					ajax.post('/follow/' + user.id, function(o) {
						Dispatcher.emit(Dispatcher.Events.USER_EVENT, o.data);
					});
				}
			}
		}
	},
	render(){
		const user = this.props.user;
		if (user) {
			const _isGuest = sessionManager.get('isGuest', true);
			const _isCurrentUser = isCurrentUser(user);
			const _isFollowingTo = isFollowingTo(user);

			const className = 'userbox ' + getPropValue(this.props, 'className', '');
			const iconChatClassName = 'icon icon-chat' + (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconChatTitle = _isGuest ? localization.please_login_first : 
				_isCurrentUser ? localization.cannot_chat_with_yourself : 'Send message';
			const iconFollowClassName = 'icon ' 
				+ (_isFollowingTo ? 'icon-unfollow' : 'icon-follow') 
				+ (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconFollowTitle = _isGuest ? localization.please_login_first : 
				_isCurrentUser ? localization.cannot_follow_yourself : 
				_isFollowingTo ? localization.unfollow : '';
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? sessionManager.get('noavatarman') : sessionManager.get('noavatarwoman'));
			const href = '/' + user.name; 
			return (
				<div className={className}>
					<img src={avatar} />
					<a className='user-name' href={href}><span>{user.displayname}</span></a>
					<a className={iconChatClassName} onClick={this.onChatClick} title={iconChatTitle}></a>
					<a className={iconFollowClassName} onClick={this.onFollowClick} title={iconFollowTitle}></a>
				</div>
			);
		}
		return null;
	}
});

export default UserBox;