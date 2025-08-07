 class Chatbot {
    constructor() {
        this.init();
        this.isOpen = false;
    }

    init() {
        // Create chat container
        const container = document.createElement('div');
        container.className = 'chat-container';
        
        // Create chat button
        const button = document.createElement('button');
        button.className = 'chat-button';
        button.innerHTML = '💬';
        button.onclick = () => this.toggleChat();
        
        // Create chat window
        const chatWindow = document.createElement('div');
        chatWindow.className = 'chat-window';
        
        // Create chat header
        const header = document.createElement('div');
        header.className = 'chat-header';
        header.textContent = 'Chat Assistant';
        
        // Create messages container
        const messages = document.createElement('div');
        messages.className = 'chat-messages';
        
        // Create input area
        const inputArea = document.createElement('div');
        inputArea.className = 'chat-input';
        
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Type your message...';
        input.onkeypress = (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        };
        
        const sendButton = document.createElement('button');
        sendButton.textContent = 'Send';
        sendButton.onclick = () => this.sendMessage();
        
        // Assemble the components
        inputArea.appendChild(input);
        inputArea.appendChild(sendButton);
        chatWindow.appendChild(header);
        chatWindow.appendChild(messages);
        chatWindow.appendChild(inputArea);
        container.appendChild(button);
        container.appendChild(chatWindow);
        
        document.body.appendChild(container);
        
        // Store references
        this.chatWindow = chatWindow;
        this.messagesContainer = messages;
        this.input = input;
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        this.chatWindow.classList.toggle('active');
        
        if (this.isOpen && !this.hasGreeted) {
            this.addMessage('Hello! How can I help you today?', 'bot');
            this.hasGreeted = true;
        }
    }

    addMessage(text, sender) {
        const message = document.createElement('div');
        message.className = `message ${sender}-message`;
        message.textContent = text;
        this.messagesContainer.appendChild(message);
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

    async sendMessage() {
        const text = this.input.value.trim();
        if (!text) return;

        const baseUrl = "http://localhost/fwe/public/";

        // Add user message
        this.addMessage(text, 'user');
        this.input.value = '';

        try {
            const response = await fetch(baseUrl + '/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: text })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            // Antwort als Text empfangen (keine Chunks, kein Stream)
            const result = await response.text();

            // Versuche JSON zu parsen, falls API so antwortet
            let output = result;
            try {
                const json = JSON.parse(result);
                if (json.chunk) {
                    output = json.chunk;
                } else if (json.message) {
                    output = json.message;
                } else if (json.error) {
                    output = json.error;
                }
            } catch (e) {
                // Kein JSON, einfach als Text ausgeben
            }

            this.addMessage(output, 'bot');

        } catch (error) {
            console.error('Error:', error);
            this.addMessage('Sorry, there was an error processing your request.', 'bot');
        }
    }
}

// Initialize chatbot when the page loads
document.addEventListener('DOMContentLoaded', () => {
    new Chatbot();
});
