/**
 * MenuItem defination
 */
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
/**
 * Menu defination
 */
const Menu = React.createClass({
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
/**
 * CatMenu defination
 */
const CatMenu = React.createClass({
	render: function() {
		function getText() {
			return this.details.name;
		}
		function getHref() {
			if (!this.parent_id) {
				return 'javascript:expandMenu(this)';
			}
			else if (this.atomic) {
				return 'cat/' + this.id;
			}
			else {
				return '';
			}
		}
		const className = 'catmenu ' + (this.props.className?this.props.className:'');
		return (
			<Menu className={className} items={this.props.items} getText={getText} getHref={getHref} />
		);
	}
});
//
CatMenu.Menu = Menu;
CatMenu.MenuItem = MenuItem;
export default CatMenu;