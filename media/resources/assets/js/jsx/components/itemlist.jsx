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
				<div className='item-list'>
					{items.map(function (item, i) {
						return (
							<ItemSummary item={item} key={i}/>
						);
					})}
				</div>
			</div>
		);
	}
});

export default ItemList;