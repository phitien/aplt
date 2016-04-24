/*
 * Components
 */
var DeactivateForm = React.createClass({
	propTypes : {
		onChange : React.PropTypes.func.isRequired,
	},
	render : function() {
		var onChange = this.props.onChange;
		return (React.createElement(//
		'form', {
			className : 'EzsellForm'
		}), React.createElement('input', {
			type : 'password',
			placeholder : 'Password',
			onChange : function(e) {
				user.password = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'button',
			onClick : function(e) {
				$.ajax({
					type : 'POST',
					url : '/deactivate',
					data : user
				}).done(function(data) {
				}).fail(function(jqXhr) {
				});
			}
		}, "Deactivate")//
		));
	},
});

var DeactivateView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'EzsellView DeactivateView'
		}, React.createElement(DeactivateForm, {
			onChange : function() {
			}
		})//
		));
	},
});
var user = {
	password : ""
};
/*
 * Entry point
 */
ReactDOM.render(React.createElement(DeactivateView, {}), document
		.getElementById('container'));
