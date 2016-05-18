import CatItemsList from './catitemlist.jsx';
import UserItemsList from './useritemlist.jsx';
import ItemDetails from './itemdetails.jsx';
import Store from '../stores/store.jsx';
import Actions from '../actions/actions.jsx';
window.Actions = Actions;
/**
 * Application defination
 */
function getState() {
	return {
		data: Store.getAll()
	};
}
var Application = React.createClass({
	getInitialState: function() {
		return getState();
	},
	componentDidMount: function() {
		Store.addChangeListener(this._onChange);
		Actions.dispatch(data);
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
		Store.removeChangeListener(this._onChange);
	},
	_onChange: function() {
		this.setState(getState());
	},
	render : function() {
		var data = getState().data;
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