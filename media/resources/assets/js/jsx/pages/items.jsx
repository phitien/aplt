$( document ).ready(function() {
	ReactDOM.render(React.createElement(ItemList, {
		cat: cat,
		items: items,
		className: 'item-inline-prices'
	}), document.getElementById(contentDivId));
});
