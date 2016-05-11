$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form' method='post' action='/account' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='password' required name='current_password' title='Password' 
						 validationError='Password is required' />
					<FormView.Input type='text' required name='name' title='Account' validations={{
							notEqualsIgnoreCase: user.name,
							isAccountName: true
						}} validationErrors={{
							notEqualsIgnoreCase: 'New account should be different',
							isAccountName: 'Account name is not valid'
						}} />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Change' />
				</FormView.Form>
			); 
		}
	}), document.getElementById('container'));
});
