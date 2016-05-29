/**
 * Menu defination
 */
module.exports = window.Menu = React.createClass({
	mixins: [createMixin()],
	render() {
		const me = this;
		return (
			<ul className={this.className()}>
				{this.props.items.map(function(item, i) {
					return <MenuItem data={item} key={i}
						getText={me.props.getText} 
						getHref={me.props.getHref}
						getIcon={me.props.getIcon}
						itemClick={me.props.itemClick}
						getChildren={me.props.getChildren} 
						getSubMenuClassName={me.props.getSubMenuClassName} />
				})}
			</ul>
		);
	}
});
