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
	$('<input>').attr({
		type: 'hidden',
		name: 'redirect',
		value: location.href
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
window.showLoginForm = function(e) {
	if (!window.currentForm || window.currentForm != 'login') {
		$('#form-container').hide();
		window.currentForm = 'login';
		ReactDOM.render(React.createElement(FormView, {
			className : 'EzsellFormView',
			formrender() { 
				return (
					<Formsy.Form className='EzsellForm' method='post' action='/login' autocomplete='off'  onkeypress='return event.keyCode != 13;'
					onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
						<Input type='email' required name='email' title='Email' validations='isEmail' 
							validationError='This is not a valid email' />
						<Input type='password' required name='password' title='Password' 
							validationError='Password is required' />
						<Input type='checkbox' name='remember' title='Remember me' />
						<input type='hidden' name='redirect' value={location.href} />
						<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Login' />
					</Formsy.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleForm();
		});
	}
	else {
		toggleForm();
	}
}
window.showRegistrationForm = function(e) {
	if (!window.currentForm || window.currentForm != 'register') {
		$('#form-container').hide();
		window.currentForm = 'register';
		ReactDOM.render(React.createElement(FormView, {
			className : 'EzsellFormView',
			formrender() { 
				return (
					<Formsy.Form className='EzsellForm' method='post' action='/register' autocomplete='off'  onkeypress='return event.keyCode != 13;' 
					onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
						<Input type='email' required name='email' title='Email' validations='isEmail' 
							validationError='This is not a valid email' />
						<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
							validationError='Email confirmation is not matched' />
						<Input type='password' required name='password' title='Password' validations='isPassword' 
							validationError='Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' />
						<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
							validationError='Password confirmation is not matched' />
						<input type='hidden' name='redirect' value={location.href} />
						<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Register' />
					</Formsy.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleForm();
		});
	}
	else {
		toggleForm();
	}
}
window.showLocationForm = function(e) {
	if (!window.currentForm || window.currentForm != 'location') {
		$('#form-container').hide();
		window.currentForm = 'location';
		ReactDOM.render(React.createElement(FormView, {
			className : 'EzsellFormView',
			initialState : {
				value: '',
				locations: [],
				loading: false
			},
			formrender() { 
				var currentLocationLabel = '';
				if (currentLocation) {
					currentLocationLabel = <label>Current: {currentLocation.name}</label>;
				}
				return (
					<Formsy.Form className='EzsellForm' method='post' action='/location' autocomplete='off' onkeypress='return event.keyCode != 13;' 
						onValidSubmit={this.submit}onValid={this.enableButton} onInvalid={this.disableButton}>
						{currentLocationLabel}
						<Input type='text' autocomplete='true' required name='location' title='Location' source='/searchlocation' />
						<input type='hidden' name='redirect' value={location.href} />
					</Formsy.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			$('.autocomplete input:first').each(function (i,e) {
				var source = e.getAttribute('data-source');
				$(e).autocomplete({ 
					source: function( request, response ) {
						$.ajax({
							url: source,
							data: {
								q: request.term
							},
							success: function( data ) {
								var items = [];
								$.each(data.data, function (i, v) {
									items.push({
										id: i,
										label: v
									});
								});
								response(items);
							}
						});
					},
					minLength: 2,
					select: function (event, ui) {
						if (ui && ui.item) {
							this.setAttribute('data-value', ui.item);
							const id = ui.item.id;
							this.nextSibling.value = id;
							if (id && id != currentLocation.id)
								submitForm($(this).parents('form:first'));
							else
								toggleForm();
						}
					}
				});
			});
			toggleForm();
		});
	}
	else {
		toggleForm();
	}
}
window.toggleForm = function() {
	$('#form-container').slideToggle();
};
//
$( document ).ready(function() {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(CatMenu, { items : cats }), document.getElementById('catmenu'));
});
