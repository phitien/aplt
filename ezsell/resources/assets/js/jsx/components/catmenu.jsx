/**
 * MenuItem defination
 */
const MenuItem = React.createClass({
	getText() {
		try {return this.props.getText.bind(this.props.data) ();}
		catch (e) {
			try {return this.props.data.text;}
			catch (e) {
				return '';
			}
		}
	},
	getHref() {
		try {return this.props.getHref.bind(this.props.data) ();}
		catch (e) {
			try {return this.props.data.href;}
			catch (e) {
				return '';
			}
		}
	},
	getChildren() {
		try {return this.props.getChildren.bind(this.props.data) ();}
		catch (e) {
			try {return this.props.data.children;}
			catch (e) {
				return [];
			}
		}
	},
	getSubMenuClassName() {
		try {return this.props.getSubMenuClassName.bind(this.props.data) ();}
		catch (e) {
			try {return this.props.data.subMenuClassName;}
			catch (e) {
				return '';
			}
		}
	},
	handleItemClick(event) {
		var href = this.getHref().replace('javascript:', '');
		var fn = eval('(function () {'+href+';})');
		fn.bind(event.currentTarget)();
	},
	render() {
		var text = this.getText();
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
		var subMenuClassName = this.getSubMenuClassName(); 
		if (children && children.length > 0) {
			return (
				<li>
					{html}
					<Menu className={subMenuClassName} items={children} 
						getText={this.props.getText} 
						getHref={this.props.getHref} 
						getChildren={this.props.getChildren}
						getSubMenuClassName={this.props.getSubMenuClassName} />
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
		const me = this;
		return (
			<ul className={className}>
				{this.props.items.map(function(item, i) {
					return <MenuItem data={item} key={i}
						getText={me.props.getText} 
						getHref={me.props.getHref} 
						getChildren={me.props.getChildren} 
						getSubMenuClassName={me.props.getSubMenuClassName} />
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
			return this.details ? this.details.name : '';
		}
		function getHref() {
			if (!this.parent_id) {
				return 'javascript:expandMenu(this)';
			}
			else if (this.atomic) {
				return 'cat/' + (usecode ? this.code.toLowerCase() : this.id);
			}
			else {
				return '';
			}
		}
		function getSubMenuClassName() {
			if (!this.parent_id) {
				return 'sensitive';
			}
			return '';
		}
		const className = 'catmenu ' + (this.props.hasOwnProperty('className') ? this.props.className : '');
		const showRoot = this.props.hasOwnProperty('showRoot') ? this.props.showRoot : true;
		const items = showRoot ? this.props.items : this.props.items[0].children;
		return (
			<Menu className={className} items={items} 
				getText={getText} 
				getHref={getHref} 
				getSubMenuClassName={getSubMenuClassName} />
		);
	}
});
//
CatMenu.Menu = Menu;
CatMenu.MenuItem = MenuItem;
export default CatMenu;