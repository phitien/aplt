$( document ).ready(function() {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { 
		items : cats 
	}), document.getElementById('catmenu'));
});
