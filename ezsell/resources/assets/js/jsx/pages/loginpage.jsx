/**
 * LoginPage defination
 */
var LoginPage = React.createClass({
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
			<FormView.Form className='form row' method='post' action='/login' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<FormView.Input type='email' required name='email' title={localization.email} validations='isEmail' 
						validationError={localization.invalid_email} value='im.phitien@gmail.com'/>
					<FormView.Input type='password' required name='password' title={localization.password} 
						validationError={localization.password_required} />
					<FormView.Input type='checkbox' name='remember' title={localization.remember_me} />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.login} className='center-block' />
				</div>
			</FormView.Form>
		); 
	}
});

window.LoginPage = LoginPage;
export default window.LoginPage;