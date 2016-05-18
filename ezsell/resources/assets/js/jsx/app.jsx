import Application from './components/application.jsx';
//
$( document ).ready(function() {
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			hideMenus();
		}
	});
	//scroll to bottom to load more data
	$(window).scroll(function() {
    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
    		if (data.paginate.next_page_url) {
				ajax.get(data.paginate.next_page_url, function( _data ) {
					var items = data.paginate.data.concat(_data.data.paginate.data);
					data.paginate = _data.data.paginate;
					data.paginate.data = items;
					ReactDOM.render(
						<Application data={data} />, 
						document.getElementById(centerDivId)
					);
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
		items: cats
	/**
	 * add mode switch
	 */
	}), document.getElementById(catmenuDivId));
	ReactDOM.render(React.createElement(FormView, {
		onMouseUp(e, checked) {
			setMode(checked ? 1 : 0);
			ajax.get(location.href, function( _data ) {
				if (_data && _data.data) {
					//data = _data.data;
					Application.Dispatcher.emit(_data.data);
				}
			});
		},
		formrender() {
			return (
				<FormView.Form className='form' method='get' encType='multipart/form-data'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='switch' name='mode' title='Mode'
						defaultChecked={getMode() == MODES.SELL ? true : false} 
						checkedChildren={'Sell'}
        				unCheckedChildren={'Buy'}
        				onMouseUp={this.props.onMouseUp} />
				</FormView.Form>
			); 
		}
	}), document.getElementById(extraDivId));
	if (showLeft) {
		ReactDOM.render(React.createElement(CatMenu, { 
			items: cats,
			showRoot: false,
			className: 'leftmenu'
		}), document.getElementById(leftDivId));
	}
	
	if (appMessage) {
		showMessageDialog(appMessage);
	}

	ReactDOM.render(
		<Application data={data} />, 
		document.getElementById(centerDivId)
	);
});
