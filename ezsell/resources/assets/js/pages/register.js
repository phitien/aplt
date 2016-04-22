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
			className : 'RegisterForm'
		}, React.createElement('input', {
			type : 'email',
			placeholder : 'Email',
			onChange : function(e) {
				user.email = e.target.value;
				onChange();
			},
		}), React.createElement('input', {
			type : 'email',
			placeholder : 'Email Confirmation',
			onChange : function(e) {
				user.email_confirmation = e.target.value;
				onChange();
			},
		}), React.createElement('input', {
			type : 'password',
			placeholder : 'Password',
			onChange : function(e) {
				user.password = e.target.value;
				onChange();
			},
		}), React.createElement('input', {
			type : 'password',
			placeholder : 'Password Confirmation',
			onChange : function(e) {
				user.password_confirmation = e.target.value;
				onChange();
			},
		}), React.createElement('button', {
			type : 'button',
			onClick : function(e) {
				$.ajax({
					type : 'POST',
					url : '/register',
					data : user
				}).done(function(data) {
					self.clearForm()
				}).fail(function(jqXhr) {
					console.log('failed to register');
				});
			}
		}, "Register")//
		));
	},
});

var RegisterView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'RegisterView'
		}, React.createElement(RegisterForm, {
			onChange : function() {
			}
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
