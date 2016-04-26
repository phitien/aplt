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
			className : 'EzsellForm',
			method : 'post',
			action : '/deactivate'
		}, React.createElement('input', {
			type : 'password',
			name : 'password',
			placeholder : 'Password',
			onChange : function(e) {
				user.password = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'submit'
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
