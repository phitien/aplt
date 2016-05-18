import Dispatcher from '../dispatcher/dispatcher.jsx';
import Constants from '../constants/constants.jsx';
//
export default {
	dispatch: function(data) {
		if (data) {
			if (data.catitems) {
				this.catitems(data);
			}
			else if (data.useritems) {
				this.useritems(data);
			}
			else if (data.itemdetails) {
				this.itemdetails(data);
			}
		}
	},
	
	catitems: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.CATITEMS,
			data: data
		});
	},

	useritems: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.USERITEMS,
			data: data
		});
	},

	itemdetails: function(data) {
		Dispatcher.dispatch({
			actionType: Constants.ITEMDETAILS,
			data: data
		});
	}
};