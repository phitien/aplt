import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
//
var AccountForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/account'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='current_password' title='Password' 
					 validationError='Password is required' />
				<Input type='text' required name='name' title='Account' validations={{
						notEqualsIgnoreCase: user.name,
						isAccountName: true
					}} validationErrors={{
						notEqualsIgnoreCase: 'New account should be different',
						isAccountName: 'Account name is not valid'
					}} />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Change' />
			</Formsy.Form>
		);
	}
});

var AccountView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView AccountView'>
				<AccountForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(AccountView), document.getElementById('container'));
