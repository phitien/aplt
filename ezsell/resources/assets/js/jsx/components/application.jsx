import CatItemsList from './catitemlist.jsx';
import UserItemsList from './useritemlist.jsx';
import ItemDetails from './itemdetails.jsx';

import Dispatcher from '../dispatcher/dispatcher.jsx';
//
/**
 * Application defination
 */
var Application = React.createClass({
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.events.APPL_EVENT, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(Dispatcher.events.APPL_EVENT, this.refresh);
		ui.plugins.format($(ReactDOM.findDOMNode(this)));
	},
	render() {
		var data = sessionManager.get('data');
		if (data) {
			if (data.catitems) {
				return (
					<CatItemsList data={data} className='item-block-prices' />
				);
			}
			else if (data.useritems) {
				return (
					<UserItemsList data={data} className='item-block-prices' />
				);
			}
			if (data.itemdetails) {
				return (
					<ItemDetails data={data} className='item-block-prices' />
				);
			}
		}
		return null;
	}
});

export default Application;