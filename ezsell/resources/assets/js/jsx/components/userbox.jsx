/**
 * UserBox defination
 */
var UserBox = React.createClass({
	render : function() {
		const className = 'userbox ' + (this.props.className ? this.props.className : '');
		const user = this.props.user;
		return (
			<div className={className}>
			</div>
		);
	}
});

export default UserBox;
