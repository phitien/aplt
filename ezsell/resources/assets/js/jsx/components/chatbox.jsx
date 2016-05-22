/**
 * ChatBox defination
 */
var ChatBox = React.createClass({
	eventName: Dispatcher.Events.UPDATE_CHATBOX,
	refreshCount: 0,
	refresh() {
		this.setState({refreshCount: this.refreshCount++});
		this.scrollToBottom();
	},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
		Dispatcher.removeListener(Dispatcher.Events.SHOW_CHATBOX, this.showMe);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(Dispatcher.Events.SHOW_CHATBOX, this.showMe);
		this.scrollToBottom();
		this.getJQueryTextbox().focus();
		
		const user = Dispatcher.Store.get(this.eventName, this.props.user.id);
		Dispatcher.emit(Dispatcher.Events.LOAD_RECENT_MESSAGES, user);
	},
	showMe() {
		const user = Dispatcher.Store.get(Dispatcher.Events.SHOW_CHATBOX, this.props.user.id);
		console.log(user, this.props.user.id);
		console.log(user == this.props.user);
		if (user && user.id == this.props.user.id)
			this.show();
	},
	scrollToBottom() {
		var d = this.getJQueryMessages();
		d.scrollTop(d.prop('scrollHeight'));
	},
	getJQueryRoot() {
		return $(getRootDom(this));
	},
	getJQueryTextbox() {
		return this.getJQueryRoot().find('input[type=text]');
	},
	getJQueryMessages() {
		return this.getJQueryRoot().find('.messages');
	},
	onKeyPress(e) {
		if (e.which == 13) {
			this.send();
		}
	},
	onSend(e) {
		this.send();
	},
	send() {
		var textbox = this.getJQueryTextbox();
		var message = textbox.val();
		textbox.val('');
		const receiver = Dispatcher.Store.get(this.eventName, this.props.user.id);
		if (receiver && message) {
			if (sessionManager.isLogged()) {
				ajax.post('/sendmessage', function(response) {
					Dispatcher.emit(Dispatcher.Events.SENT_MESSAGE, response.data);
				}, {'message': message, code: receiver.id, id: receiver.itemId});
			}
		}
	},
	visible: true,
	show() {
		var me = this;
		me.visible = true;
		var chatbox = me.getJQueryRoot();
		chatbox.find('.messages,.send').slideDown('slow', function() {
			me.getJQueryTextbox().focus();
		});
	},
	hide() {
		var me = this;
		me.visible = false;
		var chatbox = me.getJQueryRoot();
		chatbox.find('.messages,.send').slideUp('slow');
	},
	close(e) {
		Dispatcher.emit(Dispatcher.Events.REMOVE_CHATBOX, Dispatcher.Store.get(this.eventName, this.props.user.id));
	},
	toggle(e) {
		if (this.visible)
			this.hide();
		else 
			this.show();
	},
	render(){
		const user = Dispatcher.Store.get(this.eventName, this.props.user.id);
		if (user) {
			const className = 'chatbox ' + util.getClassName(this.props);
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? sessionManager.get('noavatarman') : sessionManager.get('noavatarwoman'));
			const href = '/' + user.name; 
			const messages = util.getAttr.bind(user)('messages', []);
			return (
				<div className={className}>
					<div className='header'>
						<div className='name'><a href={href}><span>{user.displayname}</span></a></div>
						<div className='close' onClick={this.close}>{localization.close_sign}</div>
						<div className='toggle' onClick={this.toggle}>{localization.minimize_sign}</div>
						<div className='clearfix'></div>
					</div>
					<div className='messages'>
						{messages.map(function(item, i) {
							return <MessageItem message={item} key={i} />;
						})}
					</div>
					<div className='send'>
						<input type='text' className='' onKeyPress={this.onKeyPress} />
						<input type='button' value={localization.send} onClick={this.onSend} />
						<div className='clearfix'></div>
					</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

window.ChatBox = ChatBox;
export default window.ChatBox;