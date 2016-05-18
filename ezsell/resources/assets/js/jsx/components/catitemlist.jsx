import ItemSummary from './itemsummary.jsx';
import ItemImage from './itemimage.jsx';
/**
 * CatItemList defination
 */
var CatItemList = React.createClass({
	getInitialState() {
		return {
			cat: this.props.data.catitems,
			items: this.props.data.items
		};
	},
	componentDidMount: function() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.CHANGE_EVENT, function() {
			me.setState({
				cat: data.catitems,
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
				<div className='cat-detail'>
					<div className='cat-name'>
						<label>{this.state.cat.details.name}</label>
					</div>
					<div className='cat-title'>
						<label>{this.state.cat.details.title}</label>
					</div>
					<div className='cat-description'>
						<p>{this.state.cat.details.description}</p>
					</div>
				</div>
				<div className='row item-list'>
					{this.state.items.map(function (item, i) {
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