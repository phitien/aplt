import Input from './../form/input.jsx';
//
var IndexForm = React.createClass({
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
			<Formsy.Form className='EzsellForm' method='post' action='/'  
			onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
			</Formsy.Form>
		);
	}
});

var IndexView = React.createClass({
	render : function() {
		return (
			<div className='EzsellView IndexView'>
				<IndexForm />
			</div>
		);
	},
});

ReactDOM.render(React.createElement(IndexView), document.getElementById('container'));
