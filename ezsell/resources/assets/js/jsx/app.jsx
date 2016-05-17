$( document ).ready(function() {
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			hideMenus();
		}
	});
	//scroll to bottom to load more data
	$(window).scroll(function() {
    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
			console.log('TODO: reach to the bottom, load more data if possible');
    	}
    	else if($(window).scrollTop() == 0) {
    		console.log('TODO: reach to the top, don\'t know what to do now :-o');
    	}
	});

	ReactDOM.render(React.createElement(CatMenu, { 
		items: cats
	}), document.getElementById(catmenuDivId));
	ReactDOM.render(React.createElement(FormView, {
		onMouseUp(e, checked) {
			$.ajax({
				url: location.href,
				data: {
					mode: checked ? 1 : ''
				},
				success: function( data ) {
					console.log(data);
				}
			});
		},
		formrender() {
			return (
				<FormView.Form className='form' method='get' encType='multipart/form-data'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='switch' name='mode' title='Mode'
						defaultChecked={mode == MODES.SELL ? true : false} 
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

});
