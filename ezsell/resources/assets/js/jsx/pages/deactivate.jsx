import Input from './../components/form/input.jsx';
//
var DeactivateForm = React.createClass({
	getInitialState() {
		return {
			canSubmit: false
		}
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
		ReactDOM.findDOMNode(this).submit();
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/deactivate'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='password' title='Password' validations={{
						minLength: 6,
						maxLength: 30
					}} validationErrors={{
						minLength: 'Password should have at least 6 characters',
						maxLength: 'Password should not have more than 30 characters'
					}} />
				<button className='btn btn-default' type='submit' disabled={!this.state.canSubmit}>Deactivate</button>
			</Formsy.Form>
		);
	}
});

var DeactivateView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView DeactivateView'>
				<DeactivateForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(DeactivateView), document.getElementById('container'));
