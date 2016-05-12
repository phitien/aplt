$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		initialState : {
			value: '',
			locations: [],
			loading: false
		},
		onValidSubmit(model) {},
		formrender() {
			var currentLocationLabel = '';
			if (currentLocation) {
				currentLocationLabel = <label>Current: {currentLocation.name}</label>;
			}
			return (
				<FormView.Form className='form row' method='post' action='/location' autocomplete='off' onkeypress='return false;'
					onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						{currentLocationLabel}
						<FormView.Input type='autocomplete' name='location' title='Location' source='/searchlocation' className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(contentDivId), function() {
		$('.autocomplete').each(function (i,e) {
			var source = e.getAttribute('data-source');
			$(e).autocomplete({ 
				source: function( request, response ) {
					$.ajax({
						url: source,
						data: {
							q: request.term
						},
						success: function( data ) {
							var items = [];
							$.each(data.data, function (i, v) {
								items.push({
									id: i,
									label: v
								});
							});
							response(items);
						}
					});
				},
				minLength: 2,
				select: function (event, ui) {
					if (ui && ui.item) {
						this.setAttribute('data-value', ui.item);
						const id = ui.item.id;
						this.nextSibling.value = id;
						if (id && id != currentLocation.id)
							submitForm($(this).parents('form:first'));
					}
				}
			});
		});
	});
});
