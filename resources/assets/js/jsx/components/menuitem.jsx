module.exports = window.MenuItem = React.createClass({
	mixins: [createMixin()],
	getText(data) {
		try {return this.props.getText(data);}
		catch (e) {
			try {return data.text;}
			catch (e) {
				return '';
			}
		}
	},
	getHref(data) {
		try {return this.props.getHref(data);}
		catch (e) {
			try {return data.href;}
			catch (e) {
				return '';
			}
		}
	},
	getChildren(data) {
		try {return this.props.getChildren(data);}
		catch (e) {
			try {return data.children;}
			catch (e) {
				return [];
			}
		}
	},
	getIcon(data) {
		try {return this.props.getIcon(data);}
		catch (e) {
			try {return data.icon;}
			catch (e) {
				return '';
			}
		}
	},
	getSubMenuClassName(data) {
		try {return this.props.getSubMenuClassName(data);}
		catch (e) {
			try {return data.subMenuClassName;}
			catch (e) {
				return '';
			}
		}
	},
	itemClick(e) {
		if (this.props.data.itemClick) 
			this.props.data.itemClick.bind(this)(e);
		else {
			var href = this.getHref(this.props.data);
			if (href.indexOf("javascript:") == 0) {
				href = href.replace('javascript:', '');
				var fn = eval('(function () {' + href + ';})');
				fn.bind(e.currentTarget)();
			}
			else {
				this.props.itemClick(this.props.data);
			}
		}
	},
	render() {
		var html;
		var text = this.getText(this.props.data);
		var icon = this.getIcon(this.props.data);
		if (!text && !icon) {
			return null; 
		}
		if (icon)
			icon = <span className={'ui-icon ' + icon}></span>;
		if (text)
			text = <span>{text}</span>;
		var href = this.getHref(this.props.data);
		var children = this.getChildren(this.props.data);
		var linkClassName = (children && children.length > 0 ? 'menuitem menuitem-nonatomic ' : 'menuitem menuitem-atomic ') + icon;
		if (this.props.itemClick || (href && href.indexOf("javascript:") == 0)) {
			html = <a className={linkClassName} onClick={this.itemClick}>{icon}{text}</a>;
		}
		else if (href) {
			html = <a className={linkClassName} href={href}>{icon}{text}</a>;
		}
		else {
			html = <a className={linkClassName}>{icon}{text}</a>;
		}
		var subMenuClassName = this.getSubMenuClassName(this.props.data); 
		if (children && children.length > 0) {
			return (
				<li>
					{html}
					<Menu className={subMenuClassName} items={children} 
						getText={this.props.getText} 
						getHref={this.props.getHref} 
						getIcon={this.props.getIcon}
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