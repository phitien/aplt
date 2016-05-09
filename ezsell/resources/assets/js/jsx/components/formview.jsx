import Form from './../components/form.jsx';
//
var FormView = React.createClass({
	Form : Form,
	render : function() {
		const className = this.props.className;
		const formrender = this.props.formrender;
		const initialState = this.props.initialState;
		return (
			<div className={className}>
				<Form formrender={formrender} initialState={initialState} />
			</div>
		);
	}
});

module.exports = FormView;