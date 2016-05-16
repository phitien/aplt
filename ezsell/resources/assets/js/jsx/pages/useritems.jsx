import UserItemList from '../components/useritemlist.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(UserItemList, {
		user: useritems_user,
		items: useritems_items,
		className: 'item-block-prices'
	}), document.getElementById(centerDivId), function () {
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
	});
});
