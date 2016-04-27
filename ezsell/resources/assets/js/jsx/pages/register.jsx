import Input from './../components/form/input.jsx';
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
		ReactDOM.findDOMNode(this).submit();
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/register'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' name='email' title='Email' validations='isEmail' validationError='This is not a valid email' required />
				<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' validationError='Email is not matched' required />
				<Input type='password' name='password' title='Password' validations={{ matchRegexp: /.{6,}/}} validationError='Password is required, min 6 letters' required />
				<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' validationError='Password is not matched' required />
				<button className='btn btn-default' type='submit' disabled={!this.state.canSubmit}>Register</button>
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
