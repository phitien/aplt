/*
 * Components
 */
var CodeForm = React.createClass({
	propTypes : {
		onChange : React.PropTypes.func.isRequired,
	},
	render : function() {
		var onChange = this.props.onChange;
		return (React.createElement(//
		'form', {
			className : 'EzsellForm'
		}, React.createElement('input', {
			type : 'email',
			placeholder : 'Email',
			onChange : function(e) {
				user.email = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'button',
			onClick : function(e) {
				$.ajax({
					type : 'POST',
					url : '/code',
					data : user
				}).done(function(data) {
				}).fail(function(jqXhr) {
				});
			}
		}, "Send activation")//
		));
	},
});

var CodeView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'EzsellView CodeView'
		}, React.createElement(CodeForm, {
			onChange : function() {
			}
		})//
		));
	},
});
var user = {
	email : ""
};
/*
 * Entry point
 */
ReactDOM.render(React.createElement(CodeView, {}), document
		.getElementById('container'));
