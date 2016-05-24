/**
 * ItemDetailsPage defination
 */
var ItemDetailsPage = React.createClass({
	mixins: [Mixin],
	eventName: AppEvents.UPDATE_ITEMDETAILSPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount: function() {
		Dispatcher.addListener(this.eventName, this.refresh);
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
		const item = appManager.data();
		if (item) {
			const showThumbnails = this.attr('showThumbnails', true);
			const slideOnThumbnailHover = this.attr('slideOnThumbnailHover', true);
			const showNav = this.attr('showNav', true);
			const slideInterval = this.attr('slideInterval', 3000);
			var images = [];
			item.images.map(function (o, i) {
				images.push({
					original: o.url,
					thumbnail: o.url,
					originalAlt: o.title,
					description: o.description
				});
			});
			var lines = item.description.split('\n'); 
			return (
				<div className={this.className('', 'item-details-wrapper')} id={this.getId()}>
					<div className='row item-detail'>
						<div className='col-xs-6 col-md-7'>
							<ItemSummary item={item} showLink={false} prices='original,now' />
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
		return null;
	}
});

module.exports = window.ItemDetailsPage = ItemDetailsPage;