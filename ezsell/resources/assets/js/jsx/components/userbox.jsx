/**
 * UserBox defination
 */
module.exports = window.UserBox = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
		Dispatcher.removeListener(AppEvents.UPDATE_USER, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(AppEvents.UPDATE_USER, this.refresh);
	},
	onChatClick(e) {
		if (this.canDo()) {
			const itemId = this.props.itemId;
			appStore.set(AppEvents.ADD_CHATBOX, user, itemId);
		}
	},
	onFollowClick(e) {
		const user = this.canDo();
		if (user) {
			const _isFollowingTo = this.isFollowingTo(user);
			if (_isFollowingTo) {// unfollow
				ajax.post('/unfollow/' + user.id, function(o) {
					appStore.set(AppEvents.UPDATE_USER, o.data);
				});
			}
			else {// follow
				ajax.post('/follow/' + user.id, function(o) {
					appStore.set(AppEvents.UPDATE_USER, o.data);
				});
			}
		}
	},
	canDo(action) {
		const user = this.props.user;
		if (user) {
			try { return appManager.isLogged().id != user.id ? user : false; }
			catch(e) {}
		}
		return false;
	},
	render() {
		const user = this.props.user;
		if (user) {
			const _isGuest = appManager.isGuest();
			const _isCurrentUser = this.isCurrentUser(user);
			const _isFollowingTo = this.isFollowingTo(user);

			const iconChatClassName = 'icon icon-chat' + (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconChatTitle = _isGuest ? configurations.localization.please_login_first : 
				_isCurrentUser ? configurations.localization.cannot_chat_with_yourself : 'Send message';
			const iconFollowClassName = 'icon ' 
				+ (_isFollowingTo ? 'icon-unfollow' : 'icon-follow') 
				+ (_isGuest || _isCurrentUser ? ' icon-disabled' : '');
			const iconFollowTitle = _isGuest ? configurations.localization.please_login_first : 
				_isCurrentUser ? configurations.localization.cannot_follow_yourself : 
				_isFollowingTo ? configurations.localization.unfollow : '';
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? appManager.get('noavatarman') : appManager.get('noavatarwoman'));
			this.href = '/' + user.name; 
			return (
				<div className={this.className('', 'userbox')}>
					<img src={avatar} />
					<a className='user-name' onClick={this.onOpenLink}><span>{user.displayname}</span></a>
					<a className={iconChatClassName} onClick={this.onChatClick} title={iconChatTitle}></a>
					<a className={iconFollowClassName} onClick={this.onFollowClick} title={iconFollowTitle}></a>
				</div>
			);
		}
		return null;
	}
});