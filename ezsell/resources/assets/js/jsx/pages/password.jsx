import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
//
var PasswordForm = React.createClass({
	getInitialState() {
		return {
			canSubmit: false
		}
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
		submitForm(ReactDOM.findDOMNode(this));
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/password'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='current_password' title='Current password' 
					validationError='Password is required' />
				<Input type='password' required name='password' title='New password' validations={{
						notEqualsField: 'current_password',
						isPassword: true
					}} validationErrors={{
						notEqualsField: 'New password should not be the same as old one',
						isPasword: 'Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)',
					}} />
				<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
					validationError='Password confirmation is not matched' />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Change' />
			</Formsy.Form>
		);
	}
});

var PasswordView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView PasswordView'>
				<PasswordForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(PasswordView), document.getElementById('container'));
