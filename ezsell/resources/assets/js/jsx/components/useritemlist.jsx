import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * UserItemList defination
 */
var UserItemList = React.createClass({
	getInitialState() {
		return {
			user: this.props.data.useritems,
			items: this.props.data.items
		};
	},
	componentDidMount: function() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.CHANGE_EVENT, function() {
			me.setState({
				user: data.useritems,
				items: data.items
			});
		});
	},
	componentWillUnmount: function() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.CHANGE_EVENT, function() {});
	},
	render() {
		this.id = this.id ? this.id : this.props.id ? this.props.id : uuid('item-list');
		const className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
		return (
			<div className={className} id={this.id}>
				<div className='user-detail'>
					<div className='user-name'>
						<label>{this.state.user.displayname}</label>
					</div>
					<div className='user-description'>
						<p>{this.state.user.description}</p>
					</div>
				</div>
				<div className='row item-list'>
					{this.state.items.map(function (item, i) {
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