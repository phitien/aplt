/**
 * CatMenu defination
 */
module.exports = window.CatMenu = React.createClass({
	mixins: [createMixin()],
	getText(_item) {
		return _item.details ? _item.details.name : '';
	},
	getHref(_item) {
		if (!_item.parent_id) 
			return 'javascript:expandMenu(this)';
		else if (_item.atomic) 
			return 'cat/' + (appManager.usecode() ? _item.code.toLowerCase() : _item.id);
		else 
			return '';
	},
	itemClick(data) {
		applicationSwitch(this.getHref(data));
	},
	getSubMenuClassName(_item) {
		if (!_item.parent_id) 
			return 'sensitive';
		return '';
	},
	render() {
		const showRoot = this.attr('showRoot', true);
		var items = appManager.cats();
		items = showRoot ? items : items[0].children;
		return (
			<Menu className={this.className('catmenu')} items={items} 
				getText={this.getText} 
				getHref={this.getHref}
				itemClick={this.itemClick}
				getSubMenuClassName={this.getSubMenuClassName} />
		);
	}
});