(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _homepage = require('./pages/homepage.jsx');

var _homepage2 = _interopRequireDefault(_homepage);

var _catitemspage = require('./pages/catitemspage.jsx');

var _catitemspage2 = _interopRequireDefault(_catitemspage);

var _useritemspage = require('./pages/useritemspage.jsx');

var _useritemspage2 = _interopRequireDefault(_useritemspage);

var _itemdetailspage = require('./pages/itemdetailspage.jsx');

var _itemdetailspage2 = _interopRequireDefault(_itemdetailspage);

var _changelocationpage = require('./pages/changelocationpage.jsx');

var _changelocationpage2 = _interopRequireDefault(_changelocationpage);

var _loginpage = require('./pages/loginpage.jsx');

var _loginpage2 = _interopRequireDefault(_loginpage);

var _registerpage = require('./pages/registerpage.jsx');

var _registerpage2 = _interopRequireDefault(_registerpage);

var _changeaccountpage = require('./pages/changeaccountpage.jsx');

var _changeaccountpage2 = _interopRequireDefault(_changeaccountpage);

var _sendactivationpage = require('./pages/sendactivationpage.jsx');

var _sendactivationpage2 = _interopRequireDefault(_sendactivationpage);

var _application = require('./application/application.jsx');

var _application2 = _interopRequireDefault(_application);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//
$(document).ready(function () {
	ui.addEventHandlers();
	/**
  * add CatMenus
  */
	ReactDOM.render(React.createElement(CatMenu, { items: sessionManager.cats() }), document.getElementById(catmenuDivId));
	if (sessionManager.get('showLeft', false)) {
		ReactDOM.render(React.createElement(CatMenu, { items: sessionManager.cats(), showRoot: false, className: 'leftmenu' }), document.getElementById(leftDivId));
	}
	/**
  * add mode switch
  */
	ReactDOM.render(React.createElement(ModeSwitch, null), document.getElementById(extraDivId));
	ReactDOM.render(React.createElement(_application2.default, null), document.getElementById(centerDivId));
	ReactDOM.render(React.createElement(ChatBar, null), document.getElementById(chatbarDivId));
});
//

},{"./application/application.jsx":2,"./pages/catitemspage.jsx":3,"./pages/changeaccountpage.jsx":4,"./pages/changelocationpage.jsx":5,"./pages/homepage.jsx":6,"./pages/itemdetailspage.jsx":7,"./pages/loginpage.jsx":8,"./pages/registerpage.jsx":9,"./pages/sendactivationpage.jsx":10,"./pages/useritemspage.jsx":11}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * Application defination
 */
var Application = React.createClass({
	displayName: 'Application',

	eventName: Dispatcher.Events.UPDATE_APPLICATION,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.emit(this.eventName, sessionManager.rawdata());
		if (sessionManager.get('appMessage')) {
			showMessageDialog(appMessage);
		}
	},
	render: function render() {
		var pageClassName = sessionManager.getCurrentPage();
		switch (pageClassName) {
			case 'HomePage':
				return React.createElement(HomePage, null);
			case 'CatItemsPage':
				return React.createElement(CatItemsPage, null);
			case 'UserItemsPage':
				return React.createElement(UserItemsPage, null);
			case 'ItemDetailsPage':
				return React.createElement(ItemDetailsPage, null);
			case 'ChangeLocationPage':
				return React.createElement(ChangeLocationPage, { className: 'col-xs-12 col-sm-6 col-md-5 center-block' });
			case 'LoginPage':
				return React.createElement(LoginPage, { className: 'col-xs-12 col-sm-6 col-md-5 center-block' });
			case 'RegisterPage':
				return React.createElement(RegisterPage, { className: 'col-xs-12 col-sm-6 col-md-5 center-block' });
			case 'ChangeAccountPage':
				return React.createElement(ChangeAccountPage, { className: 'col-xs-12 col-sm-6 col-md-5 center-block' });
			case 'SendActivationPage':
				return React.createElement(SendActivationPage, { className: 'col-xs-12 col-sm-6 col-md-5 center-block' });
		}
		return null;
	}
});

window.Application = Application;
exports.default = window.Application;

},{}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
//
/**
 * CatItemsPage defination
 */
