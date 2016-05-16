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
	}), document.getElementById('catmenu'));
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
