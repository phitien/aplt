/**
 * CatMenu defination
 */
module.exports = window.RightMenu = React.createClass({
	mixins: [createMixin()],
	itemClick(data) {
		if (data.directLink)
			location.href = data.href;
		else
			applicationSwitch(data.href);
	},
	render() {
		const user = appManager.isLogged();
		var items = user ? 
			[{
				text: configurations.localization.inbox,
				href: '/inbox'
			}, {
				text: configurations.localization.buy,
				href: '/buyitem'
			}, {
				text: configurations.localization.sell,
				href: '/sellitem'
			}, {
				icon: 'ui-icon ui-icon-grip-dotted-horizontal',
				itemClick: function(e) {
					expandMenu(e.currentTarget);
				},
				children: [{
					text: configurations.localization.email,
					href: '/email'
				}, {
					text: configurations.localization.account,
					href: '/account'
				}, {
					text: configurations.localization.password,
					href: '/password'
				}, {
					text: configurations.localization.deactivate,
					href: '/deactivate'
				}, {
					text: configurations.localization.logout,
					directLink: true,
					href: '/logout'
				}]
			}] : 
			[{
				text: configurations.localization.login,
				href: '/login',
				itemClick: function(e) {
					var handler = function(data, stauts, response) {
						dialog.close();
						if (stauts == 'success') {
							if (window.applyConfigurations(data)) {
								
							}
						}
					};
					dialog.get({
						dialogClass: 'dialogNoTitle',
						open: function () {
							ReactDOM.render(<LoginPage ajax={true} callback={handler}></LoginPage>, document.getElementById('dialog'));
						},
					}).open();
				}
			}, {
				text: configurations.localization.register,
				href: '/register',
				itemClick: function(e) {
					var handler = function(response, stauts, errorMessage) {
						dialog.close();
					};
					dialog.get({
						dialogClass: 'dialogNoTitle',
						open: function () {
							ReactDOM.render(<RegisterPage ajax={true} callback={handler}></RegisterPage>, document.getElementById('dialog'));
						},
					}).open();
				}
			}, {
				text: configurations.localization.location,
				href: '/location',
				itemClick: function(e) {
					dialog.get({
						dialogClass: 'dialogNoTitle',
						open: function () {
							ReactDOM.render(<ChangeLocationPage ajax={true}></ChangeLocationPage>, document.getElementById('dialog'));
						},
					}).open();
				}
			}];
		return (
			<Menu className={this.className('rightmenu')} items={items} itemClick={this.itemClick}></Menu>
		);
	}
});