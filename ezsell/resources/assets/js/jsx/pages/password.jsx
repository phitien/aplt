$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form row' method='post' action='/password' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='password' required name='current_password' title={localization.current_password} 
							validationError={localization.password_required} />
						<FormView.Input type='password' required name='password' title='New password' validations={{
								notEqualsField: 'current_password',
								isPassword: true
							}} validationErrors={{
								notEqualsField: localization.new_password_should_be_different,
								isPasword: localization.password_rules,
							}} />
						<FormView.Input type='password' name='password_confirmation' title={localization.password_confirmation} validations='equalsField:password' 
							validationError={localization.password_confirmation_not_matched} />
						<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.change} className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId));
});
