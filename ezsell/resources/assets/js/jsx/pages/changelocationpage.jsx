/**
 * ChangeLocationPage defination
 */
var ChangeLocationPage = React.createClass({
	mixins: [FormView, Mixin],
	getInitialState() {
		return {
			value: '',
			locations: [],
			loading: false
		};
	},
	onValidSubmit(model) {},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		$('.autocomplete').each(function (i,e) {
			var source = e.attribute('data-source');
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
						if (id && id != appManager.location().id)
							submitForm($(this).parents('form:first'));
					}
				}
			});
		});
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