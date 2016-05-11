import jquery from 'jquery';
require('jquery-ui');
import React from 'react';
import ReactDOM from 'react-dom';
import Formsy from 'formsy-react';
//
window.jQuery = jquery;
window.$ = window.jQuery;
window.React = React;
window.ReactDOM = ReactDOM;
window.Formsy = Formsy;
//
Formsy.addValidationRule('notEqualsField', function (values, value, field) {
	return value != values[field];
});
Formsy.addValidationRule('equalsField', function (values, value, field) {
	return value == values[field];
});
Formsy.addValidationRule('notEquals', function (values, value, eql) {
	return value != eql;
});
Formsy.addValidationRule('notEqualsIgnoreCase', function (values, value, eql) {
	return value && eql && value.toLowerCase() != eql.toLowerCase();
});
Formsy.addValidationRule('isPassword', function (values, value) {
	var minLength = 6, maxLength = 30;
	var reg_at_least_1_lowercase_alphabet_character = /[a-z]+/;
	var reg_at_least_1_uppercase_alphabet_character = /[A-Z]+/;
	var reg_at_least_1_number_character = /[0-9]+/;
	var reg_at_least_1_special_character = /[!@#0^&*()+]+/;
	try {
		if (value && value.length >= minLength && value.length <= maxLength) {//check min & max length
			return reg_at_least_1_lowercase_alphabet_character.test(value)
				&& reg_at_least_1_uppercase_alphabet_character.test(value)
				&& reg_at_least_1_number_character.test(value)
				&& reg_at_least_1_special_character.test(value);
		} 
	} catch(e) {
	}
	return false;
});
Formsy.addValidationRule('isAccountName', function (values, value) {
	var minLength = 3, maxLength = 30;
	var reg = /^[a-z0-9]([\._]?[a-z0-9]+)+$/;
	try {
		if (value && value.length >= minLength && value.length <= maxLength) {//check min & max length
			return reg.test(value.toLowerCase());
		} 
	} catch(e) {
	}
	return false;
});
