module.exports = window.ItemDates = {		
	getItemExpires(item) {
		return item.deleted_at ? 
				<div className='item-date item-expired'>
						<a><span className='label expired-label'>{configurations.localization.expires_at}</span><span className='prettydateformat'>{item.deleted_at}</span></a>
				</div> : null;
	},
	getItemPostedOrEdited(item) {
		var created = new Date(item.created_at);
		var updated = new Date(item.updated_at);
		return (+updated !== +created) ? 
					<div className='item-date item-updated'>
						<a><span className='label edited-label'>{configurations.localization.edited_at}</span><span className='prettydateformat'>{item.updated_at}</span></a>
					</div> : 
					<div className='item-date item-created'>
						<a><span className='label posted-label'>{configurations.localization.posted_at}</span><span className='prettydateformat'>{item.created_at}</span></a>
					</div>;
	}
};
