import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/register' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<Input type='email' required name='email' title='Email' validations='isEmail' 
						validationError='This is not a valid email' />
					<Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
						validationError='Email confirmation is not matched' />
					<Input type='password' required name='password' title='Password' validations='isPassword' 
						validationError='Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' />
					<Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
						validationError='Password confirmation is not matched' />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Register' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
