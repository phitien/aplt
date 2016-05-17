(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

$(document).ready(function () {
	$(document).keyup(function (e) {
		if (e.keyCode == 27) {
			hideMenus();
		}
	});
	//scroll to bottom to load more data
	$(window).scroll(function () {
		if ($(window).scrollTop() == $(document).height() - $(window).height()) {
			console.log('TODO: reach to the bottom, load more data if possible');
		} else if ($(window).scrollTop() == 0) {
			console.log('TODO: reach to the top, don\'t know what to do now :-o');
		}
	});

	ReactDOM.render(React.createElement(CatMenu, {
		items: cats
	}), document.getElementById(catmenuDivId));
	ReactDOM.render(React.createElement(FormView, {
		onMouseUp: function onMouseUp(e, checked) {
			$.ajax({
				url: location.href,
				data: {
					mode: checked ? 1 : ''
				},
				success: function success(data) {
					console.log(data);
				}
			});
		},
		formrender: function formrender() {
			return React.createElement(
				FormView.Form,
				{ className: 'form', method: 'get', encType: 'multipart/form-data',
					onValidSubmit: this.submit, onValid: this.enableButton, onInvalid: this.disableButton },
				React.createElement(FormView.Input, { type: 'switch', name: 'mode', title: 'Mode',
					defaultChecked: mode == MODES.SELL ? true : false,
					checkedChildren: 'Sell',
					unCheckedChildren: 'Buy',
					onMouseUp: this.props.onMouseUp })
			);
		}
	}), document.getElementById(extraDivId));
	if (showLeft) {
		ReactDOM.render(React.createElement(CatMenu, {
			items: cats,
			showRoot: false,
			className: 'leftmenu'
		}), document.getElementById(leftDivId));
	}

	if (appMessage) {
		showMessageDialog(appMessage);
	}
});

},{}]},{},[1]);

//# sourceMappingURL=app.js.map
