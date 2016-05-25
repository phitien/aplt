//Outside components
require('../jquery.base64.js');
require('../jquery-migrate-1.2.1.min.js');
require('../../../../node_modules/jquery-dateformat/dist/jquery-dateFormat.min.js');
import ImageGallery from 'react-image-gallery';
Object.assign(window, {
	ImageGallery : ImageGallery,
});

// App helpers
require('./util.jsx');
require('./ui.jsx');
// Mixins
require('./mixins/mixin.jsx');
require('./mixins/formview.jsx');
require('./mixins/itemdates.jsx');
// AppEvent
require('./event/appevent.jsx');
// AppStore
require('./stores/store.jsx');
require('./stores/appstore.jsx');
// Dispatcher
require('./dispatcher/dispatcher.jsx');
// Managers
require('./managers/appmanager.jsx');
// Components
require('./components/switch.jsx');
require('./components/input.jsx');
require('./components/catmenu.jsx');
require('./components/chatbox.jsx');
require('./components/chatbar.jsx');

require('./components/modeswitch.jsx');

require('./components/itemimage.jsx');
require('./components/itemsummary.jsx');
require('./components/messageitem.jsx');
require('./components/userbox.jsx');

require('./components/banner.jsx');
require('./components/left.jsx');
require('./components/center.jsx');
require('./components/right.jsx');
require('./components/footer.jsx');
require('./components/navigation.jsx');
// Pages
require('./pages/homepage.jsx');
require('./pages/catitemspage.jsx');
require('./pages/useritemspage.jsx');
require('./pages/itemdetailspage.jsx');
require('./pages/changelocationpage.jsx');
require('./pages/loginpage.jsx');
require('./pages/registerpage.jsx');
require('./pages/changeaccountpage.jsx');
require('./pages/sendactivationpage.jsx');
require('./pages/deactivatepage.jsx');
require('./pages/changeemailpage.jsx');
require('./pages/changepasswordpage.jsx');
require('./pages/buyitempage.jsx');
require('./pages/sellitempage.jsx');
// Application
require('./application/application.jsx');
//
/**
 * Some common functions
 */
Object.assign(window, {
	sensitive : 'input,select,textarea,img,.sensitive',
	mode : function(val) {
		if (val) {
			appManager.set('mode', mode);	
		}
		return appManager.mode();
	},
	applicationSwitch : function(url) {
		if (!url)
			url = appStore.currentUrl();
		if (appManager.linkDirectly()) {
			location.href = url;
		}
		else {
			ajax.post(url ? url : location.href, function( data ) {
			});
			
		}
	}
});
