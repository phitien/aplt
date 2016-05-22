/**
 * ChangeLocationPage defination
 */
var ChangeLocationPage = React.createClass({
	mixins: [FormView],
	getInitialState() {
		return {
			value: '',
			locations: [],
			loading: false
		};
	},
	onValidSubmit(model) {},
	eventName: Dispatcher.Events.UPDATE_CHANGELOCATIONPAGE,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		$('.autocomplete').each(function (i,e) {
			var source = e.getAttribute('data-source');
			$(e).autocomplete({ 
				source: function( request, response ) {
					$.ajax({
						url: source,
						data: {
							q: request.term
						},
						success: function( _data ) {
							var items = [];
							$.each(_data.data, function (i, v) {
								items.push({
									id: v.id,
									label: v.fullname
								});
							});
							response(items);
						}
					});
				},
				minLength: 2,
				select: function (event, ui) {
					if (ui && ui.item) {
						$(this).attr('data-value', ui.item);
						const id = ui.item.id;
						this.nextSibling.value = id;
						if (id && id != sessionManager.location().id)
							submitForm($(this).parents('form:first'));
					}
				}
			});
		});
	},
	render() {
		const className = util.getClassName(this.props);
		return (
			<Form className='form row' method='post' action='/location' autocomplete='off' onkeypress='return event.keyCode != 13;'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className={className}>
					<Input type='autocomplete' name='location' title={localization.location} source='/searchlocation' className='center-block' 
						value={sessionManager.location().name} placeholder={localization.please_type_location} />
				</div>
			</Form>
		); 
	}
});

window.ChangeLocationPage = ChangeLocationPage;
export default window.ChangeLocationPage;