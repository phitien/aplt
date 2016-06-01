/**
 * Application defination
 */
var Application = React.createClass({
	eventName: AppEvents.CONFIGURATIONS_UPDATE,
	refreshCount: 0,
	refresh() {
		this.setState({refreshCount: this.refreshCount++});
	},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		// scroll to bottom to load more data
		$(window).scroll(function() {
	    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
	    		var paginate = appManager.paginate();
	    		if (paginate && paginate.next_page_url) {
	    			applicationSwitch(paginate.next_page_url);
	    		}
	    		else {
	    			//TODO
	    		}
	    	}
	    	else if($(window).scrollTop() == 0) {
	    	}
		});
		if (appManager.appMessage()) {
			showMessageDialog(appManager.appMessage());
		}
	},
	render() {
		return (
			<div id='application'>
				<div className='container-fluid row clearfix' id='navigation-replacement'></div>
				<Banner className='container-fluid row clearfix'/>
				<div className='container-fluid row clearfix' id='container'>
					<Left/>
					<Center/>
					<Right/>
				</div>
				<Footer className='container-fluid row clearfix'/>
				<Navigation className='container-fluid row clearfix'/>
				<ChatBar className='container-fluid row clearfix'/>
				<div id="dialog"></div>
			</div>
		);
	}
});

module.exports = window.Application = Application;