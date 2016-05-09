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
					<Input autocomplete='true' required name='location' title='Location' source='/location' />
					<input type='hidden' name='redirect' value={location.href} />
					<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Set location' />
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
							$.each(data.data, function (i, a) {
								a.label = a.fullname;
								items.push(a);
							});
							response(items);
						}
					});
				},
				minLength: 2,
				select: function (event, ui) {
					this.setAttribute('data-value', ui.item);
					this.nextSibling.value = ui.item.id;
				}
			});
		});
	});
});
