import ItemSummary from './itemsummary.jsx';
/**
 * ItemList defination
 */
var ItemList = React.createClass({
	render : function() {
		const className = 'item-list-wrapper ' + (this.props.className?this.props.className:'');
		const items = this.props.items;
		const id = this.props.id ? this.props.id : uuid('item-list');
		return (
			<div className={className} id={id}>
				<div className='cat-detail'>
					<div className='cat-name'>
						<label>{cat && cat.details ? cat.details.name : ''}</label>
					</div>
					<div className='cat-title'>
						<label>{cat && cat.details ? cat.details.title : ''}</label>
					</div>
					<div className='cat-description'>
						<p>{cat && cat.details ? cat.details.description : ''}</p>
					</div>
				</div>
				<div className='row item-list'>
					{items.map(function (item, i) {
						var itemClassName = 'col-xs-6 col-md-2 item ' + (i==0?'item-first':'');
						return (
							<div className={itemClassName} key={i}>
								<div className='item-firstimage'>
									<div className='item-firstimage-wrapper'>
										<img src={item.images[0].url}/>
									</div>
								</div>
								<ItemSummary item={item} key={i} prices='original,now' />
								<UserBox user={item.user} />
							</div>
						);
					})}
				</div>
			</div>
		);
	}
});

export default ItemList;