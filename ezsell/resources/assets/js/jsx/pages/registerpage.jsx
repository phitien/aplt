/**
 * RegisterPage defination
 */
var RegisterPage = React.createClass({
	mixins: [createMixin(), FormView],
	render() {
		return (
			<Form className='form row' method='post' action='/register' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='email' required name='email' title={configurations.localization.email} validations='isEmail' 
						validationError={configurations.localization.invalid_email} />
					<Input type='email' name='email_confirmation' title={configurations.localization.email_confirmation} validations='equalsField:email' 
						validationError={configurations.localization.email_confirmation_not_matched} />
					<Input type='password' required name='password' title={configurations.localization.password} validations='isPassword' 
						validationError={configurations.localization.password_rules} />
					<Input type='password' name='password_confirmation' title={configurations.localization.password_confirmation} validations='equalsField:password' 
						validationError={configurations.localization.password_confirmation_not_matched} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.register} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.RegisterPage = RegisterPage;