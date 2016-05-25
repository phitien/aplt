Object.assign(window, {
	getRootDom : function(reactCpn) {
		return ReactDOM.findDOMNode(reactCpn);
	},
	expandMenu : function(e) {
		var menu = $(e).next('ul');
		toggleElement(menu);
	},
	hideMenus : function() {
		slideUp($('.sensitive'));
	},
	toggleElement : function(e) {
		if (e.css('display') == 'none')
			slideDown(e);
		else
			slideUp(e);
	},
	slideDown : function(e) {
		e.slideDown();
		e.css('visibility', 'visible');
		$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'hidden');
	},
	slideUp : function(e) {
		e.slideUp(function() {
			$(sensitive).not(e).not(e.find(sensitive)).css('visibility',
					'visible');
			e.css('visibility', 'hidden');
		});
	},
	hideClassName : function(classNameToHide, exceptions) {
		$('.' + classNameToHide).not(exceptions).hide();
	},
	submitForm : function(form) {
		$('<input>').attr({
			type : 'hidden',
			name : '_token',
			value : token()
		}).appendTo(form);
		$('<input>').attr({
			type : 'hidden',
			name : 'redirect',
			value : location.href
		}).appendTo(form);
		form.submit();
	},
	showMessageDialog : function(msg, title, btn, callback) {
		btn = btn ? btn : configurations.localization.ok;
		title = title ? title : configurations.localization.message;
		var buttons = {};
		buttons[btn] = function() {
			$(this).dialog('close');
			$(this).remove();
			if (callback) {
				callback();
			}
		};
		$('<div></div>').dialog({
			modal : true,
			title : title,
			closeOnEscape : false,
			open : function(e, ui) {
				$('.ui-dialog-titlebar-close', ui.dialog | ui).hide();
				$(this).html(msg);
			},
			buttons : buttons
		});// end confirm dialog
	},
	ui: {
		plugins: {
			format:function ($container) {
				$container.find('.prettydateformat').each(function () {
					var me = $(this);
					var text = me.text().trim();
					me.text((format.prettyDate(text) ? format.prettyDate(text) : '') + ' (' + format.date(text) + ')');
				});
				$container.find('.dateformat').each(function () {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.date(text));
				});
				$container.find('.timeformat').each(function () {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.time(text));
				});
				$container.find('.datetimeformat').each(function () {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.datetime(text));
				});
				$container.find('.currency-value').each(function () {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.currency(text));
				});
			}
		}
	},
});
