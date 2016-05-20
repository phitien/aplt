/**
 * UserBox defination
 */
var UserBox = React.createClass({
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.events.LISTITEM_EVENT, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(Dispatcher.events.LISTITEM_EVENT, this.refresh);
	},
	onChatClick(e) {
		if (!isCurrentUser(this.props.user)) {
			console.log('TODO start conversation!!');
		}
	},
	onFollowClick(e) {
		if (!isCurrentUser(this.props.user)) {
			console.log('TODO follow user!!');
		}
	},
	render(){
		const user = this.props.user;
		if (user) {
			const _isGuest = sessionManager.get('isGuest', true);
			const _isCurrentUser = isCurrentUser(user);

			const className = 'userbox ' + getPropValue(this.props, 'className');
			const iconChatClassName = 'icon icon-chat' + (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconChatTitle = _isGuest ? ' Please login' : _isCurrentUser ? 'Cannot chat to yourself' : '';
			const iconFollowClassName = 'icon icon-follow' + (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconFollowTitle = _isGuest ? ' Please login' : _isCurrentUser ? 'Cannot follow yourself' : '';
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