import ImageGallery from 'react-image-gallery';
/**
 * ItemDetail defination
 */
var ItemDetail = React.createClass({
	handleImageLoad(event) {
	},
	handlePlay() {
		this._imageGallery.play()
	},
	handlePause() {
		this._imageGallery.pause()
	},
	render : function() {
		const className = 'item-detail-wrapper ' + (this.props.className?this.props.className:'');
		const item = this.props.item;
		const showThumbnails = true;
		var images = [];
		if (item.images) {
			item.images.map(function (o, i) {
				images.push({
					original: o.url,
					thumbnail: o.url,
					originalAlt: o.title,
					description: o.description
				});
			});
		}
		return (
			<div className={className}>
				<div className='row item-detail'>
					<div className='col-xs-6 col-md-7'>
						<div className='item-title'>
							<a><span>{item.title}</span></a>
						</div>
						<div className='item-prices'>
							<div className='item-price item-originalprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.originalprice)}</span> <label>Original</label></div>
							<div className='item-price item-saleprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.saleprice)}</span> <label>Sale</label></div>
							<div className='item-price item-nowprice'><span className='currency-sign'>{currencySign}</span><span className='currency-value'>{currency(item.nowprice)}</span> <label>Now</label></div>
						</div>
						<div className='item-description'>
							<p>{item.description}</p>
						</div>
					</div>
					<div className='col-xs-6 col-md-5 item-gallery'>
						<ImageGallery
							ref={i => this._imageGallery = i}
							items={images}
							slideInterval={3000}
							handleImageLoad={this.handleImageLoad} 
							showThumbnails={showThumbnails} />
					</div>
				</div>
			</div>
		);
	}
});

export default ItemDetail;
