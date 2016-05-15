/**
 * UserBox defination
 */
var UserBox = React.createClass({
	render : function() {
		const user = this.props.user;
		if (user) {
			const className = 'userbox ' + (this.props.className ? this.props.className : '');
			const avatar = user && user.avatar ? user.avatar : 
				('http://media.ezsell.com/noavatar' + (user.gender == 'MALE' ? 'man' : 'woman'));
			const href = '/' + user.name; 
			return (
				<div className={className}>
					<img src={avatar} />
					<a href={href}><span>{user.displayname}</span></a>
				</div>
			);
		}
		else {
			return (
				<div>
				</div>
			);
		}  
	}
});

export default UserBox;
