$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form row' method='post' action='/email' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='password' required name='current_password' title={localization.password}
							 validationError={localization.password_required} />
						<FormView.Input type='email' required name='email' title={localization.email} validations={{
								isEmail: true,
								notEqualsIgnoreCase: user.email
							}} validationErrors={{
								isEmail: localization.invalid_email,
								notEqualsIgnoreCase: localization.new_email_should_be_different
							}} />
						<FormView.Input type='email' name='email_confirmation' title={localization.email_confirmation} validations='equalsField:email' 
							validationError={localization.email_confirmation_not_matched} />
						<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.change} className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId));
});
