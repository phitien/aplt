import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
//
/**
 * CatItemList defination
 */
var CatItemList = React.createClass({
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.events.LIST_EVENT, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(Dispatcher.events.LIST_EVENT, this.refresh);
	},
	render() {
		var data = Dispatcher.list();
		if (data) {
			const cat = data.catitems;
			if (cat) {
				const items = data.paginate.data;
				this.id = this.id ? this.id : this.props.id ? this.props.id : uuid('item-list');
				const className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
				return (
					<div className={className} id={this.id}>
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
								var userbox = isCurrentUser(item.user) ? null : <UserBox user={item.user} />; 
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
		}
		return null;
	}
});

export default CatItemList;