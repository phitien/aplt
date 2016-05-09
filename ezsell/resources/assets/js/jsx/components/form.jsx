var Form = React.createClass({
	getInitialState() {
		const state = this.props.initialState || {};
		state['canSubmit'] = false;
		return state;
	},
	enableButton() {
		this.setState({
			canSubmit: true
		});
	},
	disableButton() {
		this.setState({
			canSubmit: false
		});
	},
	submit(model) {
		submitForm(ReactDOM.findDOMNode(this));
	},
	render() {
		const formrender = this.props.formrender;
		return formrender.bind(this) ();
	}
});

module.exports = Form;