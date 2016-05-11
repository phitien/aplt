$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form' method='post' action='/login' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='email' required name='email' title='Email' validations='isEmail' 
						validationError='This is not a valid email' />
					<FormView.Input type='password' required name='password' title='Password' 
						validationError='Password is required' />
					<FormView.Input type='checkbox' name='remember' title='Remember me' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Login' />
				</FormView.Form>
			); 
		}
	}), document.getElementById('container'));
});
