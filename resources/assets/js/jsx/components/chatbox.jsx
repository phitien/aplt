/**
 * ChatBox defination
 */
var ChatBox = React.createClass({
	mixins: [createMixin()],
	eventName: AppEvents.CHATUSER_UPDATE,
	refreshCount: 0,
	refresh(data) {
		this.setState({refreshCount: this.refreshCount++});
		if (data == appStore.chatuser(this.props.user.id))
			this.show();
	},
	componentWillUnmount() {
		Dispatcher.removeListener(this.eventName, this.refresh);
		Dispatcher.removeListener(AppEvents.USERMESSAGES_LOADED, this.loaded);
		Dispatcher.removeListener(AppEvents.USERMESSAGES_ADDED_NEW, this.addedNew);
		Dispatcher.removeListener(AppEvents.USERMESSAGES_ADDED_OLD, this.addedOld);
	},
	componentDidMount() {
		Dispatcher.addListener(this.eventName, this.refresh);
		Dispatcher.addListener(AppEvents.USERMESSAGES_LOADED, this.loaded);
		Dispatcher.addListener(AppEvents.USERMESSAGES_ADDED_NEW, this.addedNew);
		Dispatcher.addListener(AppEvents.USERMESSAGES_ADDED_OLD, this.addedOld);
		this.getJQueryTextbox().focus();
	},
	loaded() {
		this.refresh();
		this.scrollToBottom();
	},
	addedNew() {
		this.refresh();
		this.scrollToBottom();
	},
	addedOld() {
		this.refresh();
		this.scrollToTop();
	},
	scrollToBottom() {
		var d = this.getJQueryMessages();
		d.scrollTop(d.prop('scrollHeight'));
	},
	scrollToTop() {
		this.getJQueryMessages().scrollTop(0);
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
		const receiver = appStore.chatuser(this.props.user.id);
		if (receiver && message) {
			if (appManager.isLogged()) {
				ajax.post('/sendmessage', function(response) {
					appStore.addMessage(receiver.id, response.data);
				}, {'message': message, code: receiver.id, id: receiver.itemId});
			}
		}
	},
	visible: true,
	show() {
		var me = this;
		me.visible = true;
		var chatbox = me.getJQueryRoot();
		chatbox.parents('.chatbox-wrapper').removeClass('chatbox-wrapper-collapsed');
		chatbox.find('.messages,.send').slideDown('slow', function() {
			me.getJQueryTextbox().focus();
		});
	},
	hide() {
		var me = this;
		me.visible = false;
		var chatbox = me.getJQueryRoot();
		chatbox.parents('.chatbox-wrapper').addClass('chatbox-wrapper-collapsed');
		chatbox.find('.messages,.send').slideUp('slow');
	},
	close(e) {
		appStore.removechatuser(this.props.user.id);
	},
	toggle(e) {
		if (this.visible)
			this.hide();
		else 
			this.show();
	},
	render(){
		const user = appStore.chatuser(this.props.user.id);
		if (user) {
			this.href = '/' + user.name;
			const avatar = user && user.avatar ? user.avatar : 
				(user.gender == 'MALE' ? appManager.get('noavatarman') : appManager.get('noavatarwoman'));
			const messages = appStore.messages(this.props.user.id);
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