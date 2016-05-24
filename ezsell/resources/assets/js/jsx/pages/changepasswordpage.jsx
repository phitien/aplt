/**
 * ChangePasswordPage defination
 */
var ChangePasswordPage = React.createClass({
	mixins: [FormView, Mixin],
	render() {
		return (
			<Form className='form row' method='post' action='/password' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='password' required name='current_password' title={configurations.localization.current_password} 
						validationError={configurations.localization.password_required} />
					<Input type='password' required name='password' title='New password' validations={{
							notEqualsField: 'current_password',
							isPassword: true
						}} validationErrors={{
							notEqualsField: configurations.localization.new_password_should_be_different,
							isPasword: configurations.localization.password_rules,
						}} />
					<Input type='password' name='password_confirmation' title={configurations.localization.password_confirmation} validations='equalsField:password' 
						validationError={configurations.localization.password_confirmation_not_matched} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.change} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.ChangePasswordPage = ChangePasswordPage;