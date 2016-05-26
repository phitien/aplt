/**
 * ItemSummary defination
 */
var ItemSummary = React.createClass({
	mixins: [createMixin(), ItemDates],
	eventName: AppEvents.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount: function() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(this.getRootDom()));
	},
	render() {
		const item = appManager.item(this.props.item.id);
		if (item) {
			const prices = this.attr('prices', 'original,sale,now').split(',');
			const iconClassName = 'icon icon-like ' + (item.liked ? '' : 'icon-like-unliked');
			const showLink = this.attr('showLink', true);
			this.href = showLink ? '/item/' + (appManager.usecode() ? item.code : item.id) : 'javascript:void(0);';
			var price_list = 
				<div className='item-prices'>{prices.map(function (o, i) {
					var pclassName = 'item-price item-' + o + 'price';
					var pvalue = item[o + 'price'];
					return (
						<div className={pclassName} key={i}>
							<span className='currency-sign'>{appManager.location().currency}</span>
							<span className='currency-value'>{pvalue}</span> 
							<span className='label'>{o[0].toUpperCase() + o.slice(1)}</span>
						</div>
					);
				})}
			</div>;
			
			return (
				<div className={this.className('', item.liked ? ' liked' : ' unliked', 'item-summary')}>
					<div className='item-title'>
						<a onClick={this.onOpenLink}><span>{item.title}</span></a>
					</div>
					{this.getItemPostedOrEdited(item)}
					{this.getItemExpires(item)}
					<div className={item.is_new ? 'new' : 'used'}>{item.is_new ? 'New' : 'Used'}</div>
					{price_list}
					<div className='likes'>
						<div className='amount'>{item.likes}</div>
						<div className={iconClassName}></div>
					</div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.ItemSummary = ItemSummary;