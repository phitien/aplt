/**
 * DeactivatePage defination
 */
var DeactivatePage = React.createClass({
	mixins: [FormView, Mixin],
	render() {
		return (
			<Form className='form row' method='post' action='/deactivate' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
						<Input type='password' required name='current_password' title={configurations.localization.password} 
							validationError={configurations.localization.password_required} />
						<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.deactivate} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.DeactivatePage = DeactivatePage;