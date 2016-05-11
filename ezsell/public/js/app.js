(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _catmenu = require('./components/catmenu.jsx');

var _catmenu2 = _interopRequireDefault(_catmenu);

var _input = require('./components/form/input.jsx');

var _input2 = _interopRequireDefault(_input);

var _button = require('./components/form/button.jsx');

var _button2 = _interopRequireDefault(_button);

var _select = require('./components/form/select.jsx');

var _select2 = _interopRequireDefault(_select);

var _formview = require('./components/formview.jsx');

var _formview2 = _interopRequireDefault(_formview);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//
window.Input = _input2.default;
window.Button = _button2.default;
window.Select = _select2.default;
window.FormView = _formview2.default;
window.Form = _formview2.default.Form;
window.CatMenu = _catmenu2.default;
//
window.uuid = function (prefix) {
	return (prefix ? prefix : '') + Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
};
window.token = function () {
	return $('meta[name="csrf-token"]').attr('content');
};
window.submitForm = function (form) {
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
};
window.showMessageDialog = function (msg, title, btn) {
	btn = btn ? btn : 'Ok';
	title = title ? title : 'Message';
	var buttons = {};
	buttons[btn] = function () {
		$(this).dialog('close');
		$(this).remove();
	};
	$('<div></div>').dialog({
		modal: true,
		title: title,
		closeOnEscape: false,
		open: function open(e, ui) {
			$('.ui-dialog-titlebar-close', ui.dialog | ui).hide();
			$(this).html(msg);
		},
		buttons: buttons
	}); //end confirm dialog
};
window.expandMenu = function (e) {
	$(e).next('ul').slideToggle();
};
window.showLoginForm = function (e) {
	if (!window.currentForm || window.currentForm != 'login') {
		$('#form-container').hide();
		window.currentForm = 'login';
		ReactDOM.render(React.createElement(_formview2.default, {
			className: 'EzsellFormView',
			formrender: function formrender() {
				return React.createElement(
					Formsy.Form,
					{ className: 'EzsellForm', method: 'post', action: '/login', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
						onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
					React.createElement(_input2.default, { type: 'email', required: true, name: 'email', title: 'Email', validations: 'isEmail',
						validationError: 'This is not a valid email' }),
					React.createElement(_input2.default, { type: 'password', required: true, name: 'password', title: 'Password',
						validationError: 'Password is required' }),
					React.createElement(_input2.default, { type: 'checkbox', name: 'remember', title: 'Remember me' }),
					React.createElement('input', { type: 'hidden', name: 'redirect', value: location.href }),
					React.createElement(_button2.default, { name: 'submit', type: 'submit', disabled: !this.state.canSubmit, value: 'Login' })
				);
			}
		}), document.getElementById('form-container'), function () {
			toggleForm();
		});
	} else {
		toggleForm();
	}
};
window.showRegistrationForm = function (e) {
	if (!window.currentForm || window.currentForm != 'register') {
		$('#form-container').hide();
		window.currentForm = 'register';
		ReactDOM.render(React.createElement(_formview2.default, {
			className: 'EzsellFormView',
			formrender: function formrender() {
				return React.createElement(
					Formsy.Form,
					{ className: 'EzsellForm', method: 'post', action: '/register', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
						onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
					React.createElement(_input2.default, { type: 'email', required: true, name: 'email', title: 'Email', validations: 'isEmail',
						validationError: 'This is not a valid email' }),
					React.createElement(_input2.default, { type: 'email', name: 'email_confirmation', title: 'Email confirmation', validations: 'equalsField:email',
						validationError: 'Email confirmation is not matched' }),
					React.createElement(_input2.default, { type: 'password', required: true, name: 'password', title: 'Password', validations: 'isPassword',
						validationError: 'Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' }),
					React.createElement(_input2.default, { type: 'password', name: 'password_confirmation', title: 'Password confirmation', validations: 'equalsField:password',
						validationError: 'Password confirmation is not matched' }),
					React.createElement('input', { type: 'hidden', name: 'redirect', value: location.href }),
					React.createElement(_button2.default, { name: 'submit', type: 'submit', disabled: !this.state.canSubmit, value: 'Register' })
				);
			}
		}), document.getElementById('form-container'), function () {
			toggleForm();
		});
	} else {
		toggleForm();
	}
};
window.showLocationForm = function (e) {
	if (!window.currentForm || window.currentForm != 'location') {
		$('#form-container').hide();
		window.currentForm = 'location';
		ReactDOM.render(React.createElement(_formview2.default, {
			className: 'EzsellFormView',
			initialState: {
				value: '',
				locations: [],
				loading: false
			},
			formrender: function formrender() {
				var currentLocationLabel = '';
				if (currentLocation) {
					currentLocationLabel = React.createElement(
						'label',
						null,
						'Current: ',
						currentLocation.name
					);
				}
				return React.createElement(
					Formsy.Form,
					{ className: 'EzsellForm', method: 'post', action: '/location', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
						onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
					currentLocationLabel,
					React.createElement(_input2.default, { type: 'text', autocomplete: 'true', required: true, name: 'location', title: 'Location', source: '/searchlocation' }),
					React.createElement('input', { type: 'hidden', name: 'redirect', value: location.href })
				);
			}
		}), document.getElementById('form-container'), function () {
			$('.autocomplete input:first').each(function (i, e) {
				var _source = e.getAttribute('data-source');
				$(e).autocomplete({
					source: function source(request, response) {
						$.ajax({
							url: _source,
							data: {
								q: request.term
							},
							success: function success(data) {
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
					select: function select(event, ui) {
						if (ui && ui.item) {
							this.setAttribute('data-value', ui.item);
							var id = ui.item.id;
							this.nextSibling.value = id;
							if (id && id != currentLocation.id) submitForm($(this).parents('form:first'));else toggleForm();
						}
					}
				});
			});
			toggleForm();
		});
	} else {
		toggleForm();
	}
};
window.toggleForm = function () {
	$('#form-container').slideToggle();
};
window.sendMessage = function (e) {
	var message = $(e).prev('input').val();
	if (message) {
		$.ajax({
			type: 'POST',
			url: '/sendmessage',
			data: {
				'_token': token(),
				'message': message
			},
			success: function success() {
				$(e).prev('input').val('');
			}
		});
	}
};
//
$(document).ready(function () {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(_catmenu2.default, { items: cats }), document.getElementById('catmenu'));
});

},{"./components/catmenu.jsx":2,"./components/form/button.jsx":4,"./components/form/input.jsx":5,"./components/form/select.jsx":6,"./components/formview.jsx":7}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _menu = require('./menu.jsx');

var _menu2 = _interopRequireDefault(_menu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//
var CatMenu = React.createClass({
	displayName: 'CatMenu',

	render: function render() {
		function getText() {
			return this.details.name;
		}
		function getHref() {
			if (!this.parent_id) {
				return 'javascript:expandMenu(this)';
			} else if (this.atomic) {
				return 'cat/' + this.id;
			} else {
				return '';
			}
		}
		var className = 'catmenu ' + (this.props.className ? this.props.className : '');
		return React.createElement(_menu2.default, { className: className, items: this.props.items, getText: getText, getHref: getHref });
	}
});
//
exports.default = CatMenu;

},{"./menu.jsx":8}],3:[function(require,module,exports){
'use strict';

var Form = React.createClass({
	displayName: 'Form',
	getInitialState: function getInitialState() {
		var state = this.props.initialState || {};
		state['canSubmit'] = false;
		return state;
	},
	enableButton: function enableButton() {
		this.setState({
			canSubmit: true
		});
	},
	disableButton: function disableButton() {
		this.setState({
			canSubmit: false
		});
	},
	submit: function submit(model) {
		submitForm(ReactDOM.findDOMNode(this));
	},
	render: function render() {
		var formrender = this.props.formrender;
		return formrender.bind(this)();
	}
});

module.exports = Form;

},{}],4:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var Button = React.createClass({
	displayName: 'Button',

	mixins: [Formsy.Mixin],
	render: function render() {
		var className = 'btn btn-default ' + (this.props.className ? this.props.className : '');
		return React.createElement(
			'button',
			{ className: className, type: this.props.type, disabled: this.props.disabled },
			this.props.value
		);
	}
});

exports.default = Button;

},{}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var Input = React.createClass({
	displayName: 'Input',

	mixins: [Formsy.Mixin],
	changeValue: function changeValue(event) {
		var type = this.props.type;
		if (type == 'checkbox') {
			this.setValue(event.currentTarget.checked);
		} else {
			this.setValue(event.currentTarget.value);
		}
	},
	render: function render() {
		var autocomplete = this.props.autocomplete || false;
		var type = this.props.type;
		var errorMessage = this.getErrorMessage();
		var source = this.props.source ? this.props.source : null;

		var className = (this.props.className || '') + ' ' + (this.showRequired() ? 'required' : this.showError() ? 'error' : '');

		var inputText;
		if (autocomplete) {
			className += ' form-group autocomplete ';
			inputText = React.createElement('input', { type: 'text', 'data-source': source, onChange: this.changeValue, value: this.getValue() || '', className: 'form-control' });
		} else if (type == 'checkbox') {
			className += ' checkbox ';
			inputText = React.createElement(
				'label',
				{ htmlFor: this.props.name },
				React.createElement('input', { type: type, name: this.props.name, onChange: this.changeValue, className: 'checkbox', checked: this.getValue() ? 'checked' : null }),
				this.props.title
			);
		} else {
			className += ' form-group ';
			inputText = React.createElement('input', { type: type, name: this.props.name, onChange: this.changeValue, value: this.getValue() || '', className: 'form-control', autocomplete: 'off', readonly: true, onfocus: 'this.removeAttribute(\'readonly\');' });
		}

		var labelText = React.createElement(
			'label',
			{ htmlFor: this.props.name },
			this.props.title
		);
		var hiddenText = React.createElement('input', { type: 'hidden', name: this.props.name });

		return React.createElement(
			'div',
			{ className: className },
			type != 'checkbox' ? labelText : '',
			inputText,
			autocomplete ? hiddenText : '',
			React.createElement(
				'span',
				{ className: 'validation-error' },
				errorMessage
			)
		);
	}
});

exports.default = Input;

},{}],6:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var Select = React.createClass({
	displayName: 'Select',

	mixins: [Formsy.Mixin],
	changeValue: function changeValue(event) {
		this.setValue(event.currentTarget.value);
	},
	render: function render() {
		var className = 'form-group' + (this.props.className || ' ') + (this.showRequired() ? 'required' : this.showError() ? 'error' : '');
		var errorMessage = this.getErrorMessage();
		var options = this.props.options.map(function (option, i) {
			return React.createElement(
				'option',
				{ key: option.title + option.value, value: option.value },
				option.title
			);
		});
		return React.createElement(
			'div',
			{ className: className },
			React.createElement(
				'label',
				{ htmlFor: this.props.name },
				this.props.title
			),
			React.createElement(
				'select',
				{ name: this.props.name, onChange: this.changeValue, value: this.getValue() },
				options
			),
			React.createElement(
				'span',
				{ className: 'validation-error' },
				errorMessage
			)
		);
	}
});

exports.default = Select;

},{}],7:[function(require,module,exports){
'use strict';

var _form = require('./../components/form.jsx');

var _form2 = _interopRequireDefault(_form);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//
var FormView = React.createClass({
	displayName: 'FormView',

	Form: _form2.default,
	render: function render() {
		var className = this.props.className;
		var formrender = this.props.formrender;
		var initialState = this.props.initialState;
		return React.createElement(
			'div',
			{ className: className },
			React.createElement(_form2.default, { formrender: formrender, initialState: initialState })
		);
	}
});

module.exports = FormView;

},{"./../components/form.jsx":3}],8:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var MenuItem = React.createClass({
	displayName: 'MenuItem',
	getText: function getText() {
		try {
			return this.props.getText.bind(this.props.data)();
		} catch (e) {
			return '';
		}
	},
	getHref: function getHref() {
		try {
			return this.props.getHref.bind(this.props.data)();
		} catch (e) {
			return '';
		}
	},
	getChildren: function getChildren() {
		try {
			return this.props.getChildren.bind(this.props.data)();
		} catch (e) {
			return null;
		}
	},
	handleItemClick: function handleItemClick(event) {
		var href = this.getHref().replace('javascript:', '');
		var fn = eval('(function () {' + href + ';})');
		fn.bind(event.currentTarget)();
	},
	render: function render() {
		var text = this.getText();
		if (!text) {
			return React.createElement('li', null);
		}
		var href = this.getHref();
		var html;
		if (href) {
			if (href.indexOf("javascript:") == 0) {
				html = React.createElement(
					'a',
					{ className: 'menuitem menuitem-nonatomic', onClick: this.handleItemClick },
					React.createElement(
						'span',
						null,
						text
					)
				);
			} else {
				html = React.createElement(
					'a',
					{ className: 'menuitem menuitem-atomic', href: href },
					React.createElement(
						'span',
						null,
						text
					)
				);
			}
		} else {
			html = React.createElement(
				'a',
				{ className: 'menuitem menuitem-nonatomic' },
				React.createElement(
					'span',
					null,
					text
				)
			);
		}
		var children = this.getChildren();
		if (children && children.length > 0) {
			return React.createElement(
				'li',
				null,
				html,
				React.createElement(Menu, { items: children, getText: this.props.getText, getHref: this.props.getHref, getChildren: this.props.getChildren })
			);
		} else {
			return React.createElement(
				'li',
				null,
				React.createElement(
					'span',
					null,
					html
				)
			);
		}
	}
});

var Menu = React.createClass({
	displayName: 'Menu',

	MenuItem: MenuItem,
	render: function render() {
		var className = this.props.className ? this.props.className : '';
		var getText = this.props.getText ? this.props.getText : function () {
			return this.text;
		};
		var getHref = this.props.getHref ? this.props.getHref : function () {
			return this.href;
		};
		var getChildren = this.props.getChildren ? this.props.getChildren : function () {
			return this.children;
		};
		return React.createElement(
			'ul',
			{ className: className },
			this.props.items.map(function (item, i) {
				return React.createElement(MenuItem, { data: item, getText: getText, getHref: getHref, getChildren: getChildren, key: i });
			})
		);
	}
});

exports.default = Menu;

},{}]},{},[1]);

//# sourceMappingURL=app.js.map
