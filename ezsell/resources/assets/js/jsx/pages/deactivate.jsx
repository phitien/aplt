import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
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
		submitForm(ReactDOM.findDOMNode(this));
	},
	render : function() {
		return (
			<Formsy.Form className='EzsellForm' method='post' action='/deactivate'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='password' required name='current_password' title='Password' 
					validationError='Password is required' />
				<Button name='submit' type='submit' disabled={!this.state.canSubmit} value='Deactivate' />
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
