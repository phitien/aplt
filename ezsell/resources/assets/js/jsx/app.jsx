import CatMenu from './components/catmenu.jsx';

$( document ).ready(function() {
	if (ezsellMessage) {
		showMessageDialog(ezsellMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { items : cats, className : 'nav navbar-nav navbar-left' }), document.getElementById('leftmenu'));
});
