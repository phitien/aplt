import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
//
var LoginForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/login'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' required name='email' title='Email' validations='isEmail' 
					validationError='This is not a valid email' />
				<Input type='password' required name='password' title='Password' 
					validationError='Password is required' />
				<Input type='checkbox' name='remember' title='Remember me' />
				<input type='hidden' name='redirect' value={location.href} />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Login' />
			</Formsy.Form>
		);
	}
});

var LoginView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView LoginView'>
				<LoginForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(LoginView), document.getElementById('container'));
