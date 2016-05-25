/**
 * ChatBox defination
 */
var ChatBox = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.UPDATE_CHATBOX,
	refreshCount: 0,
	refresh() {
		this.setState({refreshCount: this.refreshCount++});
		this.scrollToBottom();
	},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
		Dispatcher.removeListener(AppEvents.SHOW_CHATBOX, this.showMe);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(AppEvents.SHOW_CHATBOX, this.showMe);
		this.scrollToBottom();
		this.getJQueryTextbox().focus();
		
		const user = appStore.get(this.eventName, this.props.user.id);
		appStore.set(AppEvents.LOAD_RECENT_MESSAGES, user);
	},
	showMe() {
		const user = appStore.get(AppEvents.SHOW_CHATBOX, this.props.user.id);
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
		return $(this.getRootDom());
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
		const receiver = appStore.get(this.eventName, this.props.user.id);
		if (receiver && message) {
			if (appManager.isLogged()) {
				ajax.post('/sendmessage', function(response) {
					appStore.set(AppEvents.SENT_MESSAGE, response.data);
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
		appStore.set(AppEvents.REMOVE_CHATBOX, appStore.get(this.eventName, this.props.user.id));
	},
	toggle(e) {
		if (this.visible)
			this.hide();
		else 
			this.show();
	},
	render(){
		const user = appStore.get(this.eventName, this.props.user.id);
		if (user) {
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? appManager.get('noavatarman') : appManager.get('noavatarwoman'));
			this.href = '/' + user.name; 
			const messages = attr.bind(user)('messages', []);
			return (
				<div className={this.className('', 'chatbox')}>
					<div className='header'>
						<div className='name'><a onClick={this.onOpenLink}><span>{user.displayname}</span></a></div>
						<div className='close' onClick={this.close}>{configurations.localization.close_sign}</div>
						<div className='toggle' onClick={this.toggle}>{configurations.localization.minimize_sign}</div>
						<div className='clearfix'></div>
					</div>
					<div className='messages'>
						{messages.map(function(item, i) {
							return <MessageItem message={item} key={i} />;
						})}
					</div>
					<div className='send'>
						<input type='text' className='' onKeyPress={this.onKeyPress} />
						<input type='button' value={configurations.localization.send} onClick={this.onSend} />
						<div className='clearfix'></div>
					</div>
					<div className='clearfix'></div>
				</div>
			);
		}
		return null;
	}
});

module.exports = window.ChatBox = ChatBox;