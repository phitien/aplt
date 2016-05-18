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
    		$.ajax({
				url: location.href,
				data: {
					page: '2'
				},
				success: function( data ) {
					Actions.dispatch(data.data);
				}
			});
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
			$.ajax({
				url: location.href,
				data: {
					mode: getMode()
				},
				success: function( data ) {
					Actions.dispatch(data.data);
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
		<Application />, 
		document.getElementById(centerDivId)
	);
});
