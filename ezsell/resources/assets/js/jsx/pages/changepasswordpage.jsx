/**
 * ChangePasswordPage defination
 */
var ChangePasswordPage = React.createClass({
	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_CHANGPASSWORDPAGE,
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
			<Form className='form row' method='post' action='/password' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<Input type='password' required name='current_password' title={localization.current_password} 
						validationError={localization.password_required} />
					<Input type='password' required name='password' title='New password' validations={{
							notEqualsField: 'current_password',
							isPassword: true
						}} validationErrors={{
							notEqualsField: localization.new_password_should_be_different,
							isPasword: localization.password_rules,
						}} />
					<Input type='password' name='password_confirmation' title={localization.password_confirmation} validations='equalsField:password' 
						validationError={localization.password_confirmation_not_matched} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.change} className='center-block' />
				</div>
			</Form>
		); 
	}
});

window.ChangePasswordPage = ChangePasswordPage;
export default window.ChangePasswordPage;