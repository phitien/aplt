import Menu from './menu.jsx';
//
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
export default CatMenu;