$( document ).ready(function() {
	ReactDOM.render(React.createElement(ItemDetail, {
		item: item,
		className: 'item-inline-prices'
	}), document.getElementById(contentDivId));
});
