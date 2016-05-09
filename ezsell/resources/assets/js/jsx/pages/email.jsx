import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
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
					<input type='hidden' name='redirect' value={location.href} />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Change' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