var CatItemsPage = React.createClass({
	displayName: 'CatItemsPage',

	eventName: Dispatcher.Events.UPDATE_CATITEMSPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	render: function render() {
		var data = Dispatcher.Store.get(this.eventName);
		if (data) {
			var cat = data.catitems;
			if (cat) {
				var items = data.paginate.data;
				this.id = this.id ? this.id : this.props.id ? this.props.id : util.uuid('item-list');
				var className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
				return React.createElement(
					'div',
					{ className: className, id: this.id },
					React.createElement(
						'div',
						{ className: 'cat-detail' },
						React.createElement(
							'div',
							{ className: 'cat-name' },
							React.createElement(
								'label',
								null,
								cat.details.name
							)
						),
						React.createElement(
							'div',
							{ className: 'cat-title' },
							React.createElement(
								'label',
								null,
								cat.details.title
							)
						),
						React.createElement(
							'div',
							{ className: 'cat-description' },
							React.createElement(
								'p',
								null,
								cat.details.description
							)
						)
					),
					React.createElement(
						'div',
						{ className: 'row item-list' },
						items.map(function (item, i) {
							var itemClassName = 'col-xs-6 col-md-2 item ' + (i == 0 ? 'item-first' : '');
							var userbox = isCurrentUser(item.user) ? null : React.createElement(UserBox, { user: item.user });
							return React.createElement(
								'div',
								{ className: itemClassName, key: i },
								React.createElement(ItemImage, { item: item }),
								React.createElement(ItemSummary, { item: item, prices: 'original,now' }),
								userbox
							);
						})
					)
				);
			}
		}
		return null;
	}
});

window.CatItemsPage = CatItemsPage;
exports.default = window.CatItemsPage;

},{}],4:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * ChangeAccountPage defination
 */
var ChangeAccountPage = React.createClass({
	displayName: 'ChangeAccountPage',

	eventName: Dispatcher.Events.UPDATE_CHANGEACCOUNTPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	formrender: function formrender() {
		var className = util.getClassName(this.props);
		return React.createElement(
			FormView.Form,
			{ className: 'form row', method: 'post', action: '/account',
				onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
			React.createElement(
				'div',
				{ className: className },
				React.createElement(FormView.Input, { type: 'password', required: true, name: 'current_password', title: localization.password,
					validationError: localization.password_required }),
				React.createElement(FormView.Input, { type: 'text', required: true, name: 'name', title: localization.account, validations: {
						notEqualsIgnoreCase: sessionManager.user.name,
						isAccountName: true
					}, validationErrors: {
						notEqualsIgnoreCase: localization.new_account_should_be_different,
						isAccountName: localization.invalid_account
					} }),
				React.createElement(FormView.Input, { type: 'submit', name: 'btn-submit', disabled: !this.state.canSubmit, value: localization.change, className: 'center-block' })
			)
		);
	},
	render: function render() {
		var className = 'change-account-form ' + util.getAttr(this.props, 'className', '');
		return React.createElement(FormView, { className: className, formrender: this.formrender });
	}
});

window.ChangeAccountPage = ChangeAccountPage;
exports.default = window.ChangeAccountPage;

},{}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * ChangeLocationPage defination
 */
var ChangeLocationPage = React.createClass({
	displayName: 'ChangeLocationPage',

	mixins: [FormView],
	getInitialState: function getInitialState() {
		return {
			value: '',
			locations: [],
			loading: false
		};
	},
	onValidSubmit: function onValidSubmit(model) {},

	eventName: Dispatcher.Events.UPDATE_CHANGELOCATIONPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		$('.autocomplete').each(function (i, e) {
			var _source = e.getAttribute('data-source');
			$(e).autocomplete({
				source: function source(request, response) {
					$.ajax({
						url: _source,
						data: {
							q: request.term
						},
						success: function success(_data) {
							var items = [];
							$.each(_data.data, function (i, v) {
								items.push({
									id: v.id,
									label: v.fullname
								});
							});
							response(items);
						}
					});
				},
				minLength: 2,
				select: function select(event, ui) {
					if (ui && ui.item) {
						$(this).attr('data-value', ui.item);
						var id = ui.item.id;
						this.nextSibling.value = id;
						if (id && id != sessionManager.location().id) submitForm($(this).parents('form:first'));
					}
				}
			});
		});
	},
	render: function render() {
		var className = util.getClassName(this.props);
		return React.createElement(
			FormView.Form,
			{ className: 'form row', method: 'post', action: '/location', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
				onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
			React.createElement(
				'div',
				{ className: className },
				React.createElement(FormView.Input, { type: 'autocomplete', name: 'location', title: localization.location, source: '/searchlocation', className: 'center-block',
					value: sessionManager.location().name, placeholder: localization.please_type_location })
			)
		);
	}
});

