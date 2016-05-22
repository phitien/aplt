/**
 * ChangeAccountPage defination
 */
var ChangeAccountPage = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHANGEACCOUNTPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	formrender() { 
		const className = util.getClassName(this.props);
		return (
			<FormView.Form className='form row' method='post' action='/account' 
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<FormView.Input type='password' required name='current_password' title={localization.password} 
						 validationError={localization.password_required} />
					<FormView.Input type='text' required name='name' title={localization.account} validations={{
							notEqualsIgnoreCase: sessionManager.user.name,
							isAccountName: true
						}} validationErrors={{
							notEqualsIgnoreCase: localization.new_account_should_be_different,
							isAccountName: localization.invalid_account
						}} />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.change} className='center-block' />
				</div>
			</FormView.Form>
		); 
	},
	render(){
		const className = 'change-account-form ' + util.getAttr(this.props, 'className', '');
		return (
			<FormView className={className} formrender={this.formrender} />
		);
	}
});

window.ChangeAccountPage = ChangeAccountPage;
export default window.ChangeAccountPage;