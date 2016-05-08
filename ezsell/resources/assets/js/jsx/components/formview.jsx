import Form from './../components/form.jsx';
//
var FormView = React.createClass({
	Form : Form,
	render : function() {
		const className = this.props.className;
		const formrender = this.props.formrender;
		return (
			<div className={className}>
				<Form formrender={formrender} />
			</div>
		);
	}
});

module.exports = FormView;