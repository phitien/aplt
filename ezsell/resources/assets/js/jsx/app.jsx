$( document ).ready(function() {
	// set app data
	appManager.configurations(configurations);
	// start socket connection
	window.appSocket = new AppSocket(appManager.socketUri(), appManager.clientKey());
	// launch application
	ReactDOM.render(<Application />, document.getElementById('viewport'));
});
