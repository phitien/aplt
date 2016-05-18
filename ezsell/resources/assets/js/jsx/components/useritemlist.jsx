import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * UserItemList defination
 */
var UserItemList = React.createClass({
	getInitialState: function() {
		return {
			data: Dispatcher.list()
		};
	},
	componentDidMount() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.EVENT, function() {
			me.setState({
				data: Dispatcher.list()
			});
		});
	},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.EVENT, function() {});
	},
	render() {
		var data = this.state.data;
		const user = data.useritems;
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
});

export default UserItemList;