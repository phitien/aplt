import HomePage from './pages/homepage.jsx';
import CatItemsPage from './pages/catitemspage.jsx';
import UserItemsPage from './pages/useritemspage.jsx';
import ItemDetailsPage from './pages/itemdetailspage.jsx';
import ChangeLocationPage from './pages/changelocationpage.jsx';
import LoginPage from './pages/loginpage.jsx';
import RegisterPage from './pages/registerpage.jsx';
import ChangeAccountPage from './pages/changeaccountpage.jsx';
import SendActivationPage from './pages/sendactivationpage.jsx';
//
import Application from './application/application.jsx';
//
$( document ).ready(function() {
	ui.addEventHandlers();
	/**
	 * add CatMenus
	 */
	ReactDOM.render(<CatMenu items={sessionManager.cats()} />, 
		document.getElementById(catmenuDivId));
	if (sessionManager.get('showLeft', false)) {
		ReactDOM.render(<CatMenu items={sessionManager.cats()} showRoot={false} className='leftmenu'/>, 
			document.getElementById(leftDivId));
	}
	/**
	 * add mode switch
	 */
	ReactDOM.render(<ModeSwitch />, document.getElementById(extraDivId));
	ReactDOM.render(<Application />, document.getElementById(centerDivId));
	ReactDOM.render(<ChatBar />, document.getElementById(chatbarDivId));
});
