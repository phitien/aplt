/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	eventName: Dispatcher.Events.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.EventEmitter.removeListener(this.eventName, function() {});
	},
	componentDidMount: function() {
		Dispatcher.EventEmitter.on(this.eventName, this.refresh);
	},
	onClick(e) {
		const isGuest = sessionManager.get('isGuest', true);
		const user = sessionManager.get('user');
		if (!isGuest && user && user.id) {
			const item = Dispatcher.item(this.props.item.id);
			var id = sessionManager.get('usecode') ? item.code : item.id;
			if (id) {
				ajax.post('/like', function(o) {
					Dispatcher.emit(Dispatcher.Events.LISTITEM_EVENT, o.data);
				}, {id: id, user_id: user.id});
			}
		}
	},
	render() {
		const item = Dispatcher.Store.get(this.eventName, this.props.item.id);
		if (item) {
			const className = 'item-firstimage ' + (this.props.className ? this.props.className : '') + (item.liked ? ' liked' : ' unliked');
			const iconClassName = 'icon icon-like ' + (item.liked ? 'icon-like-unliked' : ''); 
			const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
			const href = showLink ? '/item/' + (sessionManager.get('usecode') ? item.code : item.id) : 'javascript:void(0);';
			return (
				<div className={className}>
					<div className='item-firstimage-wrapper'>
						<a href={href}><img src={item.images[0].url}/></a>
						<a className={iconClassName} onClick={this.onClick}></a>
					</div>
				</div>
			);
		}
		return null;
	}
});

export default ItemImage;
