$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form' method='post' action='/code' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='email' required name='email' title='Email' validations='isEmail' 
						validationError='This is not a valid email' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Send' />
				</FormView.Form>
			); 
		}
	}), document.getElementById('container'));
});
