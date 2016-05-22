require('../jquery.base64.js');
require('../jquery-migrate-1.2.1.min.js');
require('../../../../node_modules/jquery-dateformat/dist/jquery-dateFormat.min.js');
//
import Util from './util.jsx';
import Session from './session.jsx';
import UI from './ui.jsx';
//
import Dispatcher from './dispatcher/dispatcher.jsx';
import FormView from './mixins/formview.jsx';
//
import ModeSwitch from './components/modeswitch.jsx';
import CatMenu from './components/catmenu.jsx';
import MessageItem from './components/messageitem.jsx';
import UserBox from './components/userbox.jsx';
import ChatBar from './components/chatbar.jsx';
//
import ItemImage from './components/itemimage.jsx';
import ItemSummary from './components/itemsummary.jsx';
import ImageGallery from 'react-image-gallery';
//
/**
 * Some common functions
 */
Object.assign(window, {
	
	ImageGallery: ImageGallery,
	
	getMode() {return sessionManager.get('mode');},
	setMode(mode) {sessionManager.set('mode', mode);},
	
	sensitive: 'input,select,textarea,img,.sensitive',
	
	isCurrentUser(_user) {
		var user = sessionManager.user();
		if (user && user.id == _user.id) {
			return true;
		}
		return false;
	},
	isFollowingTo(_user) {
		var user = sessionManager.user();
		if (user && !sessionManager.get('isGuest')) {
			return user.following.indexOf(_user.id) >= 0;
		}
		return false;
	},
	isFollowerOf(_user) {
		var user = sessionManager.user();
		if (user && !sessionManager.get('isGuest')) {
			return user.followers.indexOf(_user.id) >= 0;
		}
		return false;
	}
});
