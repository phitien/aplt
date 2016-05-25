/**
 * ModeSwitch defination
 */
var ModeSwitch = React.createClass({
	mixins: [createMixin(), FormView],
	onMouseUp(e, checked) {
		mode(checked ? 1 : 0);
		applicationSwitch();
	},
	render() { 
		return (
			<Form className={this.className('', 'form')} method='get' encType='multipart/form-data'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='switch' name='mode' title={configurations.localization.mode}
					defaultChecked={mode() == appManager.get('MODES').SELL ? true : false} 
					checkedChildren={configurations.localization.sell}
    				unCheckedChildren={configurations.localization.buy}
    				onMouseUp={this.onMouseUp} />
			</Form>
		); 
	}
});

module.exports = window.ModeSwitch = ModeSwitch;