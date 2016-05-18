import ItemSummary from './itemsummary.jsx';
import ImageGallery from 'react-image-gallery';
/**
 * ItemDetails defination
 */
var ItemDetails = React.createClass({
	getInitialState() {
		return {
			item: this.props.data.itemdetails
		};
	},
	componentDidMount: function() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.CHANGE_EVENT, function() {
			me.setState({
				item: data.itemdetails
			});
		});
	},
	componentWillUnmount: function() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.CHANGE_EVENT, function() {});
	},
	handleImageLoad(event) {
	},
	handlePlay() {
		this._imageGallery.play()
	},
	handlePause() {
		this._imageGallery.pause()
	},
	render() {
		this.id = this.id ? this.id : this.props.id ? this.props.id : uuid('item-list');
		const className = 'item-details-wrapper ' + (this.props.className ? this.props.className : '');
		const showThumbnails = this.props.showThumbnails ? this.props.showThumbnails : true;
		const slideOnThumbnailHover = this.props.slideOnThumbnailHover ? this.props.slideOnThumbnailHover : true;
		const showNav = this.props.showNav ? this.props.showNav : true;
		const slideInterval = this.props.slideInterval ? this.props.slideInterval : 3000;
		var images = [];
		if (this.state.item.images) {
			this.state.item.images.map(function (o, i) {
				images.push({
					original: o.url,
					thumbnail: o.url,
					originalAlt: o.title,
					description: o.description
				});
			});
		}
		var posted_at = <div className='item-created'>
							<a><span>Posted:</span><span className='datetimeformat'>{this.state.item.created_at}</span></a>
						</div>;
		var created = new Date(this.state.item.created_at);
		var updated = new Date(this.state.item.updated_at);
		if (+updated !== +created) {
			posted_at = <div className='item-date item-updated'>
							<a><span>Edited:</span><span className='datetimeformat'>{this.state.item.updated_at}</span></a>
						</div>;
		}
		var expired_at = '';
		if (this.state.item.deleted_at) {
			expired_at = <div className='item-date item-expired'>
							<a><span>Expire:</span><span className='datetimeformat'>{this.state.item.deleted_at}</span></a>
						</div>;
		}
		var showLink = false;
		var lines = this.state.item.description.split('\n'); 
		return (
			<div className={className} id={this.id}>
				<div className='row item-detail'>
					<div className='col-xs-6 col-md-7'>
						<ItemSummary item={this.state.item} showLink={showLink} prices='original,now' />
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
							slideInterval={slideInterval}
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
