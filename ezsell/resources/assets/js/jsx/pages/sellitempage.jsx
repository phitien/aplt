/**
 * SellItemPage defination
 */
var SellItemPage = React.createClass({
	mixins: [createMixin(), FormView],
	render() {
		var catoptions = [];
		$(appManager.cats([])).each(function(i, root) {
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
			label: configurations.localization.new,
			value: 1
		},{
			label: configurations.localization.used,
			value: 0
		}];
		return (
			<Form className={this.className('', 'form row')} method='post' action='/sellitem' encType='multipart/form-data'
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<div className="row">
					<Input type='select' required name='parent_id' title={configurations.localization.category} options={catoptions}  
						className='col-xs-6 col-md-5' placeholder={configurations.localization.select_category} />
					<Input type='image' required name='files' title={configurations.localization.images} cols='4' multiple min='1' max='12' 
						className='col-xs-6 col-md-3' previewContainer='.image-preview-container' />
					<Input type='radiolist' name='is_new' required title={configurations.localization.condition} options={conditions} 
						className='col-xs-6 col-md-4 inline-block-list' />
				</div>
				<div className="row">
					<Input type='text' required name='title' title={configurations.localization.title} 
						className='col-xs-6 col-md-5' placeholder={configurations.localization.title_hint} />
					<Input type='date' name='deleted_at' title={configurations.localization.expire} 
						className='col-xs-6 col-md-3' min={format.date(new Date(), 'yyyy-MM-dd')} />
					<Input type='number' name='originalprice' title={configurations.localization.original_price} 
						className='col-xs-6 col-md-2' step='0.1' min='0' placeholder='1.0' />
					<Input type='number' name='nowprice' title={configurations.localization.now_price} 
						className='col-xs-6 col-md-2' step='0.1' min='0' placeholder='1.0' />
				</div>
				<Input type='textarea' name='description' title={configurations.localization.description} cols='10' rows='4' placeholder={configurations.localization.description_hint} />
				<Input type='hidden' required name='is_selling' value='1' />
				<Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value={configurations.localization.sell} className='btn-fixed-right' />
				<div className='row image-preview image-preview-container'></div>
			</Form>
		); 
	}
});

module.exports = window.SellItemPage = SellItemPage;