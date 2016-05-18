import CatItemsList from './catitemlist.jsx';
import UserItemsList from './useritemlist.jsx';
import ItemDetails from './itemdetails.jsx';
import Dispatcher from '../dispatcher/dispatcher.jsx';
//
window.Dispatcher = Dispatcher;
//
/**
 * Application defination
 */
var Application = React.createClass({
	getInitialState: function() {
		return {
			data: {}
		};
	},
	componentWillMount() {
		this.setState({
			data: data
		});
	},
	componentDidMount: function() {
		var me = this;
		Dispatcher.EventEmitter.on(Dispatcher.CHANGE_EVENT, function() {
			me.setState({
				data: data
			});
		});
		$('.datetimeformat').each(function () {
			var me = $(this);
			var text = me.text().trim();
			me.text((format.prettyDate(text) ? format.prettyDate(text) : '') + ' (' + format.date(text) + ')');
		});
		$('.currency-value').each(function () {
			var me = $(this);
			var text = me.text().trim();
			me.text(format.currency(text));
		});
	},
	componentWillUnmount: function() {
		Dispatcher.EventEmitter.removeListener(Dispatcher.CHANGE_EVENT, function() {
			
		});
	},
	render : function() {
		var data = this.state.data;
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

Application['Dispatcher'] = Dispatcher;

export default Application;