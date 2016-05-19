$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		initialState : {
			value: '',
			locations: [],
			loading: false
		},
		onValidSubmit(model) {},
		formrender() {
			return (
				<FormView.Form className='form row' method='post' action='/location' autocomplete='off' onkeypress='return false;'
					onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='autocomplete' name='location' title={localization.location} source='/searchlocation' className='center-block' 
							value={currentLocation.name} placeholder={localization.please_type_location} />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId), function() {
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
						if (id && id != currentLocation.id)
							submitForm($(this).parents('form:first'));
					}
				}
			});
		});
	});
});
