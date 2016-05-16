$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form row' method='post' action='/register' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='email' required name='email' title='Email' validations='isEmail' 
							validationError='This is not a valid email' />
						<FormView.Input type='email' name='email_confirmation' title='Email confirmation' validations='equalsField:email' 
							validationError='Email confirmation is not matched' />
						<FormView.Input type='password' required name='password' title='Password' validations='isPassword' 
							validationError='Password rules: Length between 6-30, at lease 1 lowercase character, 1 uppercase character, 1 number, 1 special character (!@#0^&*()+)' />
						<FormView.Input type='password' name='password_confirmation' title='Password confirmation' validations='equalsField:password' 
							validationError='Password confirmation is not matched' />
						<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Register' className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId));
});
