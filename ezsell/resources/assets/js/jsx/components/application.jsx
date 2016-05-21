import CatItemsList from './catitemlist.jsx';
import UserItemsList from './useritemlist.jsx';
import ItemDetails from './itemdetails.jsx';

import Dispatcher from '../dispatcher/dispatcher.jsx';
//
/**
 * Application defination
 */
var Application = React.createClass({
	eventName: Dispatcher.Events.UPDATE_APPLICATION,
	refreshCount: 0,
	refresh() {this.setState({refreshCount: this.refreshCount++});},
	componentWillUnmount() {
		Dispatcher.EventEmitter.removeListener(this.eventName, function() {});
	},
	componentDidMount() {
		Dispatcher.EventEmitter.on(this.eventName, this.refresh);
		Dispatcher.emit(this.eventName, sessionManager.get('rawdata'));
	},
	render() {
		const data = Dispatcher.Store.get(this.eventName);
		if (data) {
			if (data.catitems) {
				return (
					<CatItemsList className='item-block-prices' />
				);
			}
			else if (data.useritems) {
				return (
					<UserItemsList className='item-block-prices' />
				);
			}
			if (data.itemdetails) {
				return (
					<ItemDetails className='item-block-prices' />
				);
			}
		}
		return null;
	}
});

export default Application;