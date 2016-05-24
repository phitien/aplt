/**
 * LoginPage defination
 */
var LoginPage = React.createClass({
	mixins: [FormView, Mixin],
	render() {
		return (
			<Form className='form row' method='post' action='/login' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='email' required name='email' title={configurations.localization.email} validations='isEmail' 
						validationError={configurations.localization.invalid_email} value='user@gmail.com' />
					<Input type='password' required name='password' title={configurations.localization.password} 
						validationError={configurations.localization.password_required} value='user12' />
					<Input type='checkbox' name='remember' title={configurations.localization.remember_me} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.login} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.LoginPage = LoginPage;