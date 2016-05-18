import ItemSummary from './itemsummary.jsx';
import ImageGallery from 'react-image-gallery';
/**
 * ItemDetails defination
 */
var ItemDetails = React.createClass({
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
		const data = this.props.data;
		const item = data.itemdetails_item;
		const showThumbnails = true;
		const slideOnThumbnailHover = true;
		const showNav = true;
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
		var posted_at = <div className='item-created'>
							<a><span>Posted:</span><span className='datetimeformat'>{item.created_at}</span></a>
						</div>;
						
		var created = new Date(item.created_at);
		var updated = new Date(item.updated_at);
		if (+updated !== +created) {
			posted_at = <div className='item-date item-updated'>
							<a><span>Edited:</span><span className='datetimeformat'>{item.updated_at}</span></a>
						</div>;
		}
		var expired_at = '';
		if (item.deleted_at) {
			expired_at = <div className='item-date item-expired'>
							<a><span>Expire:</span><span className='datetimeformat'>{item.deleted_at}</span></a>
						</div>;
		}
		var showLink = false;
		var lines = item.description.split('\n'); 
		return (
			<div className={className}>
				<div className='row item-detail'>
					<div className='col-xs-6 col-md-7'>
						<ItemSummary item={item} showLink={showLink} prices='original,now' />
						<div className='item-description'>
							{lines.map(function (o, i) {
								return (
									<p key={i}>{o}</p>
								);
							})}
						</div>
					</div>
					<div className='col-xs-6 col-md-5 item-gallery sensitive'>
						<ImageGallery
							ref={i => this._imageGallery = i}
							items={images}
							slideInterval={3000}
							handleImageLoad={this.handleImageLoad} 
							showThumbnails={showThumbnails}
							slideOnThumbnailHover={slideOnThumbnailHover} 
							showNav={showNav} />
					</div>
				</div>
			</div>
		);
	}
});

export default ItemDetails;
