/**
 * ModeSwitch defination
 */
var ModeSwitch = React.createClass({
	mixins: [FormView],
	onMouseUp(e, checked) {
		setMode(checked ? 1 : 0);
		ajax.get(location.href, function( data ) {
			if (data && sessionManager.isListPage()) {
				if (data && data.data) {
					Dispatcher.emit(Dispatcher.Events.UPDATE_APPLICATION, data.data);
				}
			}
		});
	},
	render() { 
		return (
			<Form className='form' method='get' encType='multipart/form-data'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='switch' name='mode' title={localization.mode}
					defaultChecked={getMode() == sessionManager.get('MODES').SELL ? true : false} 
					checkedChildren={localization.sell}
    				unCheckedChildren={localization.buy}
    				onMouseUp={this.onMouseUp} />
			</Form>
		); 
	}
});

window.ModeSwitch = ModeSwitch;
export default window.ModeSwitch;