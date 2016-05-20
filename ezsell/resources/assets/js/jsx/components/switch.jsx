//
function _objectWithoutProperties(obj, keys) { var target = {}; for (var i in obj) { if (keys.indexOf(i) >= 0) continue; if (!Object.prototype.hasOwnProperty.call(obj, i)) continue; target[i] = obj[i]; } return target; }
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
//
var classNames = require('classnames');
//
function noop() {}
var Switch = React.createClass({
	propTypes: {
		className: React.PropTypes.string,
		prefixCls: React.PropTypes.string,
		disabled: React.PropTypes.bool,
		checkedChildren: React.PropTypes.any,
		unCheckedChildren: React.PropTypes.any,
		onChange: React.PropTypes.func,
		onMouseUp: React.PropTypes.func
	},
	getDefaultProps: function getDefaultProps() {
		return {
			prefixCls: 'rc-switch',
			checkedChildren: null,
			unCheckedChildren: null,
			className: '',
			defaultChecked: false,
			onChange: noop
		};
	},
	getInitialState: function getInitialState() {
		var props = this.props;
		var checked = false;
		if ('checked' in props) {
			checked = !!props.checked;
		} else {
			checked = !!props.defaultChecked;
		}
		return {
			checked: checked
		};
	},
	componentWillReceiveProps: function componentWillReceiveProps(nextProps) {
		if ('checked' in nextProps) {
			this.setState({
				checked: !!nextProps.checked
			});
		}
	},
	setChecked: function setChecked(e) {
		var checked = !this.state.checked;
		$(e.currentTarget).find('input[type=hidden]').val(checked ? 1 : '');
		if (!('checked' in this.props)) {
			this.setState({
				checked: checked
			});
		}
		this.props.onChange(checked);
		if (this.props.onMouseUp) {
			this.props.onMouseUp(e, checked);
		}
	},
	toggle: function toggle(e) {
		this.setChecked(e);
	},
	handleKeyDown: function handleKeyDown(e) {
		if (e.keyCode === 37) {
			this.setChecked(false);
		}
		if (e.keyCode === 39) {
			this.setChecked(true);
		}
	},
	render: function render() {
		var _classNames;

		var _props = this.props;
		var className = _props.className;
		var prefixCls = _props.prefixCls;
		var disabled = _props.disabled;
		var checkedChildren = _props.checkedChildren;
		var unCheckedChildren = _props.unCheckedChildren;

		var restProps = _objectWithoutProperties(_props, ['name', 'id', 'className', 'prefixCls', 'disabled', 'checkedChildren', 'unCheckedChildren']);

		var checked = this.state.checked;
		var switchClassName = classNames((_classNames = {}, _defineProperty(_classNames, className, !!className), _defineProperty(_classNames, prefixCls, true), _defineProperty(_classNames, prefixCls + '-checked', checked), _defineProperty(_classNames, prefixCls + '-disabled', disabled), _classNames));
		
		return (
			<span className={switchClassName} 
				onKeyDown={this.handleKeyDown}
				onClick={disabled ? noop : this.toggle}>
				<span className={prefixCls + '-inner'}>
					{checked ? checkedChildren : unCheckedChildren}
				</span>
				<input type='hidden' id={_props.id} name={_props.name} />
			</span>
		);
	}
});

module.exports = Switch;