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
	}), document.getElementById('catmenu'));
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
