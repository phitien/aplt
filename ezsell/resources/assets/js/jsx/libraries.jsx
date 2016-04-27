window.$ = require('jquery');
window.React = require('react');
window.ReactDOM = require('react-dom');
window.Formsy = require('formsy-react');
Formsy.addValidationRule('notEqualsField', function (values, value, field) {
	return value != values[field];
});
//Formsy.addValidationRule('matchRegexp', function (values, value, regexp) {
//	if (regexp instanceof RegExp) {
//		return regexp.test(value);
//	} else {
//		return (new RegExp(regexp.replace(/^\//,'').replace(/\/\w*$/,''))).test(value);
//	}
//});