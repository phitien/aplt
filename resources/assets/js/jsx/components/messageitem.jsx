/**
 * MessageItem defination
 */
var MessageItem = React.createClass({
	mixins: [createMixin()],
	componentDidMount() {
        ui.plugins.format($(this.getRootDom()));
	},
	toggleTime(e) {
		$(this.getRootDom()).find('.status').slideToggle();
		$(this.getRootDom()).find('.created').slideToggle();
	},
	render(){
		const message = this.props.message;
		if (message) {
			var statusClassName = 'status '+ attr.bind(message)('status', 'SENT');
			return (
				<div className={this.className('', message.receiver ? 'myitem' : (message.sender.gender == 'MALE' ? 'hisitem' : 'heritem'), 'clearfix chatitem')}>
					<div className='emotion message' onClick={this.toggleTime}>{message.message}</div>
					<div className={statusClassName}></div>
					<div className='datetimeformat created'>{message.created_at.date}</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.MessageItem = MessageItem;