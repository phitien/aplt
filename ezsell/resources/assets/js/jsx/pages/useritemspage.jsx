/**
 * UserItemsPage defination
 */
var UserItemsPage = React.createClass({
	eventName: Dispatcher.Events.UPDATE_USERITEMSPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	render() {
		const data = Dispatcher.Store.get(this.eventName);
		if (data) {
			const user = data.useritems;
			if (user) {
				const items = data.paginate.data;
				this.id = this.id ? this.id : this.props.id ? this.props.id : util.uuid('item-list');
				const className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
				return (
					<div className={className} id={this.id}>
						<div className='user-detail'>
							<UserBox user={user} />
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

window.UserItemsPage = UserItemsPage;
export default window.UserItemsPage;