import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/password'  
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<Input type='password' required name='current_password' title='Current password' 
						validationError='Password is required' />
					<Input type='password' required name='password' title='New password' validations={{
							notEqualsField: 'current_password',
							isPassword: true
						}} validationErrors={{
							notEqualsField: 'New password should not be the same as old one',
							isPasword: 'Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)',
						}} />
					<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
						validationError='Password confirmation is not matched' />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Change' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
