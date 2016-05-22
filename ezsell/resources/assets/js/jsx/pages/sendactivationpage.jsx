/**
 * SendActivationPage defination
 */
var SendActivationPage = React.createClass({
	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_SENDACTIVATIONPAGE,
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
			<Form className='form row' method='post' action='/code' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<Input type='email' required name='email' title={localization.email} validations='isEmail' 
						validationError={localization.invalid_email} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.send} className='center-block' />
				</div>
			</Form>
		); 
	}
});

window.SendActivationPage = SendActivationPage;
export default window.SendActivationPage;