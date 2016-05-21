/**
 * ItemSummary defination
 */
var ItemSummary = React.createClass({
	eventName: Dispatcher.Events.UPDATE_ITEM,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.EventEmitter.removeListener(this.eventName, function() {});
	},
	componentDidMount: function() {
		Dispatcher.EventEmitter.on(this.eventName, this.refresh);
	},
	render() {
		const item = Dispatcher.Store.get(this.eventName, this.props.item.id);
		if (item) {
			const prices = getPropValue(this.props, 'prices', 'original,sale,now').split(',');
			const className = 'item-summary ' + getPropValue(this.props, 'className', '') + (item.liked ? ' liked' : ' unliked');
			const iconClassName = 'icon icon-like ' + (item.liked ? '' : 'icon-like-unliked');
			const showLink = getPropValue(this.props, 'showLink', true);
			const href = showLink ? '/item/' + (sessionManager.get('usecode') ? item.code : item.id) : 'javascript:void(0);';
			var price_list = 
				<div className='item-prices'>{prices.map(function (o, i) {
					var pclassName = 'item-price item-' + o + 'price';
					var pvalue = item[o + 'price'];
					return (
						<div className={pclassName} key={i}>
							<span className='currency-sign'>{sessionManager.get('location').currency}</span>
							<span className='currency-value'>{pvalue}</span> 
							<span className='label'>{o[0].toUpperCase() + o.slice(1)}</span>
						</div>
					);
				})}
			</div>;
			
			return (
				<div className={className}>
					<div className='item-title'>
						<a href={href}><span>{item.title}</span></a>
					</div>
					{ui.getItemPostedOrEdited(item)}
					{ui.getItemExpires(item)}
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

export default ItemSummary;
