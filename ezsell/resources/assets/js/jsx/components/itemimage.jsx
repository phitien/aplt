/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	getInitialState: function() {
		return {
			item: Dispatcher.item()
		};
	},
	componentDidMount() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.EVENT, function() {
			me.setState({
				item: Dispatcher.item()
			});
		});
	},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.EVENT, function() {});
	},
	onClick(e) {
		if (!isGuest && user && user.id) {
			var id = usecode ? this.props.item.code : this.props.item.id;
			if (id) {
				ajax.post('/like', function(o) {
					Dispatcher.emit(o.data);
				}, {id: id, user_id: user.id});
			}
		}
	},
	render() {
		const item = this.state.item ? this.state.item : this.props.item;
		const className = 'item-firstimage ' + (this.props.className ? this.props.className : '');
		const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
		const href = showLink ? '/item/' + (usecode ? item.code : item.id) : 'javascript:void(0);';
		return (
			<div className={className}>
				<div className='item-firstimage-wrapper'>
					<a href={href}><img src={item.images[0].url}/></a>
					<a className='icon-heart' onClick={this.onClick}></a>
				</div>
			</div>
		);
	}
});

export default ItemImage;
