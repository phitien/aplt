/**
 * ItemDetail defination
 */
var ItemDetail = React.createClass({
	render : function() {
		const className = 'item-detail-wrapper ' + (this.props.className?this.props.className:'');
		const item = this.props.item;
		return (
			<div className={className}>
				<div className='item-detail'>
					<div className='item-title'>
						<a><span>{item.title}</span></a>
					</div>
					<div className='item-prices'>
						<div className='item-price item-originalprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.originalprice)}</span> <label>Original</label></div>
						<div className='item-price item-saleprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.saleprice)}</span> <label>Sale</label></div>
						<div className='item-price item-nowprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.nowprice)}</span> <label>Now</label></div>
					</div>
					<div className='item-description'>
						<p>{item.description}</p>
					</div>
				</div>
			</div>
		);
	}
});

export default ItemDetail;
