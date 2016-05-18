/**
 * ItemSummary defination
 */
var ItemSummary = React.createClass({
	getInitialState() {
		return {
			item: this.props.item,
			prices: this.props.hasOwnProperty('prices') ? this.props.prices.split(',') : ['original','sale','now']
		};
	},
	render() {
		var me = this;
		const className = 'item-summary ' + (this.props.className ? this.props.className : '');
		const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
		const href = showLink ? '/item/' + (usecode ? this.state.item.code : this.state.item.id) : 'javascript:void(0);';
		var posted_at = <div className='item-created'>
							<a><span className='label posted-label'>Posted:</span><span className='datetimeformat'>{this.state.item.created_at}</span></a>
						</div>;
						
		var created = new Date(this.state.item.created_at);
		var updated = new Date(this.state.item.updated_at);
		if (+updated !== +created) {
			posted_at = <div className='item-date item-updated'>
							<a><span className='label edited-label'>Edited:</span><span className='datetimeformat'>{this.state.item.updated_at}</span></a>
						</div>;
		}
		var expired_at = '';
		if (this.state.item.deleted_at) {
			expired_at = <div className='item-date item-expired'>
							<a><span className='label expired-label'>Expire:</span><span className='datetimeformat'>{this.state.item.deleted_at}</span></a>
						</div>;
		}
		var price_list = 
			<div className='item-prices'>{this.state.prices.map(function (o, i) {
				var pclassName = 'item-price item-' + o + 'price';
				var pvalue = me.state.item[o + 'price'];
				return (
					<div className={pclassName} key={i}>
						<span className='currency-sign'>{currentLocation.currency}</span>
						<span className='currency-value'>{pvalue}</span> 
						<span className='label'>{o[0].toUpperCase() + o.slice(1)}</span>
					</div>
				);
			})}
		</div>;
		return (
			<div className={className}>
				<div className='item-title'>
					<a href={href}><span>{this.state.item.title}</span></a>
				</div>
				{posted_at}
				{expired_at}
				<div className={this.state.item.is_new ? 'new' : 'used'}>{this.state.item.is_new ? 'New' : 'Used'}</div>
				{price_list}
			</div>
		);
	}
});

export default ItemSummary;
