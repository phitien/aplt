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
				checked: 1
			},{
				label: 'Used',
				value: 0
			}];
			return (
				<FormView.Form className='form row' method='post' action='/newitem' 
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="row">
						<FormView.Input type='text' required name='title' title='Title' className='col-xs-6 col-md-8' />
						<FormView.Input type='select' required name='parent_id' title='Category' className='col-xs-6 col-md-4'  
							options={catoptions} placeholder='Select a category' />
					</div>
					<div className="row">
						<FormView.Input type='number' name='originalprice' title='Original price' className='col-xs-6 col-md-4' step='0.1' min='0' placeholder='1.0' />
						<FormView.Input type='number' name='saleprice' title='Sale price' className='col-xs-6 col-md-4' step='0.1' min='0' placeholder='1.0' />
						<FormView.Input type='number' name='nowprice' title='Now price' className='col-xs-6 col-md-4' step='0.1' min='0' placeholder='1.0' />
					</div>
					<FormView.Input type='radiolist' name='is_new' title='Condition' options={conditions} className='inline-block-list' />
					<FormView.Input type='textarea' name='description' title='Description' cols='10' rows='5' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Create' className='center-block' />
				</FormView.Form>
			); 
		}
	}), document.getElementById(contentDivId));
});
