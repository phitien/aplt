/**
 * ChangeEmailPage defination
 */
var ChangeEmailPage = React.createClass({
	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_LOGINPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render() {
		const className = util.getClassName(this.props);
		return (
			<Form className='form row' method='post' action='/email' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<Input type='password' required name='current_password' title={localization.password}
						 validationError={localization.password_required} />
					<Input type='email' required name='email' title={localization.email} validations={{
							isEmail: true,
							notEqualsIgnoreCase: sessionManager.user().email
						}} validationErrors={{
							isEmail: localization.invalid_email,
							notEqualsIgnoreCase: localization.new_email_should_be_different
						}} />
					<Input type='email' name='email_confirmation' title={localization.email_confirmation} validations='equalsField:email' 
						validationError={localization.email_confirmation_not_matched} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.change} className='center-block' />
				</div>
			</Form>
		); 
	}
});

window.ChangeEmailPage = ChangeEmailPage;
export default window.ChangeEmailPage;