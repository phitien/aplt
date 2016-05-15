$( document ).ready(function() {
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			hideMenus();
		}
	});
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { 
		items : cats 
	}), document.getElementById('catmenu'));
	
	//scroll to bottom to load more data
	$(window).scroll(function() {
    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
			console.log('TODO: reach to the bottom, load more data if possible');
    	}
    	else if($(window).scrollTop() == 0) {
    		console.log('TODO: reach to the top, don\'t know what to do now :-o');
    	}
	});
	
});
