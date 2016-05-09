const MenuItem = React.createClass({
	render() {
		const data = this.props.data;
		const getText = this.props.getText;
		const getHref = this.props.getHref;
		const getChildren = this.props.getChildren;
		try { 
			const text = getText.bind(data) ();
			const href = getHref.bind(data) ();
			const html = href ? <a href='{href}'><span>{text}</span></a> : <a><span>{text}</span></a>;
			const children = getChildren.bind(data) ();
			if (children && children.length > 0) {
				return (
					<li>
						{html}
						<Menu items={children} getText={getText} getHref={getHref} getChildren={getChildren} />
					</li>
				);
			}
			else {
				return (
					<li><span>{html}</span></li>
				);
			}
		} 
		catch (e) {
			return (
				<li></li>
			); 
		}
	}
});

const Menu = React.createClass({
	MenuItem : MenuItem, 
	render() {
		const className = this.props.className ? this.props.className : '';
		const getText = this.props.getText ? this.props.getText : function() { return this.text; };
		const getHref = this.props.getHref ? this.props.getHref : function() { return this.href; };
		const getChildren = this.props.getChildren ? this.props.getChildren : function() { return this.children; };
		return (
			<ul className={className}>
				{this.props.items.map(function(item, i) {
					return <MenuItem data={item} getText={getText} getHref={getHref} getChildren={getChildren} key={i} />
				})}
			</ul>
		);
	}
});

export default Menu;