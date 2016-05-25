/**
 * MessageItem defination
 */
var MessageItem = React.createClass({
	mixins: [createMixin()],
	componentDidMount() {
        ui.plugins.format($(this.getRootDom()));
	},
	toggleTime(e) {
		$(e.currentTarget).parents('.chatitem').find('.created').slideToggle();
	},
	render(){
		const message = this.props.message;
		if (message) {
			var statusClassName = 'status '+ util.attr.bind(message)('status', '');
			return (
				<div className={this.className('', message.receiver ? 'myitem' : (message.sender.gender == 'MALE' ? 'hisitem' : 'heritem'), 'clearfix chatitem')}>
					<div className='message' onClick={this.toggleTime}>
						<div className={statusClassName}></div>
						{message.message}
					</div>
					<div className='datetimeformat created'>{message.created_at.date}</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.MessageItem = MessageItem;