import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/deactivate'  
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<Input type='password' required name='current_password' title='Password' 
						validationError='Password is required' />
					<input type='hidden' name='redirect' value={location.href} />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Deactivate' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
