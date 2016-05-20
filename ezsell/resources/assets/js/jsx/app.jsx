import Application from './components/application.jsx';
//
Object.assign(window, {
	Application: Application
});
$( document ).ready(function() {
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			hideMenus();
		}
	});
	//scroll to bottom to load more data
	$(window).scroll(function() {
    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
    		var paginate = sessionManager.isListPage();
    		if (paginate && paginate.next_page_url) {
				ajax.get(paginate.next_page_url, function( _data ) {
					if (_data && _data.data && _data.data.paginate) {
						_data.data.paginate.data = paginate.data.concat(_data.data.paginate.data);
						Dispatcher.emit(Dispatcher.events.APPL_EVENT, _data.data);
					}
				});
    		}
    	}
    	else if($(window).scrollTop() == 0) {
    	}
	});
	/**
	 * add CatMenu
	 */
	ReactDOM.render(React.createElement(CatMenu, { 
		items: sessionManager.get('cats')
	/**
	 * add mode switch
	 */
	}), document.getElementById(catmenuDivId));
	ReactDOM.render(React.createElement(FormView, {
		onMouseUp(e, checked) {
			setMode(checked ? 1 : 0);
			if (sessionManager.isListPage()) {
				ajax.get(location.href, function( _data ) {
					if (_data && _data.data) {
						Dispatcher.emit(Dispatcher.events.APPL_EVENT, _data.data);
					}
				});
			}
		},
		formrender() {
			return (
				<FormView.Form className='form' method='get' encType='multipart/form-data'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='switch' name='mode' title={localization.mode}
						defaultChecked={getMode() == sessionManager.get('MODES').SELL ? true : false} 
						checkedChildren={localization.sell}
        				unCheckedChildren={localization.buy}
        				onMouseUp={this.props.onMouseUp} />
				</FormView.Form>
			); 
		}
	}), document.getElementById(extraDivId));
	if (sessionManager.get('showLeft', false)) {
		ReactDOM.render(React.createElement(CatMenu, { 
			items: sessionManager.get('cats'),
			showRoot: false,
			className: 'leftmenu'
		}), document.getElementById(leftDivId));
	}
	
	if (sessionManager.get('appMessage')) {
		showMessageDialog(appMessage);
	}

	ReactDOM.render(
		<Application data={sessionManager.get('data')} />, 
		document.getElementById(centerDivId)
	);
});
