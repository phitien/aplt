import Input from './../components/form/input.jsx';
//
var CodeForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/code'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
				<Input type='email' required name='email' title='Email' validations='isEmail' 
					validationError='This is not a valid email' />
				<button className='btn btn-default' type='submit' disabled={!this.state.canSubmit}>Send activation</button>
			</Formsy.Form>
		);
	}
});

var CodeView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView CodeView'>
				<CodeForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(CodeView), document.getElementById('container'));
