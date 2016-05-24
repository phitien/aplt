/**
 * UserItemsPage defination
 */
var UserItemsPage = React.createClass({
	mixins: [Mixin],
	eventName: AppEvents.UPDATE_USERITEMSPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(getRootDom(this)));
	},
	render() {
		const user = appManager.data();
		const paginate = appManager.paginate();
		if (user && paginate) {
			const items = paginate.data;
			return (
				<div className={this.className('', 'item-list-wrapper')} id={this.getId()}>
					<div className='user-detail'>
						<UserBox user={user} />
					</div>
					<div className='row item-list'>
						{items.map(function (item, i) {
							var itemClassName = 'col-xs-6 col-md-2 item ' + (i==0?'item-first':'');
							return (
								<div className={itemClassName} key={i}>
									<ItemImage item={item} />
									<ItemSummary item={item} prices='original,now' />
								</div>
							);
						})}
					</div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.UserItemsPage = UserItemsPage;