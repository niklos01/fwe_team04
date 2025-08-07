class Chatbot {
    constructor() {
        this.state = {
            isOpen: false,
            hasWelcomeMessage: false,
            hasGreeted: false,
        };

        this.text = {
            welcome: 'Hey, ich bin Cleo! Ich bin hier, um dir zu helfen.',
            greet: 'Soll ich deine Umsätze analysieren?',
            assistantName: 'Cleo, dein Chat Assistant',
            placeholder: 'Schreib deine Nachricht…',
            sendButton: 'Senden',
            error: 'Entschuldigung, bei der Verarbeitung deiner Anfrage ist ein Fehler aufgetreten.',
        };

        this.init();
    }

    init() {
        this.createDOM();
        this.bindEvents();
    }

    createDOM() {
        this.container = document.createElement('div');
        this.container.className = 'chat-container';

        // Button mit Icon
        this.button = document.createElement('button');
        this.button.className = 'chat-button';

        const svgWrapper = document.createElement('div');
        svgWrapper.className = 'chat-icon';
        svgWrapper.innerHTML = `
            <svg width="100%" height="auto" preserveAspectRatio="xMidYMid meet" viewBox="0 0 986 856" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="Group 5">
            <g id="bot">
            <circle id="Ellipse 9" cx="715.5" cy="585.5" r="270.5" fill="url(#paint0_linear_2583_180)"/>
            <g id="Group 4">
            <ellipse id="Ellipse 9_2" cx="716" cy="586" rx="196" ry="163" fill="white"/>
            <g id="Group 2">
            <path id="Subtract" d="M651.615 538C651.873 538 652.13 538.004 652.386 538.012C651.883 539.939 651.615 541.961 651.615 544.046C651.615 557.208 662.286 567.879 675.448 567.879C678.505 567.879 681.426 567.302 684.111 566.254C686.087 572.183 687.188 578.753 687.188 585.666C687.187 611.991 671.261 633.332 651.615 633.332C631.97 633.332 616.044 611.991 616.044 585.666C616.044 559.341 631.97 538 651.615 538Z" fill="black"/>
            <path id="Subtract_2" d="M766.156 538C766.414 538 766.671 538.004 766.927 538.012C766.424 539.939 766.156 541.961 766.156 544.046C766.156 557.208 776.827 567.879 789.989 567.879C793.046 567.879 795.967 567.302 798.652 566.254C800.628 572.184 801.729 578.753 801.729 585.666C801.728 611.991 785.802 633.332 766.156 633.332C746.511 633.332 730.585 611.991 730.585 585.666C730.585 559.341 746.511 538 766.156 538Z" fill="black"/>
            </g>
            </g>
            </g>
            <g id="hey-message">
            <path id="Union" d="M122.659 0.431641C54.9165 0.431641 0 55.3482 0 123.091V255.062C0 322.804 54.9165 377.721 122.659 377.721H440.593L584.043 521.172C585.303 522.432 587.458 521.539 587.458 519.758V377.713C654.686 377.113 709 322.432 709 255.062V123.091C709 55.3482 654.083 0.431641 586.341 0.431641H122.659Z" fill="#01F5FF"/>
            <path id="Hey!" d="M152.98 261V115.545H174.926V178.756H247.44V115.545H269.457V261H247.44V197.577H174.926V261H152.98ZM346.73 263.202C335.982 263.202 326.725 260.905 318.96 256.312C311.242 251.672 305.277 245.162 301.062 236.781C296.896 228.353 294.812 218.481 294.812 207.165C294.812 195.991 296.896 186.142 301.062 177.619C305.277 169.097 311.148 162.444 318.676 157.662C326.252 152.88 335.106 150.489 345.239 150.489C351.394 150.489 357.36 151.507 363.136 153.543C368.913 155.579 374.098 158.775 378.69 163.131C383.283 167.487 386.905 173.145 389.557 180.105C392.208 187.018 393.534 195.422 393.534 205.318V212.847H306.815V196.938H372.724C372.724 191.35 371.588 186.402 369.315 182.094C367.043 177.738 363.847 174.305 359.727 171.795C355.655 169.286 350.873 168.031 345.381 168.031C339.415 168.031 334.206 169.499 329.756 172.435C325.352 175.323 321.943 179.111 319.528 183.798C317.161 188.438 315.977 193.481 315.977 198.926V211.355C315.977 218.647 317.256 224.849 319.812 229.963C322.417 235.077 326.039 238.983 330.679 241.682C335.319 244.333 340.741 245.659 346.943 245.659C350.968 245.659 354.637 245.091 357.952 243.955C361.266 242.771 364.131 241.019 366.545 238.699C368.96 236.379 370.807 233.514 372.085 230.105L392.185 233.727C390.575 239.646 387.687 244.83 383.52 249.281C379.401 253.685 374.216 257.117 367.966 259.58C361.763 261.994 354.685 263.202 346.73 263.202ZM427.394 301.909C424.222 301.909 421.334 301.649 418.729 301.128C416.125 300.654 414.184 300.134 412.906 299.565L418.019 282.165C421.902 283.206 425.358 283.656 428.388 283.514C431.419 283.372 434.094 282.236 436.414 280.105C438.781 277.974 440.865 274.494 442.664 269.665L445.292 262.42L405.377 151.909H428.104L455.732 236.568H456.869L484.496 151.909H507.295L462.337 275.56C460.254 281.241 457.603 286.047 454.383 289.977C451.163 293.955 447.328 296.938 442.877 298.926C438.426 300.915 433.265 301.909 427.394 301.909ZM554.028 115.545L552.181 219.168H532.508L530.661 115.545H554.028ZM542.38 262.349C538.45 262.349 535.088 260.976 532.295 258.23C529.501 255.437 528.128 252.075 528.175 248.145C528.128 244.262 529.501 240.948 532.295 238.202C535.088 235.408 538.45 234.011 542.38 234.011C546.215 234.011 549.53 235.408 552.323 238.202C555.117 240.948 556.537 244.262 556.585 248.145C556.537 250.749 555.851 253.14 554.525 255.318C553.246 257.449 551.542 259.153 549.411 260.432C547.281 261.71 544.937 262.349 542.38 262.349Z" fill="black"/>
            </g>
            </g>
            <defs>
            <linearGradient id="paint0_linear_2583_180" x1="715.5" y1="315" x2="715.5" y2="856" gradientUnits="userSpaceOnUse">
            <stop stop-color="#F530FF"/>
            <stop offset="1" stop-color="#681AFF"/>
            </linearGradient>
            </defs>
            </svg>
        `;
        this.button.appendChild(svgWrapper);

        // Chatfenster
        this.chatWindow = document.createElement('div');
        this.chatWindow.className = 'chat-window';

        const header = document.createElement('div');
        header.className = 'chat-header';
        header.textContent = this.text.assistantName;

        this.messagesContainer = document.createElement('div');
        this.messagesContainer.className = 'chat-messages';

        // Eingabefeld
        const inputArea = document.createElement('div');
        inputArea.className = 'chat-input';

        this.input = document.createElement('input');
        this.input.type = 'text';
        this.input.placeholder = this.text.placeholder;

        this.sendButton = document.createElement('button');
        this.sendButton.innerHTML = `<i class="bi bi-send-fill"></i>`;

        inputArea.appendChild(this.input);
        inputArea.appendChild(this.sendButton);

        this.chatWindow.appendChild(header);
        this.chatWindow.appendChild(this.messagesContainer);
        this.chatWindow.appendChild(inputArea);

        this.container.appendChild(this.button);
        this.container.appendChild(this.chatWindow);

        document.body.appendChild(this.container);
    }

    bindEvents() {
        this.button.addEventListener('click', () => this.toggleChat());

        this.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });

        this.sendButton.addEventListener('click', () => this.sendMessage());
    }

    toggleChat() {
        const { isOpen, hasWelcomeMessage, hasGreeted } = this.state;

        this.container.classList.toggle('open', !isOpen);
        this.chatWindow.classList.toggle('active', !isOpen);

        if (!isOpen && !hasWelcomeMessage) {
            this.addMessage(this.text.welcome, 'bot');
            this.state.hasWelcomeMessage = true;
        }

        if (!isOpen && !hasGreeted) {
            this.addMessage(this.text.greet, 'bot');
            this.state.hasGreeted = true;
        }

        this.state.isOpen = !isOpen;
    }

    addMessage(text, sender) {
        const message = document.createElement('div');
        message.className = `message ${sender}-message`;

        if (sender === 'bot') {
            // Text mit Markdown rendern
            message.innerHTML = marked.parse(text);
        } else {
            // Nur als reiner Text (sicher)
            message.textContent = text;
        }

        this.messagesContainer.appendChild(message);
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }


    async sendMessage() {
        const text = this.input.value.trim();
        if (!text) return;

        const baseUrl = "http://localhost/fwe/public/";

        this.addMessage(text, 'user');
        this.input.value = '';

        try {
            const response = await fetch(`${baseUrl}/api/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: text })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.text();
            let output = result;

            try {
                const json = JSON.parse(result);
                output = json.chunk || json.message || json.error || result;
            } catch (e) {
                // Kein valides JSON – ist okay.
            }

            this.addMessage(output, 'bot');

        } catch (error) {
            console.error('Error:', error);
            this.addMessage(this.text.error, 'bot');
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Chatbot();
});
