$(document).ready(function () {
    let activeChat = null;

    function openChat(user) {
        activeChat = user.user_id;
        $('#chat-header').text(user.username);
        $('#messages').html('');
        loadMessages(user.user_id);
    }

    function loadMessages(contact_id) {
        $.getJSON("fetch_messages.php?contact_id=" + contact_id, function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }

            $('#messages').html('');
            data.forEach(function (message) {
                let messageClass = message.is_sent ? 'sent' : 'received';
                let timestamp = new Date(message.sent_at).toLocaleTimeString();

                $('#messages').append(`
                    <div class="message ${messageClass}">
                        <span>${message.content}</span>
                        <div class="small text-muted">${timestamp}</div>
                    </div>
                `);
            });

            $('#messages').scrollTop($('#messages')[0].scrollHeight);
        });
    }

    function sendMessage() {
        if (!activeChat) {
            alert("Please select a contact first.");
            return;
        }

        let messageText = $('#message-input').val().trim();
        if (messageText === '') return;

        $('#send-message-btn').prop('disabled', true);

        $.post("send_message.php", {
            receiver_id: activeChat,
            content: messageText
        }, function (response) {
            if (response === "success") {
                $('#message-input').val('');
                loadMessages(activeChat);
            } else {
                alert("Error sending message: " + response);
            }

            $('#send-message-btn').prop('disabled', false);
        }).fail(function () {
            alert("Failed to send message. Please try again.");
            $('#send-message-btn').prop('disabled', false);
        });
    }

    $(document).off('click', '#send-message-btn').on('click', '#send-message-btn', sendMessage);

    $(document).off('click', '.contact').on('click', '.contact', function () {
        const contact = $(this).data('contact');
        openChat(contact);
    });

    function loadContacts() {
        $.getJSON('fetch_contacts.php', function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }

            $('#contacts-list').html('');
            data.forEach(function (contact) {
                $('#contacts-list').append(`
                    <div class="contact" data-contact='${JSON.stringify(contact)}'>
                        ${contact.username}
                    </div>
                `);
            });
        });
    }

    loadContacts();
});
