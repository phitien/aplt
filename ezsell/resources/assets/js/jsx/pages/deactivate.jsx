$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form' method='post' action='/deactivate' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='password' required name='current_password' title='Password' 
						validationError='Password is required' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Deactivate' />
				</FormView.Form>
			); 
		}
	}), document.getElementById('container'));
});
