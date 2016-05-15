import ItemList from '../components/itemlist.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(ItemList, {
		cat: cat,
		items: items,
		className: 'item-block-prices'
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
