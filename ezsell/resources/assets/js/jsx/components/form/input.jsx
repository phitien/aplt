const Input = React.createClass({
	mixins: [Formsy.Mixin],
	changeValue(event) {
		const type = this.props.type;
		if (type == 'checkbox') {
			this.setValue(event.currentTarget['checked']);
		}
		else {
			this.setValue(event.currentTarget['value']);
		}
	},
	render() {
		const autocomplete = this.props.autocomplete || false;
		const type = this.props.type;
		const errorMessage = this.getErrorMessage();
		const source = this.props.source ? this.props.source : null;
		
		var className = (this.props.className || '') + ' ' +
			(this.showRequired() ? 'required' : this.showError() ? 'error' : ''); 
		
		var inputText;
		if (autocomplete) {
			className += ' form-group autocomplete ';
			inputText = <input type='text' data-source={source} onChange={this.changeValue} value={this.getValue()} className='form-control' />
		}
		else if (type == 'checkbox') {
			className += ' checkbox ';
			inputText = <label htmlFor={this.props.name}>
					<input type={type} name={this.props.name} onChange={this.changeValue} className='checkbox' checked={this.getValue() ? 'checked' : null} />
					{this.props.title}
				</label>;
		}
		else {
			className += ' form-group ';
			inputText = <input type={type} name={this.props.name} onChange={this.changeValue} value={this.getValue()} className='form-control' />;
		}
		
		var labelText = <label htmlFor={this.props.name}>{this.props.title}</label>;
		var hiddenText = <input type='hidden' name={this.props.name} />
		
		return (
			<div className={className}>
				{type != 'checkbox' ? labelText : ''}
				{inputText}
				{autocomplete ? hiddenText : ''}
				<span className='validation-error'>{errorMessage}</span>
			</div>
		);
	}
});

export default Input;