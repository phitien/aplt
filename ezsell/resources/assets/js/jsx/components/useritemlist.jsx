import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * UserItemList defination
 */
var UserItemList = React.createClass({
	render : function() {
		const className = 'item-list-wrapper ' + (this.props.className?this.props.className:'');
		const data = this.props.data;
		const user = data.useritems;
		const items = data.items;
		const id = this.props.id ? this.props.id : uuid('item-list');
		return (
			<div className={className} id={id}>
				<div className='user-detail'>
					<div className='user-name'>
						<label>{user.displayname}</label>
					</div>
					<div className='user-description'>
						<p>{user.description}</p>
					</div>
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
});

export default UserItemList;