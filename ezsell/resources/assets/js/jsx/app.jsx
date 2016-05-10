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
window.uuid = function (prefix) {
  return (prefix ? prefix : '') + Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
}
window.submitForm = function(form) {
	$('<input>').attr({
		type: 'hidden',
		name: '_token',
		value: $('meta[name="csrf-token"]').attr('content')
	}).appendTo(form);
	form.submit();
}
window.showMessageDialog = function(msg, title, btn) {
	btn = btn ? btn : 'Ok';
	title = title ? title : 'Message';
	var buttons = {};
	buttons[btn] = function() {
		$( this ).dialog( 'close' );
		$( this ).remove();
	};
 	$('<div></div>').dialog({
		modal: true,
		title: title,
		closeOnEscape: false,
		open: function(e, ui) {
			$('.ui-dialog-titlebar-close', ui.dialog | ui).hide();
			$(this).html(msg);
		},
		buttons: buttons
	});//end confirm dialog
}
window.expandMenu = function(e) {
	$(e).next('ul').slideToggle();
}
//
$( document ).ready(function() {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { items : cats }), document.getElementById('catmenu'));
});
