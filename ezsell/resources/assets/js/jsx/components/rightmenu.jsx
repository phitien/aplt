/**
 * CatMenu defination
 */
module.exports = window.RightMenu = React.createClass({
	mixins: [createMixin()],
	itemClick(data) {
		applicationSwitch(data.href);
	},
	render() {
		const user = appManager.isLogged();
		var items = user ? [] : 
			[{
				text: configurations.localization.login,
				href: '/login'
			}, {
				text: configurations.localization.register,
				href: '/register'
			}, {
				text: configurations.localization.location,
				href: '/location'
			}];
		return (
			<Menu className={this.className('rightmenu')} items={items} itemClick={this.itemClick}></Menu>
		);
	}
});