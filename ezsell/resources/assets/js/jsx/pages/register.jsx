$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form row' method='post' action='/register' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='email' required name='email' title={localization.email} validations='isEmail' 
							validationError={localization.invalid_email} />
						<FormView.Input type='email' name='email_confirmation' title={localization.email_confirmation} validations='equalsField:email' 
							validationError={localization.email_confirmation_not_matched} />
						<FormView.Input type='password' required name='password' title={localization.password} validations='isPassword' 
							validationError={localization.password_rules} />
						<FormView.Input type='password' name='password_confirmation' title={localization.password_confirmation} validations='equalsField:password' 
							validationError={localization.password_confirmation_not_matched} />
						<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.register} className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId));
});
