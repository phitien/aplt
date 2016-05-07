(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _catmenu = require('./components/catmenu.jsx');

var _catmenu2 = _interopRequireDefault(_catmenu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

$(document).ready(function () {
	if (ezsellMessage) {
		showMessageDialog(ezsellMessage);
	}
	ReactDOM.render(React.createElement(_catmenu2.default, { items: cats, className: 'nav navbar-nav navbar-left' }), document.getElementById('leftmenu'));
});

},{"./components/catmenu.jsx":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var Menu = React.createClass({
	displayName: 'Menu',

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

var MenuItem = React.createClass({
	displayName: 'MenuItem',

	render: function render() {
		var data = this.props.data;
		var getText = this.props.getText;
		var getHref = this.props.getHref;
		var getChildren = this.props.getChildren;
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
	}
});

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
		return React.createElement(Menu, { className: className, items: this.props.items, getText: getText, getHref: getHref });
	}
});

exports.default = CatMenu;

},{}]},{},[1]);

//# sourceMappingURL=app.js.map
