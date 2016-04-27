import Input from './../components/form/input.jsx';
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
		ReactDOM.findDOMNode(this).submit();
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/login'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' required name='email' title='Email' validations='isEmail' 
					validationError='This is not a valid email' />
				<Input type='password' required name='password' title='Password' validations={{
						minLength: 6,
						maxLength: 30
					}} validationErrors={{
						minLength: 'Password should have at least 6 characters',
						maxLength: 'Password should not have more than 30 characters'
					}} />
				<Input type='checkbox' name='remember' title='Remember me' />
				<input type='hidden' name='redirect' value={location.href} />
				<button className='btn btn-default' type='submit' disabled={!this.state.canSubmit}>Login</button>
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
