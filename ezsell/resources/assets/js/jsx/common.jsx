import CatMenu from './components/catmenu.jsx';
import FormView from './components/formview.jsx';
//
window.FormView = FormView;
window.CatMenu = CatMenu;
/**
 * Some common functions
 */
//
window.uuid = function (prefix) {
	return (prefix ? prefix : '') + Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
}
window.token = function() {
	return $('meta[name="csrf-token"]').attr('content');
} 
window.submitForm = function(form) {
	$('<input>').attr({
		type: 'hidden',
		name: '_token',
		value: token()
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
window.expandMenu = function(e, classNameToHide) {
	var menu = $(e).next('ul');
	hideClassName(classNameToHide, menu);
	menu.slideToggle();
}
window.showLoginForm = function(e) {
	if (!window.currentForm || window.currentForm != 'login') {
		$('#form-container').hide();
		window.currentForm = 'login';
		ReactDOM.render(React.createElement(FormView, {
			formrender() { 
				return (
					<FormView.Form className='form' method='post' action='/login' autocomplete='off' onkeypress='return event.keyCode != 13;'
					onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
						<FormView.Input type='email' required name='email' title='Email' validations='isEmail' 
							validationError='This is not a valid email' />
						<FormView.Input type='password' required name='password' title='Password' 
							validationError='Password is required' />
						<FormView.Input type='checkbox' name='remember' title='Remember me' />
						<FormView.Input name='btn-submit' type='submit' disabled={!this.state.canSubmit} value='Login' />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleForm('menu-toggle');
		});
	}
	else {
		toggleForm('menu-toggle');
	}
}
window.showRegistrationForm = function(e) {
	if (!window.currentForm || window.currentForm != 'register') {
		$('#form-container').hide();
		window.currentForm = 'register';
		ReactDOM.render(React.createElement(FormView, {
			formrender() { 
				return (
					<FormView.Form className='form' method='post' action='/register' autocomplete='off' onkeypress='return event.keyCode != 13;' 
					onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
						<FormView.Input type='email' required name='email' title='Email' validations='isEmail' 
							validationError='This is not a valid email' />
						<FormView.Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
							validationError='Email confirmation is not matched' />
						<FormView.Input type='password' required name='password' title='Password' validations='isPassword' 
							validationError='Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' />
						<FormView.Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
							validationError='Password confirmation is not matched' />
						<FormView.Input name='btn-submit' type='submit' disabled={!this.state.canSubmit} value='Register' />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleForm('menu-toggle');
		});
	}
	else {
		toggleForm('menu-toggle');
	}
}
window.showLocationForm = function(e) {
	if (!window.currentForm || window.currentForm != 'location') {
		$('#form-container').hide();
		window.currentForm = 'location';
		ReactDOM.render(React.createElement(FormView, {
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
					<FormView.Form className='form' method='post' action='/location' autocomplete='off' onkeypress='return event.keyCode != 13;' 
						onValidSubmit={this.submit}onValid={this.enableButton} onInvalid={this.disableButton}>
						{currentLocationLabel}
						<FormView.Input type='autocomplete' required name='location' title='Location' source='/searchlocation' />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			$('.autocomplete').each(function (i,e) {
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
								toggleForm('menu-toggle');
						}
					}
				});
			});
			toggleForm('menu-toggle');
		});
	}
	else {
		toggleForm('menu-toggle');
	}
}
window.toggleForm = function(classNameToHide) {
	hideClassName(classNameToHide, $('#form-container'));
	$('#form-container').slideToggle();
};
window.hideClassName = function(classNameToHide, exceptions) {
	$('.' + classNameToHide).not(exceptions).hide();
}
window.sendMessage = function(e) {
	var message = $(e).prev('input').val();
	if (message) {
		$.ajax({
			type: 'POST',
			url: '/sendmessage',
			data: { 
				'_token': token(),
				'message': message
			},
			success: function() {
				$(e).prev('input').val('');
			}
		});
	}
};
