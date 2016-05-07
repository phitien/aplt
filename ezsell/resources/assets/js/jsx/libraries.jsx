window.$ = require('jquery');
require('jquery-ui');
window.React = require('react');
window.ReactDOM = require('react-dom');
window.Formsy = require('formsy-react');
window.submitForm = function(form) {
	$('<input>').attr({
		type: 'hidden',
		name: '_token',
		value: $('meta[name="csrf-token"]').attr('content')
	}).appendTo(form);
	form.submit();
}
window.showMessageDialog = function(msg, title, btn) {
	btn = btn ? btn : 'Ok';
	title = title ? title : 'Message';
	var buttons = {};
	buttons[btn] = function() {
		$( this ).dialog( 'close' );
		$( this ).remove();
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