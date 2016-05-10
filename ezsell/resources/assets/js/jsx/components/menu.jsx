const MenuItem = React.createClass({
	getText() {
		try {
			return this.props.getText.bind(this.props.data) ();
		}
		catch (e) {
			return '';
		}
	},
	getHref() {
		try {
			return this.props.getHref.bind(this.props.data) ();
		}
		catch (e) {
			return '';
		}
	},
	getChildren() {
		try {
			return this.props.getChildren.bind(this.props.data) ();
		}
		catch (e) {
			return null;
		}
	},
	handleItemClick(event) {
		var href = this.getHref().replace('javascript:', '');
		var fn = eval('(function () {'+href+';})');
		fn.bind(event.currentTarget)();
	},
	render() {
		const text = this.getText();
		if (!text) {
			return (
				<li></li>
			); 
		}
		var href = this.getHref();
		var html;
		if (href) {
			if (href.indexOf("javascript:") == 0) {
				html = <a className='menuitem menuitem-nonatomic' onClick={this.handleItemClick}><span>{text}</span></a>;
			}
			else {
				html = <a className='menuitem menuitem-atomic' href={href}><span>{text}</span></a>;
			}
		}
		else {
			html = <a className='menuitem menuitem-nonatomic'><span>{text}</span></a>;
		}
		const children = this.getChildren();
		if (children && children.length > 0) {
			return (
				<li>
					{html}
					<Menu items={children} getText={this.props.getText} getHref={this.props.getHref} getChildren={this.props.getChildren} />
				</li>
			);
		}
		else {
			return (
				<li><span>{html}</span></li>
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