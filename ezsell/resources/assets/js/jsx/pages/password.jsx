import Input from './../components/form/input.jsx';
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
		ReactDOM.findDOMNode(this).submit();
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/password'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='current_password' title='Current password' validations={{
						minLength: 6,
						maxLength: 30
					}} validationErrors={{
						minLength: 'Password should have at least 6 characters',
						maxLength: 'Password should not have more than 30 characters'
					}} />
				<Input type='password' required name='password' title='New password' validations={{
						notEqualsField: 'current_password',
						minLength: 6,
						maxLength: 30
					}} validationErrors={{
						notEqualsField: 'New password should not be the same as old one',
						minLength: 'Password should have at least 6 characters',
						maxLength: 'Password should not have more than 30 characters'
					}} />
				<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
					validationError='Password confirmation is not matched' />
				<button className='btn btn-default' type='submit' disabled={!this.state.canSubmit}>Change</button>
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
