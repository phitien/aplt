/**
 * ChangeEmailPage defination
 */
var ChangeEmailPage = React.createClass({
	mixins: [createMixin(), FormView],
	render() {
		return (
			<Form className='form row' method='post' action='/email' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='password' required name='current_password' title={configurations.localization.password}
						 validationError={configurations.localization.password_required} />
					<Input type='email' required name='email' title={configurations.localization.email} validations={{
							isEmail: true,
							notEqualsIgnoreCase: appManager.user().email
						}} validationErrors={{
							isEmail: configurations.localization.invalid_email,
							notEqualsIgnoreCase: configurations.localization.new_email_should_be_different
						}} />
					<Input type='email' name='email_confirmation' title={configurations.localization.email_confirmation} validations='equalsField:email' 
						validationError={configurations.localization.email_confirmation_not_matched} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.change} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.ChangeEmailPage = ChangeEmailPage;