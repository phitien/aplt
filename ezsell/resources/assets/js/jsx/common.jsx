import CatMenu from './components/catmenu.jsx';
import FormView from './components/formview.jsx';
import UserBox from './components/userbox.jsx';
//
window.CatMenu = CatMenu;
window.FormView = FormView;
window.UserBox = UserBox;
/**
 * Some common functions
 */
//
window.format = {
	currency: function (v) {
		var n = parseFloat(v) != NaN ? parseFloat(v) : 0; 
		return n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
	},
	time: function (v, format) {
		return $.format.date(v, currentLocation.timeformat);
	},
	date: function (v, format) {
		return $.format.date(v, format ? format : currentLocation.dateformat);
	},
	datetime: function (v, format) {
		return $.format.date(v, format ? format : currentLocation.datetimeformat);
	},
	prettyDate: function (v) {
		return $.format.prettyDate(v);
	}
}
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
window.ajax = {
	exe: function(url, success, data, type) {
		$.ajax({
			type: type ? type : 'GET',
			url: url,
			data: Object.assign({'_token': token(), 'mode': getMode()}, data),
			success: success
		});
	},
	get: function(url, success, data) {
		this.exe(url, success, data, 'GET');
	},
	post: function(url, success, data) {
		this.exe(url, success, data, 'POST');
	},
	put: function(url, success, data) {
		this.exe(url, success, data, 'PUT');
	},
	delete: function(url, success, data) {
		this.exe(url, success, data, 'DELETE');
	}  
}; 

window.showMessageDialog = function(msg, title, btn, callback) {
	btn = btn ? btn : localization.ok;
	title = title ? title : localization.message;
	var buttons = {};
	buttons[btn] = function() {
		$( this ).dialog( 'close' );
		$( this ).remove();
		if (callback) {
			callback();
		}
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
	var menu = $(e).next('ul');
	toggleElement(menu);
}
window.hideMenus = function() {
	slideUp($('.sensitive'));
};
window.toggleElement = function(e) {
	if ( e.css('display') == 'none' ) {
		slideDown(e);
	} else {
		slideUp(e);
	}
}
window.sensitive = 'input,select,textarea,img,.sensitive';
window.slideDown = function(e) {
	e.slideDown();
	e.css('visibility', 'visible');
	$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'hidden');
}
window.slideUp = function(e) {
	e.slideUp(function () {
		$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'visible');
		e.css('visibility', 'hidden');
	});
}
window.hideClassName = function(classNameToHide, exceptions) {
	$('.' + classNameToHide).not(exceptions).hide();
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
						<FormView.Input type='email' required name='email' title={localization.email} validations='isEmail' 
							validationError={localization.invalid_email} />
						<FormView.Input type='password' required name='password' title={localization.password} 
							validationError={localization.invalid_password} />
						<FormView.Input type='checkbox' name='remember' title={localization.remember_me} />
						<FormView.Input name='btn-submit' type='submit' disabled={!this.state.canSubmit} value={localization.login} className='center-block' />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleElement($('#form-container'));
		});
	}
	else {
		toggleElement($('#form-container'));
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
						<FormView.Input type='email' required name='email' title={localization.email} validations='isEmail' 
							validationError={localization.invalid_email} />
						<FormView.Input type='email' name='email_confirmation' title={localization.email_confirmation} validations='equalsField:email' 
							validationError={localization.email_confirmation_not_matched} />
						<FormView.Input type='password' required name='password' title={localization.password} validations='isPassword' 
							validationError={localization.password_rules} />
						<FormView.Input type='password' name='password_confirmation' title={localization.password_confirmation} validations='equalsField:password' 
							validationError={localization.password_confirmation_not_matched} />
						<FormView.Input name='btn-submit' type='submit' disabled={!this.state.canSubmit} value={localization.register} className='center-block' />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			toggleElement($('#form-container'));
		});
	}
	else {
		toggleElement($('#form-container'));
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
			onValidSubmit(model) {},
			formrender() { 
				return (
					<FormView.Form className='form' method='post' action='/location'>
						<FormView.Input type='autocomplete' name='location' title={localization.location} source='/searchlocation' className='center-block' 
							value={currentLocation.name} placeholder={localization.please_type_location} />
					</FormView.Form>
				); 
			}
		}), document.getElementById('form-container'), function() {
			$('.autocomplete').each(function (i,e) {
				var source = e.getAttribute('data-source');
				$(e).autocomplete({ 
					source: function( request, response ) {
						ajax.get(source, function( data ) {
							var items = [];
							$.each(data.data, function (i, v) {
								items.push({
									id: v.id,
									label: v.fullname
								});
							});
							response(items);
						}, {
							q: request.term
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
								toggleElement($('#form-container'));
						}
					}
				});
			});
			toggleElement($('#form-container'));
		});
	}
	else {
		toggleElement($('#form-container'));
	}
}
window.sendMessage = function(e) {
	var message = $(e).prev('input').val();
	if (message) {
		ajax.post('/sendmessage', function() {
			$(e).prev('input').val('');
		}, {'message': message});
	}
};

window.getMode = function() {
	return mode;
};
window.setMode = function(_mode) {
	mode = _mode;
};
window.isCurrentUser = function(_user) {
	if (user.id == _user.id) {
		return true;
	}
	return false;
};
