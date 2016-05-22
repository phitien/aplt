/**
 * ItemDetailsPage defination
 */
var ItemDetailsPage = React.createClass({
	eventName: Dispatcher.Events.UPDATE_ITEMDETAILSPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount: function() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount: function() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
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
		const data = Dispatcher.Store.get(this.eventName);
		if (data) {
			var item = data.itemdetails;
			this.id = this.id ? this.id : this.props.id ? this.props.id : util.uuid('item-list');
			const className = 'item-details-wrapper ' + util.getAttr(this.props, 'className', '');
			const showThumbnails = util.getAttr(this.props, 'showThumbnails', true);
			const slideOnThumbnailHover = util.getAttr(this.props, 'slideOnThumbnailHover', true);
			const showNav = util.getAttr(this.props, 'showNav', true);
			const slideInterval = util.getAttr(this.props, 'slideInterval', 3000);
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
				<div className={className} id={this.id}>
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

window.ItemDetailsPage = ItemDetailsPage;
export default window.ItemDetailsPage;