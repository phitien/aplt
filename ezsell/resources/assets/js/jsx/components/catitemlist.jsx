import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * CatItemList defination
 */
var CatItemList = React.createClass({
	render : function() {
		const className = 'item-list-wrapper ' + (this.props.className?this.props.className:'');
		const data = this.props.data;
		const cat = data.catitems;
		const items = data.items;
		const id = this.props.id ? this.props.id : uuid('item-list');
		return (
			<div className={className} id={id}>
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
						return (
							<div className={itemClassName} key={i}>
								<ItemImage item={item} />
								<ItemSummary item={item} prices='original,now' />
								<UserBox user={item.user} />
							</div>
						);
					})}
				</div>
			</div>
		);
	}
});

export default CatItemList;