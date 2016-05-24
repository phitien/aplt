/**
 * SendActivationPage defination
 */
var SendActivationPage = React.createClass({
	mixins: [FormView, Mixin],
	render() {
		return (
			<Form className='form row' method='post' action='/code' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='email' required name='email' title={configurations.localization.email} validations='isEmail' 
						validationError={configurations.localization.invalid_email} />
					<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.send} className='center-block' />
				</div>
			</Form>
		); 
	}
});

module.exports = window.SendActivationPage = SendActivationPage;