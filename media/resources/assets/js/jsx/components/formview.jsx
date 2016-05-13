import Formsy from 'formsy-react';
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
/**
 * Input defination
 */
const Input = React.createClass({
	mixins: [Formsy.Mixin],
	className: '',
	type: 'text',
	id: '',
	changeValue(event) {
		const type = this.props.type;
		var value;
		if (type == 'checkbox') {
			value = event.currentTarget.checked;
		}
		else if (type == 'textarea') {
			value = event.currentTarget.value;
		}
		else {
			value = event.currentTarget.value;
		}
		this.setValue(value);
		if (this.props.onChange)
			this.props.onChange(this.props.name, value);
	},
	render() {
		this.className = 'form-group ' + (this.props.className || '') + ' ' + (this.showRequired() ? 'required' : this.showError() ? 'error' : '');
		this.type = this.props.type ? this.props.type.toLowerCase() : 'text';
		this.id = this.props.id ? this.props.id : uuid(this.type + '_');
		
		switch(this.type) {
			case 'hidden':
				return this.renderHidden();
			case 'autocomplete':
				return this.renderAutocomplete();
			case 'checkbox':
			case 'radio':
				return this.renderCheckboxRadio();
			case 'checkboxlist':
			case 'radiolist':
				return this.renderCheckboxRadioList();
			case 'button':
			case 'submit':
				return this.renderButton();
			case 'textarea':
				return this.renderTextarea();
			case 'select':
				return this.renderSelect();
			case 'text':
			default:
				return this.renderText();
		}
	},
	renderHidden() {
		return (
			<input {...this.props} id={this.id} type='hidden' name={this.props.name} value={this.getValue()||''} />
		);
	},
	renderText() {
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...this.props} id={this.id} type={this.type} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderAutocomplete() {
		var source = this.props.source ? this.props.source : null;
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...this.props} id={this.id} type='text' onChange={this.changeValue} value={this.getValue()||''} className='form-control autocomplete' 
					data-source={source}/>
				<input type='hidden' name={this.props.name} />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderCheckboxRadio() {
		var name = this.props.name ? this.props.name : uuid('radiolist_');
		this.className += ' ' + this.type;
		return (
			<div className={this.className}>
				<label htmlFor={name}>
					<input {...this.props} id={this.id} type={this.type} name={name} onChange={this.changeValue} className={this.type} />
					{this.props.title}
				</label>
			</div>
		);
	},
	renderCheckboxRadioList() {
		var name = this.props.name ? this.props.name : uuid('radiolist_');
		var type = this.type == 'checkboxlist' ? 'checkbox' : 'radio';
		var props = this.props;
		this.className += ' ' + this.type;
		return (
			<div className={this.className}>
				<label>{this.props.title}</label>
				{this.props.options.map(function(item, index) {
					var itemname = name + '['+index+']';
					var value = item.value;
					return (
						<div className={type} key={index}>
							<label htmlFor={itemname}>
								<input {...props} type={type} name={name} id={itemname} value={value} className={type} />
								{item.label}
							</label>
						</div>
					);
				})}
				<div clasName='clearfix'></div>
			</div>
		);
	},
	renderButton() {
		this.className = 'btn btn-default ' + (this.props.className?this.props.className:''); 
		return (
			<input {...this.props} id={this.id} name={this.props.name} type={this.type} value={this.getValue()||''} className={this.className} onClick={this.props.onClick} disabled={this.props.disabled} />
		);
	},
	renderTextarea() {
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<textarea {...this.props} id={this.id} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control'
					cols={this.props.cols} rows={this.props.rows}></textarea>
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderSelect() {
		const optionLabel = this.props.optionLabel || function(){return this.label;};
		const optionValue = this.props.optionValue || function(){return this.value;};
		const optionAttrs = this.props.optionAttrs || function(){return {};};
		const placeholder = this.props.placeholder ? <option>{this.props.placeholder}</option> : '';
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<select {...this.props} id={this.id} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className="form-control" disabled={this.props.disabled}>
					{placeholder}
					{this.props.options.map(function(item, index) {
						var label = optionLabel.bind(item)();
						var value = optionValue.bind(item)();
						var props = optionAttrs.bind(item)();
						return (
							<option key={index} {...props} value={value}>{label}</option>
						);
					})}
				</select>
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	}
});
/**
 * FormView defination
 */
var FormView = React.createClass({
	getInitialState() {
		const state = this.props.initialState || {};
		state['canSubmit'] = false;
		return state;
	},
	enableButton() {
		this.setState({
			canSubmit: true
		});
	},
	disableButton() {
		this.setState({
			canSubmit: false
		});
	},
	submit(model) {
		submitForm($(ReactDOM.findDOMNode(this)).find('form').get(0));
	},
	render : function() {
		const className = 'form-view ' + (this.props.className?this.props.className:'');
		const initialState = this.props.initialState;
		const formrender = this.props.formrender;
		const form = formrender.bind(this) ();
		return (
			<div className={className}>
				{form}
			</div>
		);
	}
});

FormView.Input = Input;
FormView.Form = Formsy.Form;

export default FormView;
