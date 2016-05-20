import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * UserItemList defination
 */
var UserItemList = React.createClass({
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
			const user = data.useritems;
			if (user) {
				const items = data.paginate.data;
				this.id = this.id ? this.id : this.props.id ? this.props.id : uuid('item-list');
				const className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
				return (
					<div className={className} id={this.id}>
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
		}
		return null;
	}
});

export default UserItemList;