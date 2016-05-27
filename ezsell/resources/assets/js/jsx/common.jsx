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
require('./flux/appevent.jsx');
require('./flux/action.jsx');
// AppStore
require('./flux/store.jsx');
require('./flux/appstore.jsx');
// Dispatcher
require('./flux/dispatcher.jsx');
// Managers
require('./flux/appmanager.jsx');
// Components
require('./components/switch.jsx');
require('./components/input.jsx');
require('./components/menuitem.jsx');
require('./components/menu.jsx');

require('./components/catmenu.jsx');
require('./components/rightmenu.jsx');
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
// Socket
require('./socket/appsocket.jsx');
// Application
require('./application/application.jsx');
//
/**
 * Some common functions
 */
Object.assign(window, {
	sensitive : 'input,select,textarea,img,.sensitive',
	mode : function(val) {
		return appManager.mode(val);
	},
	applicationSwitch : function(url) {
		hideMenus();
		url = url ? url : appStore.currentUrl(url);
		if (appManager.linkDirectly()) {
			location.href = url.replace(/\?mode=(\d)/g,'') + '?mode=' + appManager.mode();
		}
		else {
			ajax.post(url, function( response ) {
				if (response.data && response.data.configurations) {
					appManager.configurations(response.data.configurations);
				}
			});
			
		}
	}
});
