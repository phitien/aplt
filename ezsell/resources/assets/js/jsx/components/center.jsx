/**
 * Center defination
 */
var Center = React.createClass({
	id: 'center',
	mixins: [Mixin],
	eventName : AppEvents.UPDATE_CENTER,
	refreshCount : 0,
	refresh : function() {
		this.setState({
			refreshCount : this.refreshCount++
		});
	},
	componentWillUnmount : function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount : function() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render : function() {
		var showCenter = 12 - appManager.showLeft() - appManager.showRight();
		var data = appManager.data();
		var content;
		switch (appManager.type()) {
		case 'HomePage':
			content = <HomePage />;
			break;
		case 'CatItemsPage':
			content = <CatItemsPage />;
			break;
		case 'UserItemsPage':
			content = <UserItemsPage />;
			break;
		case 'ItemDetailsPage':
			content = <ItemDetailsPage />;
			break;
		case 'ChangeLocationPage':
			content = <ChangeLocationPage className='col-xs-12 col-sm-6 col-md-5 center-block'></ChangeLocationPage>
			break;
		case 'LoginPage':
			content = <LoginPage className='col-xs-12 col-sm-6 col-md-5 center-block'></LoginPage>;
			break;
		case 'RegisterPage':
			content = <RegisterPage className='col-xs-12 col-sm-6 col-md-5 center-block'></RegisterPage>;
			break;
		case 'ChangeAccountPage':
			content = <ChangeAccountPage className='col-xs-12 col-sm-6 col-md-5 center-block'></ChangeAccountPage>;
			break;
		case 'ChangeEmailPage':
			content = <ChangeEmailPage className='col-xs-12 col-sm-6 col-md-5 center-block'></ChangeEmailPage>;
			break;
		case 'ChangePasswordPage':
			content = <ChangePasswordPage className='col-xs-12 col-sm-6 col-md-5 center-block'></ChangePasswordPage>;
			break;
		case 'SendActivationPage':
			content = <SendActivationPage className='col-xs-12 col-sm-6 col-md-5 center-block'></SendActivationPage>;
			break;
		case 'DeactivatePage':
			content = <DeactivatePage className='col-xs-12 col-sm-6 col-md-5 center-block'></DeactivatePage>;
			break;
		case 'BuyItemPage':
			content = <BuyItemPage />;
			break;
		case 'SellItemPage':
			content = <SellItemPage />;
			break;
		}

		return (
			<div className={this.className('col-xs-12 col-sm-6 col-md-' + showCenter)} id={this.getId()}>
				{content}
			</div>
		);
		return null;
	}
});

module.exports = window.Center = Center;