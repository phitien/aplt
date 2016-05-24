/**
 * MenuItem defination
 */
var MenuItem = React.createClass({
	mixins: [Mixin],
	getText(_item) {
		try {return this.props.getText(_item);}
		catch (e) {
			try {return _item.text;}
			catch (e) {
				return '';
			}
		}
	},
	getHref(_item) {
		try {return this.props.getHref(_item);}
		catch (e) {
			try {return _item.href;}
			catch (e) {
				return '';
			}
		}
	},
	getChildren(_item) {
		try {return this.props.getChildren(_item);}
		catch (e) {
			try {return _item.children;}
			catch (e) {
				return [];
			}
		}
	},
	getSubMenuClassName(_item) {
		try {return this.props.getSubMenuClassName(_item);}
		catch (e) {
			try {return _item.subMenuClassName;}
			catch (e) {
				return '';
			}
		}
	},
	itemClick(e) {
		if (this.props.itemClick) {
			this.props.itemClick(this);
		}
	},
	handleItemClick(event) {
		var href = this.getHref(this.props.data).replace('javascript:', '');
		var fn = eval('(function () {' + href + ';})');
		fn.bind(event.currentTarget)();
	},
	render() {
		var text = this.getText(this.props.data);
		if (!text) {
			return (
				<li></li>
			); 
		}
		var href = this.getHref(this.props.data);
		var html;
		if (href) {
			if (href.indexOf("javascript:") == 0) {
				html = <a className='menuitem menuitem-atomic' onClick={this.handleItemClick}><span>{text}</span></a>;
			}
			else {
				html = <a className='menuitem menuitem-atomic' href={href}><span>{text}</span></a>;
			}
		}
		else {
			html = <a className='menuitem menuitem-nonatomic' onClick={this.itemClick}><span>{text}</span></a>;
		}
		const children = this.getChildren(this.props.data);
		var subMenuClassName = this.getSubMenuClassName(this.props.data); 
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
window.MenuItem = MenuItem;

/**
 * Menu defination
 */
const Menu = React.createClass({
	mixins: [Mixin],
	render() {
		const me = this;
		return (
			<ul className={this.className()}>
				{this.props.items.map(function(item, i) {
					return <MenuItem data={item} key={i}
						getText={me.props.getText} 
						getHref={me.props.getHref}
						itemClick={me.props.itemClick}
						getChildren={me.props.getChildren} 
						getSubMenuClassName={me.props.getSubMenuClassName} />
				})}
			</ul>
		);
	}
});
window.Menu = Menu;

/**
 * CatMenu defination
 */
const CatMenu = React.createClass({
	mixins: [Mixin],
	getText(_item) {
		return _item.details ? _item.details.name : '';
	},
	getHref(_item) {
		if (!_item.parent_id) 
			return 'javascript:expandMenu(this)';
		else if (_item.atomic) 
			return 'javascript:applicationSwitch("cat/' + (appManager.get('usecode') ? _item.code.toLowerCase() : _item.id) +'")';
		else 
			return '';
	},
	itemClick(_item) {
		console.log(_item);
	},
	getSubMenuClassName(_item) {
		if (!_item.parent_id) 
			return 'sensitive';
		return '';
	},
	render() {
		const showRoot = this.attr('showRoot', true);
		const items = showRoot ? this.props.items : this.props.items[0].children;
		return (
			<Menu className={this.className('catmenu')} items={items} 
				getText={this.getText} 
				getHref={this.getHref}
				itemClick={this.itemClick}
				getSubMenuClassName={this.getSubMenuClassName} />
		);
	}
});

module.exports = window.CatMenu = CatMenu;