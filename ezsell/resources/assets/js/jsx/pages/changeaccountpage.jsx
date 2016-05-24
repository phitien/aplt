/**
 * ChangeAccountPage defination
 */
var ChangeAccountPage = React.createClass({
	mixins: [FormView, Mixin],
	render() { 
		return (
			<Form className='form row' method='post' action='/account' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='password' required name='current_password' title={configurations.localization.password} 
						 validationError={configurations.localization.password_required} />
					<Input type='text' required name='name' title={configurations.localization.account} validations={{
							notEqualsIgnoreCase: appManager.user.name,
							isAccountName: true
						}} validationErrors={{
							notEqualsIgnoreCase: configurations.localization.new_account_should_be_different,
							isAccountName: configurations.localization.invalid_account
						}} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.change} className='center-block'/>
				</div>
			</Form>
		); 
	}
});

module.exports = window.ChangeAccountPage = ChangeAccountPage;