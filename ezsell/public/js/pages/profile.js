/*
 * Components
 */
var ProfileForm = React.createClass({
	propTypes : {
		onChange : React.PropTypes.func.isRequired,
	},
	render : function() {
		var onChange = this.props.onChange;
		return (React.createElement(//
		'form', {
			className : 'EzsellForm',
			method : 'post'
		}, React.createElement('button', {
			type : 'button',
			onClick : function() {
				console.log(user);
			}
		}, "Edit Profile")//
		));
	},
});

var ProfileView = React.createClass({
	propTypes : {},
	render : function() {
		return (React.createElement(//
		'div', {
			className : 'EzsellView ProfileView'
		}, React.createElement(ProfileForm, {
			onChange : function() {
			}
		})//
		));
	},
});
/*
 * Entry point
 */
ReactDOM.render(React.createElement(ProfileView, {}), document
		.getElementById('container'));
