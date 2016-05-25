/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount: function() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	onLikeClick(e) {
		const user = appManager.isLogged();
		if (user) {
			const item = appManager.item(this.props.item.id);
			var id = appManager.get('usecode') ? item.code : item.id;
			if (id) {
				ajax.post('/like', function(o) {
					appManager.item(this.props.item.id, o.data);
				}, {id: id, user_id: user.id});
			}
		}
	},
	render() {
		const item = appManager.item(this.props.item.id);
		if (item) {
			const iconClassName = 'icon icon-like ' + (item.liked ? 'icon-like-unliked' : ''); 
			const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
			this.href = showLink ? '/item/' + (appManager.get('usecode') ? item.code : item.id) : 'javascript:void(0);';
			return (
				<div className={this.className('', (item.liked ? ' liked' : ' unliked'), 'item-firstimage ')}>
					<div className='item-firstimage-wrapper'>
						<a onClick={this.onOpenLink}><img src={item.images[0].url}/></a>
						<a className={iconClassName} onClick={this.onLikeClick}></a>
					</div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.ItemImage = ItemImage;