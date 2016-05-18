/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	onClick(e) {
		if (!isGuest && user && user.id) {
			var id = usecode ? this.props.item.code : this.props.item.id;
			if (id) {
				ajax.post('/like', function(o) {
					
				}, {id: id, user_id: user.id});
			}
		}
	},
	render() {
		const item = this.props.item;
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
