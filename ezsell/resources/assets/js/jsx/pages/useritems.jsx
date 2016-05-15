import UserItemList from '../components/useritemlist.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(UserItemList, {
		user: user,
		items: items,
		className: 'item-inline-prices'
	}), document.getElementById(contentDivId), function () {
		$('.datetimeformat').each(function () {
			var me = $(this);
			var text = me.text().trim();
			me.text(format.prettyDate(text) + ' (' + format.datetime(text) + ')');
		});
		$('.currency-value').each(function () {
			var me = $(this);
			var text = me.text().trim();
			me.text(format.currency(text));
		});
	});
});
