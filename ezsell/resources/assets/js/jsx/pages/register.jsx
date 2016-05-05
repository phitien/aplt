import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
//
var RegisterForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/register'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' required name='email' title='Email' validations='isEmail' 
					validationError='This is not a valid email' />
				<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
					validationError='Email confirmation is not matched' />
				<Input type='password' required name='password' title='Password' validations='isPassword' 
					validationError='Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' />
				<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
					validationError='Password confirmation is not matched' />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Register' />
			</Formsy.Form>
		);
	}
});

var RegisterView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView RegisterView'>
				<RegisterForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(RegisterView), document.getElementById('container'));
