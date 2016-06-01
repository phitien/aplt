/**
 * FormView mixin defination
 */
module.exports = window.FormView = {
	getInitialState : function() {
		return {
			canSubmit : false
		};
	},
	enableButton : function() {
		this.setState({
			canSubmit : true
		});
	},
	disableButton : function() {
		this.setState({
			canSubmit : false
		});
	},
	submit : function(model) {
		var ajax = this.props.ajax ? this.props.ajax : false;
		var callback = this.props.callback ? this.props.callback : function(data, status, response) {};
		var form, root = this.getRootDom();
		if (root.tagName.toLowerCase() == 'form') {
			form = root;
		} else {
			form = $(form).find('form').get(0);
		}
		submitForm(form, ajax, callback);
	},
	showImagesPreview : function(input, previewContainer) {
		if (input.files && input.files.length > 0) {
			var cols = parseInt($(input).attr('cols')) != NaN ? parseInt($(
					input).attr('cols')) : 4;
			var cls = 1;
			if (cols == 2 || cols == 3 || cols == 4 || cols == 6) {
				cls = 12 / cols;
			}
			var name = input.name.replace('[]', '');
			var previewDiv = previewContainer ? $(input).parents('form').find(
					previewContainer) : $(input).parent()
					.find('.image-preview');
			previewDiv.attr('data-file-id', input.id);
			previewDiv.html('');
			var count = 0;
			for ( var i in input.files) {
				var item = input.files[i];
				if (item instanceof Blob) {
					var reader = new FileReader();
					reader.image = item;
					reader.onload = function(e) {
						var img = new Image();
						img.image = this.image;
						img.onload = function(e) {
							var html = "<div class='image-preview-item col-xs-6 col-md-"
									+ cls
									+ "'>"
									+ "<input type='text' name='"
									+ name
									+ "-title["
									+ this.image.name
									+ "]' placeholder='Caption' class='form-control' />"
									+ "<img src='"
									+ this.src
									+ "' />"
									+ "<textarea name='"
									+ name
									+ "-description["
									+ this.image.name
									+ "]' placeholder='Description' class='form-control' row='6'></textarea>"
									+ "<div class='image-info'>("
									+ this.width
									+ " x "
									+ this.height
									+ ")</div>"
									+ "<input class='btn btn-default image-remove' type='button' value='Remove' onclick='FormView.removeImagePreview(this)' />"
									+ "</div>";
							if (count > 0 && (count % cols == (cols - 1))) {
								html += "<div class='clearfix'></div>";
							}
							previewDiv.append(html);
							previewDiv.show();
							count++;
						};
						$(img).attr('src', this.result);
					};
					reader.readAsDataURL(item);
				}
			}
		}
	},
	removeImagePreview : function(e) {
		var container = $(e).parent().parent();
		$(e).parent().remove();
		if (!container.find('.image-preview-item').length) {
			$('#' + container.attr('data-file-id')).val('');
		}
	}
};