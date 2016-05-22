/**
 * DeactivatePage defination
 */
var DeactivatePage = React.createClass({
	mixins: [FormView],
	eventName: Dispatcher.Events.UPDATE_DEACTIVATEPAGE,
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
			<Form className='form row' method='post' action='/deactivate' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
						<Input type='password' required name='current_password' title={localization.password} 
							validationError={localization.password_required} />
						<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={localization.deactivate} className='center-block' />
				</div>
			</Form>
		); 
	}
});

window.DeactivatePage = DeactivatePage;
export default window.DeactivatePage;