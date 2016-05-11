$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() {
			var catoptions = [];
			$(cats).each(function(i, root) {
				$(root.children).each(function(j, cat) {
					$(cat.children).each(function(k, subcat) {
						catoptions.push({
							label: cat.details.name + ' >> ' + subcat.details.name,
							value: subcat.id
						});
					});
				});
			});
			var conditions = [{
				label: 'New',
				value: true,
				checked: true
			},{
				label: 'Used',
				value: false
			}];
			return (
				<FormView.Form className='form' method='post' action='/login' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<FormView.Input type='text' required name='title' title='Title' />
					<FormView.Input type='select' required name='parent_id' title='Category' 
						options={catoptions} placeholder='Select a category' />
					<FormView.Input type='number' name='originalprice' title='Original price' step='0.1' min='0' placeholder='1.0' />
					<FormView.Input type='number' name='saleprice' title='Sale price' step='0.1' min='0' placeholder='1.0' />
					<FormView.Input type='number' name='nowprice' title='Now price' step='0.1' min='0' placeholder='1.0' />
					<FormView.Input type='radiolist' name='condition' title='Condition' options={conditions} className='inline-block-list' />
					<FormView.Input type='textarea' name='description' title='Description' cols='10' rows='5' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Login' />
				</FormView.Form>
			); 
		}
	}), document.getElementById('container'));
});
