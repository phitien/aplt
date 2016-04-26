import Input from './../form/input.jsx';
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
		$.post( "/register", model )
		.done(function() {
			alert( "second success" );
		})
		.fail(function() {
			alert( "error" );
		})
		.always(function() {
			alert( "finished" );
		});
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/register' 
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' name='email' title='Email' validations='isEmail' validationError='This is not a valid email' required />
				<Input type='email' name='email_confirmation' title='Email confirmation' validations='isEmail' validationError='This is not a valid email' required />
				<Input type='password' name='password' title='Password' validationError='Required' required />
				<Input type='password' name='password_confirmation' title='Password confirmation' validationError='Required' required />
				<button className='ui-input-button' type='submit' disabled={!this.state.canSubmit}>Register</button>
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
