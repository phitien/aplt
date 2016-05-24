/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	mixins: [Mixin],
	eventName: AppEvents.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount: function() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	onClick(e) {
		const isGuest = appManager.get('isGuest', true);
		const user = appManager.user();
		if (!isGuest && user && user.id) {
			const item = Dispatcher.item(this.props.item.id);
			var id = appManager.get('usecode') ? item.code : item.id;
			if (id) {
				ajax.post('/like', function(o) {
					appStore.set(AppEvents.UPDATE_ITEMDETAILSPAGE, o.data);
				}, {id: id, user_id: user.id});
			}
		}
	},
	render() {
		const item = appStore.get(this.eventName, this.props.item.id);
		if (item) {
			const iconClassName = 'icon icon-like ' + (item.liked ? 'icon-like-unliked' : ''); 
			const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
			const href = showLink ? '/item/' + (appManager.get('usecode') ? item.code : item.id) : 'javascript:void(0);';
			return (
				<div className={this.className('', (item.liked ? ' liked' : ' unliked'), 'item-firstimage ')}>
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

module.exports = window.ItemImage = ItemImage;