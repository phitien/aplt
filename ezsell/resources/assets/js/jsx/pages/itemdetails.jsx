import ItemDetails from '../components/itemdetails.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(ItemDetails, {
		item: itemdetails_item,
		className: 'item-inline-prices'
	}), document.getElementById(centerDivId), function () {
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
