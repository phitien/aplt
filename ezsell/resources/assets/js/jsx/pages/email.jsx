import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
//
var EmailForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/email'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='current_password' title='Password' 
					 validationError='Password is required' />
				<Input type='email' required name='email' title='Email' validations={{
						isEmail: true,
						notEqualsIgnoreCase: user.email
					}} validationErrors={{
						isEmail: 'Email is not valid',
						notEqualsIgnoreCase: 'New email should be different'
					}} />
				<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
					validationError='Email confirmation is not matched' />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Change' />
			</Formsy.Form>
		);
	}
});

var EmailView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView EmailView'>
				<EmailForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(EmailView), document.getElementById('container'));
