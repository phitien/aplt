/**
 * ChangeLocationPage defination
 */
var ChangeLocationPage = React.createClass({
	mixins: [createMixin(), FormView],
	getInitialState() {
		return {
			value: '',
			locations: [],
			loading: false
		};
	},
	onValidSubmit(model) {},
	eventName: AppEvents.UPDATE_LOCATION,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render() {
		return (
			<Form className='form row' method='post' action='/location' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={this.className()}>
					<Input type='autocomplete' name='location' title={configurations.localization.location} source='/searchlocation' className='center-block' 
						value={appManager.location().name} placeholder={configurations.localization.please_type_location} />
				</div>
			</Form>
		); 
	}
});

module.exports = window.ChangeLocationPage = ChangeLocationPage;