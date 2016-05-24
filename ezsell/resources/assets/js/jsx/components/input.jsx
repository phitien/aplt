import Formsy from 'formsy-react';
import Switch from '../components/switch.jsx';
//
function _objectWithoutProperties(obj, keys) { var target = {}; for (var i in obj) { if (keys.indexOf(i) >= 0) continue; if (!Object.prototype.hasOwnProperty.call(obj, i)) continue; target[i] = obj[i]; } return target; }
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
		if (value && value.length >= minLength && value.length <= maxLength) {// check
																				// min
																				// &
																				// max
																				// length
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
		if (value && value.length >= minLength && value.length <= maxLength) {// check
																				// min
																				// &
																				// max
																				// length
			return reg.test(value.toLowerCase());
		} 
	} catch(e) {
	}
	return false;
});
/**
 * Form defination
 */
window.Form = Formsy.Form;
/**
 * Input defination
 */
module.exports = window.Input = React.createClass({
	mixins: [Mixin, Formsy.Mixin],
	type: 'text',
	changeValue(event) {
		const type = this.props.type;
		var value;
		if (type == 'checkbox') {
			value = event.currentTarget.checked;
		}
		else if (type == 'switch') {
			value = event;
		}
		else if (type == 'textarea') {
			value = event.currentTarget.value;
		}
		else if (type == 'image') {
			var max = this.attr('max', 20);
			var min = this.attr('min', 1);
			if (event.currentTarget.files.length < min || event.currentTarget.files.length > max) {
				event.currentTarget.value = null;
				showMessageDialog('You should select at least ' + min + ' file, and no more than ' + max + ' files');
			}
			else {
				FormView.showImagesPreview(event.currentTarget, this.props.previewContainer);
			}
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
		this.type = this.attr('type', 'text').toLowerCase();
		
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
			case 'file':
				return this.renderFile();
			case 'image':
				return this.renderImage();
			case 'switch':
				return this.renderSwitch();
			case 'text':
			default:
				return this.renderText();
		}
	},
	renderHidden() {
		return (
			<input id={this.getId()} type='hidden' name={this.props.name} value={this.getValue()||''} />
		);
	},
	formsyClassName() {
		return this.className('', 'form-group', this.showRequired() ? 'required' : this.showError() ? 'error' : '');
	},
	renderText() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'onChange', 'id', 'value']);
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.getId()} type={this.type} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderAutocomplete() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'data-source']);
		var source = this.props.source ? this.props.source : null;
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.getId()} type='text' onChange={this.changeValue} value={this.getValue()||''} className='form-control autocomplete' 
					data-source={source}/>
				<input type='hidden' name={this.props.name} />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderCheckboxRadio() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value']);
		var name = this.props.name ? this.props.name : util.uuid('radiolist_');
		var labelClassName = 'form-' + this.type + '-label';
		return (
			<div className={this.formsyClassName() + ' ' + this.type}>
				<label className={labelClassName} htmlFor={name}>
					<input {...restProps} id={this.getId()} type={this.type} name={name} onChange={this.changeValue} className={this.type} />
					{this.props.title}
				</label>
			</div>
		);
	},
	renderCheckboxRadioList() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value']);
		var name = this.props.name ? this.props.name : util.uuid('radiolist_');
		var type = this.type == 'checkboxlist' ? 'checkbox' : 'radio';
		var changeValue = this.changeValue;
		var labelClassName = 'form-' + type + '-label';
		return (
			<div className={this.formsyClassName() + ' ' + this.type}>
				<label className={labelClassName}>{this.props.title}</label>
				{this.props.options.map(function(item, i) {
					var itemname = name + '['+i+']';
					var value = item.value;
					var itemClassName = type + (i==0 ? ' first-' + type : '');
					return (
						<div className={itemClassName} key={i}>
							<label htmlFor={itemname}>
								<input {...restProps} type={type} name={name} id={itemname} value={value} className={type} onChange={changeValue} />
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
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'onClick', 'disabled']);
		return (
			<input {...restProps} id={this.getId()} name={this.props.name} type={this.type} value={this.getValue()||''} 
				className={this.className('', 'btn btn-default')} onClick={this.props.onClick} disabled={this.props.disabled} />
		);
	},
	renderTextarea() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'cols', 'rows']);
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<textarea {...restProps} id={this.getId()} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control'
					cols={this.props.cols} rows={this.props.rows}></textarea>
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderSelect() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'disabled']);
		const optionLabel = this.props.optionLabel || function(){return this.label;};
		const optionValue = this.props.optionValue || function(){return this.value;};
		const optionAttrs = this.props.optionAttrs || function(){return {};};
		const placeholder = this.props.placeholder ? <option>{this.props.placeholder}</option> : '';
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<select {...restProps} id={this.getId()} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className="form-control" disabled={this.props.disabled}>
					{placeholder}
					{this.props.options.map(function(item, i) {
						var label = optionLabel.bind(item)();
						var value = optionValue.bind(item)();
						var props = optionAttrs.bind(item)();
						return (
							<option key={i} {...props} value={value}>{label}</option>
						);
					})}
				</select>
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderFile() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value']);
		var name = this.props.multiple ? this.props.name + '[]' : this.props.name;
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.getId()} type={this.type} name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderImage() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'accept']);
		var name = this.props.multiple ? this.props.name + '[]' : this.props.name;
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.getId()} type='file' name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' 
					accept='image/*' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
				<div className='row image-preview'></div>
			</div>
		);
	},
	renderSwitch() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'accept']);
		var name = this.props.multiple ? this.props.name + '[]' : this.props.name;
		return (
			<div className={this.formsyClassName()}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<Switch {...restProps} id={this.getId()} name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	}
});