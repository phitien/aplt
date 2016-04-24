/*
 * Components
 */
var LoginForm = React.createClass({
	propTypes : {
		onChange : React.PropTypes.func.isRequired,
	},
	render : function() {
		var onChange = this.props.onChange;
		return (React.createElement(//
		'form', {
			className : 'EzsellForm',
			method : 'post'
		}, React.createElement('input', {
			type : 'email',
			name : 'email',
			placeholder : 'Email',
			onChange : function(e) {
				user.email = e.target.value;
				onChange();
			},
		}), React.createElement('input', {
			type : 'password',
			name : 'password',
			placeholder : 'Password',
			onChange : function(e) {
				user.password = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'submit'
		}, "Login")//
		));
	},
});

var LoginView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'EzsellView LoginView'
		}, React.createElement(LoginForm, {
			onChange : function() {
			}
		})//
		));
	},
});
var user = {
	email : "",
	password : ""
};
/*
 * Entry point
 */
ReactDOM.render(React.createElement(LoginView, {}), document
		.getElementById('container'));
