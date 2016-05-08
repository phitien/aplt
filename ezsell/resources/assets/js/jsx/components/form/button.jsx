import React from 'react';
import Formsy from 'formsy-react';

const Button = React.createClass({
	mixins: [Formsy.Mixin],
	render() {
		const className ='btn btn-default ' + (this.props.className ? this.props.className : '');
		return (
			<button className={className} type={this.props.type} disabled={this.props.disabled}>{this.props.value}</button>
		);
	}
});

export default Button;