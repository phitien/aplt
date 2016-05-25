/**
 * CatItemsPage defination
 */
module.exports = window.CatItemsPage = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.UPDATE_CATITEMSPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(this.getRootDom()));
	},
	render() {
		var me = this;
		const cat = appManager.data();
		const paginate = appManager.paginate();
		if (cat && paginate) {
			const items = paginate.data;
			return (
				<div className={this.className('', 'item-list-wrapper')} id={this.getId()}>
					<div className='cat-detail'>
						<div className='cat-name'>
							<label>{cat.details.name}</label>
						</div>
						<div className='cat-title'>
							<label>{cat.details.title}</label>
						</div>
						<div className='cat-description'>
							<p>{cat.details.description}</p>
						</div>
					</div>
					<div className='row item-list'>
						{items.map(function (item, i) {
							var itemClassName = 'col-xs-6 col-md-2 item ' + (i==0?'item-first':'');
							var userbox = me.isCurrentUser(item.user) ? null : <UserBox user={item.user} itemId={item.id}/>; 
							return (
								<div className={itemClassName} key={i}>
									<ItemImage item={item} />
									<ItemSummary item={item} prices='original,now' />
									{userbox}
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