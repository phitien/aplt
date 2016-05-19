/**
 * UserBox defination
 */
var UserBox = React.createClass({
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
	render : function() {
		const user = this.props.user;
		if (user) {
			const className = 'userbox ' + (this.props.className ? this.props.className : '');
			const avatar = user && user.avatar ? user.avatar : 
				('http://media.ezsell.com/noavatar' + (user.gender == 'MALE' ? 'man' : 'woman'));
			const href = '/' + user.name; 
			const iconChatClassName = 'icon icon-chat' + (isGuest || isCurrentUser(user) ? ' icon-disabled' : '');
			const iconChatTitle = isGuest ? ' Please login' : isCurrentUser(user) ? 'Cannot chat to yourself' : '';
			const iconFollowClassName = 'icon icon-follow' + (isGuest || isCurrentUser(user) ? ' icon-disabled' : '');
			const iconFollowTitle = isGuest ? ' Please login' : isCurrentUser(user) ? 'Cannot follow yourself' : '';
			return (
				<div className={className}>
					<img src={avatar} />
					<a className='user-name' href={href}><span>{user.displayname}</span></a>
					<a className={iconChatClassName} onClick={this.onChatClick} title={iconChatTitle}></a>
					<a className={iconFollowClassName} onClick={this.onFollowClick} title={iconFollowTitle}></a>
				</div>
			);
		}
		else {
			return null;
		}  
	}
});

export default UserBox;