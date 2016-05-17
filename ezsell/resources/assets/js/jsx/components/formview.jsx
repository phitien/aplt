import Formsy from 'formsy-react';
import Switch from './switch.jsx';
//

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
function _objectWithoutProperties(obj, keys) { var target = {}; for (var i in obj) { if (keys.indexOf(i) >= 0) continue; if (!Object.prototype.hasOwnProperty.call(obj, i)) continue; target[i] = obj[i]; } return target; }
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
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
		else if (type == 'switch') {
			value = event;
		}
		else if (type == 'textarea') {
			value = event.currentTarget.value;
		}
		else if (type == 'image') {
			var max = this.props.max ? this.props.max : 20;
			var min = this.props.min ? this.props.min : 1;
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
		this.className = 'form-group ' + (this.props.className || '') + ' ' + (this.showRequired() ? 'required' : this.showError() ? 'error' : '');
		this.type = this.props.type ? this.props.type.toLowerCase() : 'text';
		this.id = this.id ? this.id : this.props.id ? this.props.id : uuid(this.type + '_');
		
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
			<input id={this.id} type='hidden' name={this.props.name} value={this.getValue()||''} />
		);
	},
	renderText() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'onChange', 'id', 'value']);
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.id} type={this.type} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderAutocomplete() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'data-source']);
		var source = this.props.source ? this.props.source : null;
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.id} type='text' onChange={this.changeValue} value={this.getValue()||''} className='form-control autocomplete' 
					data-source={source}/>
				<input type='hidden' name={this.props.name} />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderCheckboxRadio() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value']);
		var name = this.props.name ? this.props.name : uuid('radiolist_');
		this.className += ' ' + this.type;
		var labelClassName = 'form-' + this.type + '-label';
		return (
			<div className={this.className}>
				<label className={labelClassName} htmlFor={name}>
					<input {...restProps} id={this.id} type={this.type} name={name} onChange={this.changeValue} className={this.type} />
					{this.props.title}
				</label>
			</div>
		);
	},
	renderCheckboxRadioList() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value']);
		var name = this.props.name ? this.props.name : uuid('radiolist_');
		var type = this.type == 'checkboxlist' ? 'checkbox' : 'radio';
		this.className += ' ' + this.type;
		var changeValue = this.changeValue;
		var labelClassName = 'form-' + type + '-label';
		return (
			<div className={this.className}>
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
		this.className = 'btn btn-default ' + (this.props.className?this.props.className:''); 
		return (
			<input {...restProps} id={this.id} name={this.props.name} type={this.type} value={this.getValue()||''} className={this.className} onClick={this.props.onClick} disabled={this.props.disabled} />
		);
	},
	renderTextarea() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'cols', 'rows']);
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<textarea {...restProps} id={this.id} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className='form-control'
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
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<select {...restProps} id={this.id} name={this.props.name} onChange={this.changeValue} value={this.getValue()||''} className="form-control" disabled={this.props.disabled}>
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
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.id} type={this.type} name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
				<span className='validation-error'>{this.getErrorMessage()}</span>
			</div>
		);
	},
	renderImage() {
		var restProps = _objectWithoutProperties(this.props, ['className', 'type', 'name', 'id', 'onChange', 'value', 'accept']);
		var name = this.props.multiple ? this.props.name + '[]' : this.props.name;
		return (
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<input {...restProps} id={this.id} type='file' name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' 
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
			<div className={this.className}>
				<label htmlFor={this.props.name}>{this.props.title}</label>
				<Switch {...restProps} id={this.id} name={name} onChange={this.changeValue} value={this.getValue()||''} className='form-control' />
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

FormView.showImagesPreview = function (input, previewContainer) {
	if (input.files && input.files.length > 0) {
		var cols = parseInt($(input).attr('cols')) != NaN ? parseInt($(input).attr('cols')) : 4;
		var cls = 1;
		if (cols==2||cols==3||cols==4||cols==6) {
			cls = 12/cols;
		}
		var name = input.name.replace('[]', '');
		var previewDiv = previewContainer ? $(input).parents('form').find(previewContainer) : $(input).parent().find('.image-preview');
		previewDiv.attr('data-file-id', input.id);
		previewDiv.html('');
		var count = 0;
		for (var i in input.files) {
			var item = input.files[i];
			if (item instanceof Blob) {
		        var reader = new FileReader();
		        reader.image = item;
		        reader.onload = function (e) {
		        	var img = new Image();
		        	img.image = this.image;
		        	img.onload = function (e) {
						var html = "<div class='image-preview-item col-xs-6 col-md-" + cls + "'>" + 
										"<input type='text' name='" + name + "-title[" + this.image.name + "]' placeholder='Caption' class='form-control' />" +
										"<img src='"+this.src+"' />" + 
										"<textarea name='" + name + "-description[" + this.image.name + "]' placeholder='Description' class='form-control' row='6'></textarea>" +
										"<div class='image-info'>(" + this.width +" x " + this.height + ")</div>" + 
										"<input class='btn btn-default image-remove' type='button' value='Remove' onclick='FormView.removeImagePreview(this)' />" +
									"</div>";		
				        if (count>0 && (count%cols==(cols-1))) {
				        	html += "<div class='clearfix'></div>";
				        }
				        previewDiv.append(html); 
			        	previewDiv.show();
			        	count++;
		        	};
		        	$(img).attr('src', this.result);
		        };
				reader.readAsDataURL(item);
			}
		}
    }
},
FormView.removeImagePreview = function(e) {
	var container = $(e).parent().parent();
	$(e).parent().remove();
	if (!container.find('.image-preview-item').length) {
		$('#' + container.attr('data-file-id')).val('');
	}
};
FormView.Input = Input;
FormView.Form = Formsy.Form;

export default FormView;
