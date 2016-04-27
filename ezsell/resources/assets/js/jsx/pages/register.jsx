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
				<Input type='email' required name='email' title='Email' validations='isEmail' 
					validationError='This is not a valid email' />
				<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
					validationError='Email confirmation is not matched'/>
				<Input type='password' required name='password' title='Password' validations={{
						minLength: 6,
						maxLength: 30
					}} validationErrors={{
						minLength: 'Password should have at least 6 characters',
						maxLength: 'Password should not have more than 30 characters'
					}} />
				<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
					validationError='Password confirmation is not matched' />
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
