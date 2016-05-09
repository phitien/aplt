import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/code'  
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<Input type='email' required name='email' title='Email' validations='isEmail' 
						validationError='This is not a valid email' />
					<input type='hidden' name='redirect' value={location.href} />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Send' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
