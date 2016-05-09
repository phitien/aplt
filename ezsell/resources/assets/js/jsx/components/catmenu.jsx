import Menu from './menu.jsx';
//
const CatMenu = React.createClass({
	render: function() {
		function getText() {
			return this.details.name;
		}
		function getHref() {
			return '';
		}
		const className = 'catmenu ' + (this.props.className?this.props.className:'');
		return (
			<Menu className={className} items={this.props.items} getText={getText} getHref={getHref} />
		);
	}
});
//
export default CatMenu;