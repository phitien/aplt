Object.assign(window, {
	isVisible : function(e) {
		if ($(e).css('display') == 'none' || $(e).css('visibility') == 'hidden')
			return false;
		return true;
	},
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
	submitForm : function(form, ajax, callback) {
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
		if (!ajax)
			form.submit();
		else {
			var $form = $(form); 
			var url = $form.attr('action') ? $form.attr('action') : '/';
			window.ajax.post(url, function(data, status, response) {	
				callback(data, status, response);
			}, window.formToJson(form));
		}
	},
	formToJson : function(form) {
		var data = {};
		$(form).serializeArray().map(function(x){data[x.name] = x.value;});
		return data;
	},
	dialog : {
		get : function(options, container) {
			var me = this;
			this.$ = $(container ? container : '#dialog');
			this.$.dialog(Object.assign({
			    resizable: false,
			    draggable: false,
				autoOpen : false,
				modal : true,
				closeOnEscape : true,
				dialogClass : 'dialogNoCloseButton',
				close : function () {
					me.$.html('');
				}
			}, options));
			return this;
		},
		open : function () {
			this.$.dialog('open');
			return this;
		},
		close : function() {
			if (this.$)
				this.$.dialog('close');
			return this;
		}
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
		dialog.get({
			title : title,
			open : function(e, ui) {
				$(this).html(msg).show();
			},
			buttons : buttons
		}).open();
	},
	ui : {
		plugins : {
			format : function($container) {
				$container.find('.prettydateformat').each(
						function() {
							var me = $(this);
							var text = me.text().trim();
							me.text((format.prettyDate(text) ? format
									.prettyDate(text) : '')
									+ ' (' + format.date(text) + ')');
						});
				$container.find('.dateformat').each(function() {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.date(text));
				});
				$container.find('.timeformat').each(function() {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.time(text));
				});
				$container.find('.datetimeformat').each(function() {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.datetime(text));
				});
				$container.find('.currency-value').each(function() {
					var me = $(this);
					var text = me.text().trim();
					me.text(format.currency(text));
				});
				$container.find('.emotion').emotions({
					handle : '#etoggle',
					dir : 'emotions/',
					label_on : 'On Emotions',
					label_off : 'Off Emotions',
					style : 'background: #eee',
					css : 'class2'
				});
			}
		}
	},
});
