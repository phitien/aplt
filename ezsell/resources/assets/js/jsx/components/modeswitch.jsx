/**
 * ModeSwitch defination
 */
var ModeSwitch = React.createClass({
	mixins: [FormView],
	onMouseUp(e, checked) {
		setMode(checked ? 1 : 0);
		ajax.get(location.href, function( _data ) {
			if (_data && sessionManager.isListPage()) {
				if (_data && _data.data) {
					Dispatcher.emit(Dispatcher.Events.UPDATE_APPLICATION, _data.data);
				}
			}
		});
	},
	render() { 
		return (
			<FormView.Form className='form' method='get' encType='multipart/form-data'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<FormView.Input type='switch' name='mode' title={localization.mode}
					defaultChecked={getMode() == sessionManager.get('MODES').SELL ? true : false} 
					checkedChildren={localization.sell}
    				unCheckedChildren={localization.buy}
    				onMouseUp={this.props.onMouseUp} />
			</FormView.Form>
		); 
	}
});

window.ModeSwitch = ModeSwitch;
export default window.ModeSwitch;