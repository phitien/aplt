const Input = React.createClass({
	mixins: [Formsy.Mixin],
	changeValue(event) {
		this.setValue(event.currentTarget[this.props.type === 'checkbox' ? 'checked' : 'value']);
	},
	render() {
		const className = (this.props.type === 'checkbox'?'checkbox':'form-group') + ' ' +  (this.props.className || '') + ' ' +
			(this.showRequired() ? 'required' : this.showError() ? 'error' : '');
		const errorMessage = this.getErrorMessage();
		var inputText = <input
					type={this.props.type || 'text'}
					name={this.props.name}
					onChange={this.changeValue}
					value={this.getValue()}
					className={(this.props.type === 'checkbox'?'checkbox':'form-control')}
					checked={this.props.type === 'checkbox' && this.getValue() ? 'checked' : null}
				/>;
		var beforeText;
		if (this.props.type === 'checkbox') {
			inputText = <label htmlFor={this.props.name}><input
					type={this.props.type || 'text'}
					name={this.props.name}
					onChange={this.changeValue}
					value={this.getValue()}
					className={(this.props.type === 'checkbox'?'checkbox':'form-control')}
					checked={this.props.type === 'checkbox' && this.getValue() ? 'checked' : null}
				/>{this.props.title}</label>;
		} else {
			beforeText = <label htmlFor={this.props.name}>{this.props.title}</label>;
		}
		
		return (
			<div className={className}>
				{beforeText}
				{inputText}
				<span className='validation-error'>{errorMessage}</span>
			</div>
		);
	}
});

export default Input;