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
				value: 1
			},{
				label: 'Used',
				value: 0
			}];
			return (
				<FormView.Form className='form row' method='post' action='/buyitem' encType='multipart/form-data'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="row">
						<FormView.Input type='select' required name='parent_id' title='Category' options={catoptions}  
							className='col-xs-6 col-md-5' placeholder='Select a category' />
						<FormView.Input type='image' required name='files' title='Images' cols='4' multiple min='1' max='12' 
							className='col-xs-6 col-md-3' previewContainer='.image-preview-container' />
						<FormView.Input type='radiolist' name='is_new' required title='Condition' options={conditions} 
							className='col-xs-6 col-md-4 inline-block-list' />
					</div>
					<div className="row">
						<FormView.Input type='text' required name='title' title='Title' 
							className='col-xs-6 col-md-5' placeholder='Please type some text for title (Required).'/>
						<FormView.Input type='date' name='deleted_at' title='Expire' 
							className='col-xs-6 col-md-3' min={format.date(new Date(), 'yyyy-MM-dd')} />
						<FormView.Input type='number' name='originalprice' title='Min price' 
							className='col-xs-6 col-md-2' step='0.1' min='0' placeholder='1.0' />
						<FormView.Input type='number' name='nowprice' title='Max price' 
							className='col-xs-6 col-md-2' step='0.1' min='0' placeholder='1.0' />
					</div>
					<FormView.Input type='textarea' name='description' title='Description' cols='10' rows='4' placeholder='Please type some text for description (Optional).'/>
					<FormView.Input type='hidden' required name='is_selling' value='0' />
					<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Buy' className='btn-fixed-right' />
					<div className='row image-preview image-preview-container'></div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(centerDivId));
});