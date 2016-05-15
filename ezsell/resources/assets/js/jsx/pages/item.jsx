import ItemDetail from '../components/itemdetail.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(ItemDetail, {
		item: item,
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
