import CatMenu from './components/catmenu.jsx';
import Input from './components/form/input.jsx';
import Button from './components/form/button.jsx';
import Select from './components/form/select.jsx';
import FormView from './components/formview.jsx';
//
window.Input = Input;
window.Button = Button;
window.Select = Select;
window.FormView = FormView;
window.Form = FormView.Form;
window.CatMenu = CatMenu;
//
$( document ).ready(function() {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { items : cats, className : 'nav navbar-nav navbar-left' }), document.getElementById('leftmenu'));
});
