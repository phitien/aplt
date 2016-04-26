/*
 * Components
 */
var RegisterForm = React.createClass({
	propTypes : {
		onChange : React.PropTypes.func.isRequired,
	},
	render : function() {
		var onChange = this.props.onChange;
		return (React.createElement(//
		'form', {
			className : 'EzsellForm',
			method : 'post',
			action : '/register'
		}, React.createElement('input', {
			type : 'email',
			name : 'email',
			placeholder : 'Email',
			onChange : function(e) {
				user.email = e.target.value;
				onChange();
			},
		}), React.createElement('input', {
			type : 'email',
			name : 'email_confirmation',
			placeholder : 'Email Confirmation',
			onChange : function(e) {
				user.email_confirmation = e.target.value;
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
		}), React.createElement('input', {
			type : 'password',
			name : 'password_confirmation',
			placeholder : 'Password Confirmation',
			onChange : function(e) {
				user.password_confirmation = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'submit'
		}, "Register")//
		));
	},
});

var RegisterView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'EzsellView RegisterView'
		}, React.createElement(RegisterForm, {
			onChange : function() {}
		})//
		));
	},
});
var user = {
	email : "",
	email_confirmation : "",
	password : "",
	password_confirmation : ""
};
/*
 * Entry point
 */
ReactDOM.render(React.createElement(RegisterView, {}), document
		.getElementById('container'));
