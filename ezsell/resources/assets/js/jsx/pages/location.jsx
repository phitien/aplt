$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView LocationView',
		initialState : {
			value: '',
			locations: [],
			loading: false
		},
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/location'
					onValidSubmit={this.submit}onValid={this.enableButton} onInvalid={this.disableButton}>
					<Input type='text' autocomplete='true' required name='location' title='Location' source='/searchlocation' />
					<input type='hidden' name='redirect' value={location.href} />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'), function() {
		$('.autocomplete input:first').each(function (i,e) {
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
					this.setAttribute('data-value', ui.item);
					this.nextSibling.value = ui.item.id;
					submitForm($(this).parents('form:first'));
				}
			});
		});
	});
});
