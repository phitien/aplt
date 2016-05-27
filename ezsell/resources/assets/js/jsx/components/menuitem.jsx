module.exports = window.MenuItem = React.createClass({
	mixins: [createMixin()],
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
	getIcon(_item) {
		try {return this.props.getIcon(_item);}
		catch (e) {
			try {return _item.icon;}
			catch (e) {
				return '';
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
		var href = this.getHref(this.props.data);
		if (href.indexOf("javascript:") == 0) {
			href = href.replace('javascript:', '');
			var fn = eval('(function () {' + href + ';})');
			fn.bind(e.currentTarget)();
		}
		else {
			this.props.itemClick(this.props.data);
		}
	},
	render() {
		var html;
		var text = this.getText(this.props.data);
		var icon = this.getIcon(this.props.data);
		if (!text && !icon) {
			return null; 
		}
		var href = this.getHref(this.props.data);
		var children = this.getChildren(this.props.data);
		var linkClassName = (children && children.length > 0 ? 'menuitem menuitem-nonatomic ' : 'menuitem menuitem-atomic ') + icon;
		if (this.props.itemClick || (href && href.indexOf("javascript:") == 0)) {
			html = <a className={linkClassName} onClick={this.itemClick}><span>{text}</span></a>;
		}
		else if (href) {
			html = <a className={linkClassName} href={href}><span>{text}</span></a>;
		}
		else {
			html = <a className={linkClassName}><span>{text}</span></a>;
		}
		var subMenuClassName = this.getSubMenuClassName(this.props.data); 
		if (children && children.length > 0) {
			return (
				<li>
					{html}
					<Menu className={subMenuClassName} items={children} 
						getText={this.props.getText} 
						getHref={this.props.getHref} 
						getChildren={this.props.getChildren}
						itemClick={this.props.itemClick}
						getSubMenuClassName={this.props.getSubMenuClassName} />
				</li>
			);
		}
		else {
			return (
				<li>{html}</li>
			);
		}
	}
});