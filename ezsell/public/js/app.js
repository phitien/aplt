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
window.submitForm = function (form) {
	$('<input>').attr({
		type: 'hidden',
		name: '_token',
		value: $('meta[name="csrf-token"]').attr('content')
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
//
$(document).ready(function () {
	if (appMessage) {
		showMessageDialog(appMessage);
	}
	ReactDOM.render(React.createElement(_catmenu2.default, { items: cats, className: 'nav navbar-nav navbar-left' }), document.getElementById('leftmenu'));
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
			return '';
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
			inputText = React.createElement('input', { type: type, name: this.props.name, onChange: this.changeValue, value: this.getValue() || '', className: 'form-control' });
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
	render: function render() {
		var data = this.props.data;
		var getText = this.props.getText;
		var getHref = this.props.getHref;
		var getChildren = this.props.getChildren;
		try {
			var text = getText.bind(data)();
			var href = getHref.bind(data)();
			var html = href ? React.createElement(
				'a',
				{ href: '{href}' },
				React.createElement(
					'span',
					null,
					text
				)
			) : React.createElement(
				'a',
				null,
				React.createElement(
					'span',
					null,
					text
				)
			);
			var children = getChildren.bind(data)();
			if (children && children.length > 0) {
				return React.createElement(
					'li',
					null,
					html,
					React.createElement(Menu, { items: children, getText: getText, getHref: getHref, getChildren: getChildren })
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
		} catch (e) {
			return React.createElement('li', null);
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
