/**
 * Application defination
 */
var Application = React.createClass({
	eventName: Dispatcher.Events.UPDATE_APPLICATION,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.emit(this.eventName, sessionManager.rawdata());
		if (sessionManager.appMessage()) {
			showMessageDialog(sessionManager.appMessage());
		}
	},
	render() {
		const pageClassName = sessionManager.getCurrentPage();
		switch (pageClassName) {
			case 'HomePage':
				return (<HomePage />);
			case 'CatItemsPage':
				return (<CatItemsPage />);
			case 'UserItemsPage':
				return (<UserItemsPage />);
			case 'ItemDetailsPage':
				return (<ItemDetailsPage />);
			case 'ChangeLocationPage':
				return (<ChangeLocationPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'LoginPage':
				return (<LoginPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'RegisterPage':
				return (<RegisterPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'ChangeAccountPage':
				return (<ChangeAccountPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'ChangeEmailPage':
				return (<ChangeEmailPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'ChangePasswordPage':
				return (<ChangePasswordPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'SendActivationPage':
				return (<SendActivationPage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'DeactivatePage':
				return (<DeactivatePage className='col-xs-12 col-sm-6 col-md-5 center-block' />);
			case 'BuyItemPage':
				return (<BuyItemPage />);
			case 'SellItemPage':
				return (<SellItemPage />);
		}
		return null;
	}
});

window.Application = Application;
export default window.Application;