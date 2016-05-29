/**
 * Left defination
 */
var Left = React.createClass({
	id: 'left',
	mixins: [createMixin()],
	eventName : AppEvents.UPDATE_LEFT,
	refreshCount : 0,
	refresh : function() {
		this.setState({
			refreshCount : this.refreshCount++
		});
	},
	componentWillUnmount : function() {
		Dispatcher.removeListener(this.eventName, this.refresh);
	},
	componentDidMount : function() {
		Dispatcher.addListener(this.eventName, this.refresh);
	},
	render : function() {
		var showLeft = appManager.showLeft();
		if (showLeft) {
			return (
				<div className={this.className('col-xs-12 col-sm-6 col-md-' + showLeft)} id={this.getId()}>
					<CatMenu showRoot={false} className='leftmenu'></CatMenu>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.Left = Left;