/**
 * ItemImage defination
 */
var ItemImage = React.createClass({
	getInitialState() {
		return {
			item: this.props.item
		};
	},
	render() {
		const className = 'item-firstimage ' + (this.props.className ? this.props.className : '');
		const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
		const href = showLink ? '/item/' + (usecode ? this.state.item.code : this.state.item.id) : 'javascript:void(0);';
		return (
			<div className={className}>
				<div className='item-firstimage-wrapper'>
					<a href={href}><img src={this.state.item.images[0].url}/></a>
					<a className='icon-heart'></a>
				</div>
			</div>
		);
	}
});

export default ItemImage;
