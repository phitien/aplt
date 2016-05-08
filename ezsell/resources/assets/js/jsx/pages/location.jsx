import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import Select from './../components/form/select.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView LocationView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/deactivate'
					onValidSubmit={this.submit}onValid={this.enableButton} onInvalid={this.disableButton}>
					<Select
						name={`fields[${i}]`}
						title={field.validations ? JSON.stringify(field.validations) : 'No validations'}
						required={field.required}
						validations={field.validations}
						options={[
						{title: '123', value: '123'},
						{title: 'some long text', value: 'some long text'},
						{title: '`empty string`', value: ''},
						{title: 'alpha42', value: 'alpha42'},
						{title: 'test@mail.com', value: 'test@mail.com'}
						]}
						/>
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Location' />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});
