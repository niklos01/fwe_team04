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

        // Add user message
        this.addMessage(text, 'user');
        this.input.value = '';

        try {
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: text })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const reader = response.body.getReader();
            let partialResponse = '';

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                // Convert the chunk to text and append to partial response
                partialResponse += new TextDecoder().decode(value);

                // Split by newlines to handle multiple chunks
                const chunks = partialResponse.split('\n');
                
                // Process all complete chunks
                for (let i = 0; i < chunks.length - 1; i++) {
                    if (chunks[i].trim()) {
                        this.addMessage(chunks[i], 'bot');
                    }
                }

                // Keep the last partial chunk
                partialResponse = chunks[chunks.length - 1];
            }

            // Handle any remaining response
            if (partialResponse.trim()) {
                this.addMessage(partialResponse, 'bot');
            }

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
