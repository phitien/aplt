/**
 * Navigation defination
 */
module.exports = window.Navigation = React.createClass({
	id: 'navigation',
	mixins: [createMixin()],
	eventName : AppEvents.UPDATE_NAVIGATION,
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
		return (
			<div className={this.className()} id={this.getId()}>
				<div className="container clearfix">
					<div id="leftmenu">
						<ul className="nav">
							<li><a onclick="applicationSwitch('/')"><span>{configurations.localization.home}</span></a></li>
							<li id="catmenu">
								<CatMenu items={appManager.cats()}></CatMenu>
							</li>
							<li id="extra">
								<ModeSwitch />
							</li>
						</ul>
						<div className="clearfix"></div>
					</div>
					<div id="rightmenu">
						<div className="sensitive" id="form-container"></div>
						<div className="clearfix"></div>
					</div>
				</div>
			</div>
		);
		return null;
	}
});