window.ChangeLocationPage = ChangeLocationPage;
exports.default = window.ChangeLocationPage;

},{}],6:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * HomePage defination
 */
var HomePage = React.createClass({
	displayName: 'HomePage',

	eventName: Dispatcher.Events.UPDATE_HOMEPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	id: function id() {
		return this._id ? this._id : util.uuid('auto');
	},
	render: function render() {
		var className = 'homepage ' + util.getClassName(this.props);
		return React.createElement('div', { className: className, id: this.id() });
	}
});

window.HomePage = HomePage;
exports.default = window.HomePage;

},{}],7:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * ItemDetailsPage defination
 */
var ItemDetailsPage = React.createClass({
	displayName: 'ItemDetailsPage',

	eventName: Dispatcher.Events.UPDATE_ITEMDETAILSPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},

	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	handleImageLoad: function handleImageLoad(event) {},
	handlePlay: function handlePlay() {
		this._imageGallery.play();
	},
	handlePause: function handlePause() {
		this._imageGallery.pause();
	},
	render: function render() {
		var _this = this;

		var data = Dispatcher.Store.get(this.eventName);
		if (data) {
			var item = data.itemdetails;
			this.id = this.id ? this.id : this.props.id ? this.props.id : util.uuid('item-list');
			var className = 'item-details-wrapper ' + util.getAttr(this.props, 'className', '');
			var showThumbnails = util.getAttr(this.props, 'showThumbnails', true);
			var slideOnThumbnailHover = util.getAttr(this.props, 'slideOnThumbnailHover', true);
			var showNav = util.getAttr(this.props, 'showNav', true);
			var slideInterval = util.getAttr(this.props, 'slideInterval', 3000);
			var images = [];
			item.images.map(function (o, i) {
				images.push({
					original: o.url,
					thumbnail: o.url,
					originalAlt: o.title,
					description: o.description
				});
			});
			var lines = item.description.split('\n');
			return React.createElement(
				'div',
				{ className: className, id: this.id },
				React.createElement(
					'div',
					{ className: 'row item-detail' },
					React.createElement(
						'div',
						{ className: 'col-xs-6 col-md-7' },
						React.createElement(ItemSummary, { item: item, showLink: false, prices: 'original,now' }),
						React.createElement(
							'div',
							{ className: 'item-description' },
							lines.map(function (o, i) {
								return React.createElement(
									'p',
									{ key: i },
									o
								);
							})
						)
					),
					React.createElement(
						'div',
						{ className: 'col-xs-6 col-md-5 item-gallery sensitive' },
						React.createElement(ImageGallery, {
							ref: function ref(i) {
								return _this._imageGallery = i;
							},
							items: images,
							slideInterval: slideInterval,
							handleImageLoad: this.handleImageLoad,
							showThumbnails: showThumbnails,
							slideOnThumbnailHover: slideOnThumbnailHover,
							showNav: showNav })
					)
				)
			);
		}
		return null;
	}
});

window.ItemDetailsPage = ItemDetailsPage;
exports.default = window.ItemDetailsPage;

},{}],8:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * LoginPage defination
 */
var LoginPage = React.createClass({
	displayName: 'LoginPage',

	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_LOGINPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render: function render() {
		var className = util.getClassName(this.props);
		return React.createElement(
			FormView.Form,
			{ className: 'form row', method: 'post', action: '/login', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
				onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
			React.createElement(
				'div',
				{ className: className },
				React.createElement(FormView.Input, { type: 'email', required: true, name: 'email', title: localization.email, validations: 'isEmail',
					validationError: localization.invalid_email, value: 'im.phitien@gmail.com' }),
				React.createElement(FormView.Input, { type: 'password', required: true, name: 'password', title: localization.password,
					validationError: localization.password_required }),
				React.createElement(FormView.Input, { type: 'checkbox', name: 'remember', title: localization.remember_me }),
				React.createElement(FormView.Input, { type: 'submit', name: 'btn-submit', disabled: !this.state.canSubmit, value: localization.login, className: 'center-block' })
			)
		);
	}
});

window.LoginPage = LoginPage;
exports.default = window.LoginPage;

},{}],9:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * RegisterPage defination
 */
