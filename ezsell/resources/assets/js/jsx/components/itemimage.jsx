/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	render : function() {
		const className = 'item-firstimage ' + (this.props.className?this.props.className:'');
		const item = this.props.item;
		const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
		const href = showLink ? '/item/' + (usecode ? item.code : item.id) : 'javascript:void(0);';
		return (
			<div className={className}>
				<div className='item-firstimage-wrapper'>
					<a href={href}><img src={item.images[0].url}/></a>
					<a className='icon-heart'></a>
				</div>
			</div>
		);
	}
});

export default ItemImage;
