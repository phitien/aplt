import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
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
	}), document.getElementById('container'));
});