var RegisterPage = React.createClass({
	displayName: 'RegisterPage',

	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_REGISTERPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render: function render() {
		var className = util.getClassName(this.props);
		return React.createElement(
			FormView.Form,
			{ className: 'form row', method: 'post', action: '/register', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
				onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
			React.createElement(
				'div',
				{ className: className },
				React.createElement(FormView.Input, { type: 'email', required: true, name: 'email', title: localization.email, validations: 'isEmail',
					validationError: localization.invalid_email }),
				React.createElement(FormView.Input, { type: 'email', name: 'email_confirmation', title: localization.email_confirmation, validations: 'equalsField:email',
					validationError: localization.email_confirmation_not_matched }),
				React.createElement(FormView.Input, { type: 'password', required: true, name: 'password', title: localization.password, validations: 'isPassword',
					validationError: localization.password_rules }),
				React.createElement(FormView.Input, { type: 'password', name: 'password_confirmation', title: localization.password_confirmation, validations: 'equalsField:password',
					validationError: localization.password_confirmation_not_matched }),
				React.createElement(FormView.Input, { type: 'submit', name: 'btn-submit', disabled: !this.state.canSubmit, value: localization.register, className: 'center-block' })
			)
		);
	}
});

window.RegisterPage = RegisterPage;
exports.default = window.RegisterPage;

},{}],10:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * SendActivationPage defination
 */
var SendActivationPage = React.createClass({
	displayName: 'SendActivationPage',

	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_SENDACTIVATIONPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render: function render() {
		var className = util.getClassName(this.props);
		return React.createElement(
			FormView.Form,
			{ className: 'form row', method: 'post', action: '/code', autocomplete: 'off', onkeypress: 'return event.keyCode != 13;',
				onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
			React.createElement(
				'div',
				{ className: className },
				React.createElement(FormView.Input, { type: 'email', required: true, name: 'email', title: localization.email, validations: 'isEmail',
					validationError: localization.invalid_email }),
				React.createElement(FormView.Input, { type: 'submit', name: 'btn-submit', disabled: !this.state.canSubmit, value: localization.send, className: 'center-block' })
			)
		);
	}
});

window.SendActivationPage = SendActivationPage;
exports.default = window.SendActivationPage;

},{}],11:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/**
 * UserItemsPage defination
 */
var UserItemsPage = React.createClass({
	displayName: 'UserItemsPage',

	eventName: Dispatcher.Events.UPDATE_USERITEMSPAGE,
	refreshCount: 0,
	refresh: function refresh() {
		this.setState({ refreshCount: this.refreshCount++ });
	},
	componentWillUnmount: function componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function () {});
	},
	componentDidMount: function componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	render: function render() {
		var data = Dispatcher.Store.get(this.eventName);
		if (data) {
			var user = data.useritems;
			if (user) {
				var items = data.paginate.data;
				this.id = this.id ? this.id : this.props.id ? this.props.id : util.uuid('item-list');
				var className = 'item-list-wrapper ' + (this.props.className ? this.props.className : '');
				return React.createElement(
					'div',
					{ className: className, id: this.id },
					React.createElement(
						'div',
						{ className: 'user-detail' },
						React.createElement(UserBox, { user: user })
					),
					React.createElement(
						'div',
						{ className: 'row item-list' },
						items.map(function (item, i) {
							var itemClassName = 'col-xs-6 col-md-2 item ' + (i == 0 ? 'item-first' : '');
							return React.createElement(
								'div',
								{ className: itemClassName, key: i },
								React.createElement(ItemImage, { item: item }),
								React.createElement(ItemSummary, { item: item, prices: 'original,now' })
							);
						})
					)
				);
			}
		}
		return null;
	}
});

window.UserItemsPage = UserItemsPage;
exports.default = window.UserItemsPage;

},{}]},{},[1]);

//# sourceMappingURL=app.js.map
