/**
 * CatMenu defination
 */
module.exports = window.CatMenu = React.createClass({
	mixins: [createMixin()],
	getText(data) {
		return data.details ? data.details.name : '';
	},
	getIcon(data) {
		if (!data.parent_id) 
			return 'ui-icon-triangle-1-s';
		else 
			return '';
	},
	getHref(data) {
		if (!data.parent_id) 
			return 'javascript:expandMenu(this)';
		else if (data.atomic) 
			return 'cat/' + (appManager.usecode() ? data.code.toLowerCase() : data.id);
		else 
			return '';
	},
	itemClick(data) {
		applicationSwitch(this.getHref(data));
	},
	getSubMenuClassName(data) {
		if (!data.parent_id) 
			return 'sensitive';
		return '';
	},
	componentDidMount() {
	},
	render() {
		const showRoot = this.attr('showRoot', true);
		var items = appManager.cats();
		items = showRoot ? items : items[0].children;
		return (
			<Menu className={this.className('catmenu')} items={items} 
				getText={this.getText} 
				getHref={this.getHref}
				getIcon={this.getIcon}
				itemClick={this.itemClick}
				getSubMenuClassName={this.getSubMenuClassName} />
		);
	}
});