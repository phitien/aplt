import CatItemList from '../components/catitemlist.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(CatItemList, {
		cat: catitems_cat,
		items: catitems_items,
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
