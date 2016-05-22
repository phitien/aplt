/**
 * UI
 */
Object.assign(window, {
	showLoginForm(e) {
		if (!window.currentForm || window.currentForm != 'login') {
			$('#form-container').hide();
			window.currentForm = 'login';
			ReactDOM.render(<LoginPage />, document.getElementById('form-container'), function() {
				toggleElement($('#form-container'));
			});
		}
		else {
			toggleElement($('#form-container'));
		}
	},
	showRegistrationForm(e) {
		if (!window.currentForm || window.currentForm != 'register') {
			$('#form-container').hide();
			window.currentForm = 'register';
			ReactDOM.render(<RegisterPage />, document.getElementById('form-container'), function() {
				toggleElement($('#form-container'));
			});
		}
		else {
			toggleElement($('#form-container'));
		}
	},
	showLocationForm(e) {
		if (!window.currentForm || window.currentForm != 'location') {
			$('#form-container').hide();
			window.currentForm = 'location';
			ReactDOM.render(<ChangeLocationPage />, document.getElementById('form-container'), function() {
				toggleElement($('#form-container'));
			});
		}
		else {
			toggleElement($('#form-container'));
		}
	},
	ui: {
		addEventHandlers() {
			$(document).keyup(function(e) {
				if (e.keyCode == 27) {
					hideMenus();
				}
			});
			//scroll to bottom to load more data
			$(window).scroll(function() {
		    	if($(window).scrollTop() == $(document).height() - $(window).height()) {
		    		var paginate = sessionManager.isListPage();
		    		if (paginate && paginate.next_page_url) {
						ajax.get(paginate.next_page_url, function( _data ) {
							if (_data && _data.data && _data.data.paginate) {
								_data.data.paginate.data = paginate.data.concat(_data.data.paginate.data);
								Dispatcher.emit(Dispatcher.Events.UPDATE_APPLICATION, _data.data);
							}
						});
		    		}
		    	}
		    	else if($(window).scrollTop() == 0) {
		    	}
			});
		},
		getItemExpires(item) {
			return item.deleted_at ? expired_at = <div className='item-date item-expired'>
								<a><span className='label expired-label'>{localization.expires_at}</span><span className='prettydateformat'>{item.deleted_at}</span></a>
							</div> : null;
		},
		getItemPostedOrEdited(item) {
			var created = new Date(item.created_at);
			var updated = new Date(item.updated_at);
			return (+updated !== +created) ? 
							<div className='item-date item-updated'>
								<a><span className='label edited-label'>{localization.edited_at}</span><span className='prettydateformat'>{item.updated_at}</span></a>
							</div> : 
							<div className='item-date item-created'>
								<a><span className='label posted-label'>{localization.posted_at}</span><span className='prettydateformat'>{item.created_at}</span></a>
							</div>;
		},
		plugins: {
			format ($container) {
				if (!$container) {
					$('.prettydateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text((format.prettyDate(text) ? format.prettyDate(text) : '') + ' (' + format.date(text) + ')');
					});
					$('.dateformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.date(text));
					});
					$('.timeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.time(text));
					});
					$('.datetimeformat').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.datetime(text));
					});
					$('.currency-value').each(function () {
						var me = $(this);
						var text = me.text().trim();
						me.text(format.currency(text));
					});
				}
				else {
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
		}
	},
	submitForm(form) {
		$('<input>').attr({
			type: 'hidden',
			name: '_token',
			value: token()
		}).appendTo(form);
		$('<input>').attr({
			type: 'hidden',
			name: 'redirect',
			value: location.href
		}).appendTo(form);
		form.submit();
	},
	showMessageDialog(msg, title, btn, callback) {
		btn = btn ? btn : localization.ok;
		title = title ? title : localization.message;
		var buttons = {};
		buttons[btn] = function() {
			$( this ).dialog( 'close' );
			$( this ).remove();
			if (callback) {
				callback();
			}
		};
	 	$('<div></div>').dialog({
			modal: true,
			title: title,
			closeOnEscape: false,
			open(e, ui) {
				$('.ui-dialog-titlebar-close', ui.dialog | ui).hide();
				$(this).html(msg);
			},
			buttons: buttons
		});//end confirm dialog
	},
	expandMenu(e) {
		var menu = $(e).next('ul');
		toggleElement(menu);
	},
	hideMenus() {slideUp($('.sensitive'));},
	toggleElement(e) {
		if ( e.css('display') == 'none' ) 
			slideDown(e);
		else 
			slideUp(e);
	},
	slideDown(e) {
		e.slideDown();
		e.css('visibility', 'visible');
		$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'hidden');
	},
	slideUp(e) {
		e.slideUp(function () {
			$(sensitive).not(e).not(e.find(sensitive)).css('visibility', 'visible');
			e.css('visibility', 'hidden');
		});
	},
	hideClassName(classNameToHide, exceptions) {
		$('.' + classNameToHide).not(exceptions).hide();
	}
});
