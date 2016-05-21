import Dispatcher from './dispatcher/dispatcher.jsx';
import CatMenu from './components/catmenu.jsx';
import FormView from './components/formview.jsx';
import UserBox from './components/userbox.jsx';
import ChatBar from './components/chatbar.jsx';
//
/**
 * Some common functions
 */
Object.assign(window, {
	Dispatcher: Dispatcher,
	CatMenu: CatMenu,
	FormView: FormView,
	UserBox: UserBox,
	ChatBar: ChatBar,
	engine: (function() {
		$.getJSON('//ip-api.com/json?callback=?', function(data) {
			window.clientIP = data.query;
		});
	})(),
	sensitive: 'input,select,textarea,img,.sensitive',
	getPropValue: function(props, name, defaultValue) {
		if (props.hasOwnProperty(name))
			return props[name];
		return defaultValue;
	},
	sessionManager: (function() {
		var me = this;
		var _data = {};
		return {
			isLogged: function() {
				if (!this.get('isGuest', true))
					return this.get('user');
				return false;
			},
			isListPage: function () {
				if (this.has('rawdata'))
					return this.get('rawdata').paginate;
				return false;
			},
			has: function(name) {
				return _data.hasOwnProperty(name);
			},
			get: function(name, defaultValue) {
				if (this.has(name))
					return _data[name];
				return defaultValue;
			},
			set: function(name, value) {
				_data[name] = value;
				return this;
			},
			assign: function(name, value) {
				if (this.has(name))
					Object.assign(_data[name], value);
				else
					_data[name] = Object.assign({}, value);
				return this;
			},
			remove: function(name) {
				if (this.has(name))
					delete _data[name];
				return this;
			}
		};
	})(),
	ip: function() {
		return clientIP;
	},
	uuid: function (prefix) {
		return (prefix ? prefix : '') + Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
	},
	token: function() {
		return $('meta[name="csrf-token"]').attr('content');
	},
	getMode: function() {
		return sessionManager.get('mode');
	},
	setMode: function(mode) {
		sessionManager.set('mode', mode);
	},
	isCurrentUser: function(_user) {
		var user = sessionManager.get('user');
		if (user && user.id == _user.id) {
			return true;
		}
		return false;
	},
	isFollowingTo: function(_user) {
		var user = sessionManager.get('user');
		if (user && !sessionManager.get('isGuest')) {
			return user.following.indexOf(_user.id) >= 0;
		}
		return false;
	},
	isFollowerOf: function(_user) {
		var user = sessionManager.get('user');
		if (user && !sessionManager.get('isGuest')) {
			return user.followers.indexOf(_user.id) >= 0;
		}
		return false;
	},
	format: {
		currency: function (v) {
			var n = parseFloat(v) != NaN ? parseFloat(v) : 0; 
			return n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		},
		time: function (v, format) {
			return $.format.date(v, sessionManager.get('location').timeformat);
		},
		date: function (v, format) {
			return $.format.date(v, format ? format : sessionManager.get('location').dateformat);
		},
		datetime: function (v, format) {
			return $.format.date(v, format ? format : sessionManager.get('location').datetimeformat);
		},
		prettyDate: function (v) {
			return $.format.prettyDate(v);
		}
	},
	submitForm: function(form) {
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
	},
	ajax: {
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
	},
	showMessageDialog: function(msg, title, btn, callback) {
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
	},
	expandMenu: function(e) {
		var menu = $(e).next('ul');
		toggleElement(menu);
	},
	hideMenus: function() {
		slideUp($('.sensitive'));
	},
	toggleElement: function(e) {
		if ( e.css('display') == 'none' ) 
			slideDown(e);
		else 
			slideUp(e);
	},
	slideDown: function(e) {
		e.slideDown();
		e.css('visibility', 'visible');
		$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'hidden');
	},
	slideUp: function(e) {
		e.slideUp(function () {
			$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'visible');
			e.css('visibility', 'hidden');
		});
	},
	hideClassName: function(classNameToHide, exceptions) {
		$('.' + classNameToHide).not(exceptions).hide();
	},
	showLoginForm: function(e) {
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
	},
	showRegistrationForm: function(e) {
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
	},
	showLocationForm: function(e) {
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
								value={sessionManager.get('location').name} placeholder={localization.please_type_location} />
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
								if (id && id != sessionManager.get('location').id)
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
	},
	sendMessage: function(message, chatbox) {
		if (message) {
			const user = chatbox.props.user;
			if (user && sessionManager.isLogged()) {
				ajax.post('/sendmessage', function() {
					chatbox.messageSentCallbalk(message);
				}, {'message': message, code: user.id});
			}
		}
	},
	ui: {
		getItemExpires: function(item) {
			return item.deleted_at ? expired_at = <div className='item-date item-expired'>
								<a><span className='label expired-label'>{localization.expires_at}</span><span className='prettydateformat'>{item.deleted_at}</span></a>
							</div> : null;
		},
		getItemPostedOrEdited: function(item) {
			var created = new Date(item.created_at);
			var updated = new Date(item.updated_at);
			return (+updated !== +created) ? 
							<div className='item-date item-updated'>
								<a><span className='label edited-label'>{localization.edited_at}</span><span className='prettydateformat'>{item.updated_at}</span></a>
							</div> : 
							<div className='item-date item-created'>
								<a><span className='label posted-label'>{localization.posted_at}</span><span className='prettydateformat'>{item.created_at}</span></a>
							</div>;
		},
		plugins: {
			format: function ($container) {
				if (!$container) {
					$('.prettydateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text((format.prettyDate(text) ? format.prettyDate(text) : '') + ' (' + format.date(text) + ')');
					});
					$('.dateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.date(text));
					});
					$('.timeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.time(text));
					});
					$('.datetimeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.datetime(text));
					});
					$('.currency-value').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.currency(text));
					});
				}
				else {
					$container.find('.prettydateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text((format.prettyDate(text) ? format.prettyDate(text) : '') + ' (' + format.date(text) + ')');
					});
					$container.find('.dateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.date(text));
					});
					$container.find('.timeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.time(text));
					});
					$container.find('.datetimeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.datetime(text));
					});
					$container.find('.currency-value').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.currency(text));
					});
				}
			}
		}
	}
});
