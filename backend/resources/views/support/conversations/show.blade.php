<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation #{{ $conversation->id }}</title>
    <link rel="icon" type="image/png" href="{{ asset('iconsupport.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f7fafc;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .chat-header {
            background: white;
            padding: 20px 32px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .header-content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .conversation-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .conversation-avatar {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            flex-shrink: 0;
        }

        .conversation-details h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .conversation-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #718096;
        }

        .conversation-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-back::before {
            content: "←";
            font-size: 18px;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-open {
            background: rgba(72, 187, 120, 0.15);
            color: #38a169;
        }

        .badge-closed {
            background: rgba(113, 128, 150, 0.15);
            color: #718096;
        }

        .badge-direct {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
        }

        .badge-ticket {
            background: rgba(237, 137, 54, 0.15);
            color: #ed8936;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-take {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        .btn-take:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.4);
        }

        .btn-close {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 87, 108, 0.4);
        }

        /* Alerts */
        .alert {
            max-width: 1000px;
            margin: 16px auto;
            padding: 14px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
            border: 2px solid rgba(72, 187, 120, 0.3);
        }

        .alert-error {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
            border: 2px solid rgba(245, 87, 108, 0.3);
        }

        .alert::before {
            font-size: 18px;
        }

        .alert-success::before {
            content: "✓";
        }

        .alert-error::before {
            content: "⚠";
        }

        /* Ticket Link */
        .ticket-link-container {
            max-width: 1000px;
            margin: 0 auto 16px;
            padding: 0 32px;
        }

        .ticket-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .ticket-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .ticket-link::before {
            content: "🎫";
            font-size: 16px;
        }

        /* Chat Container */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            padding: 0 32px;
            overflow: hidden;
        }

        /* Messages Area */
        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background: white;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
            border-bottom: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .messages-area::-webkit-scrollbar {
            width: 8px;
        }

        .messages-area::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }

        .messages-area::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .messages-area::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Message Bubble */
        .message {
            display: flex;
            gap: 12px;
            max-width: 75%;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.customer {
            align-self: flex-start;
        }

        .message.support,
        .message.admin {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .message.customer .message-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .message.support .message-avatar {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        .message.admin .message-avatar {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .message-content {
            flex: 1;
        }

        .message-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .message-sender {
            font-weight: 700;
            font-size: 14px;
            color: #1a202c;
        }

        .message-time {
            font-size: 12px;
            color: #a0aec0;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 15px;
            line-height: 1.5;
            color: #2d3748;
            word-wrap: break-word;
        }

        .message.customer .message-bubble {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
        }

        .message.support .message-bubble,
        .message.admin .message-bubble {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        /* Input Area */
        .input-area {
            background: white;
            padding: 20px 24px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
            border-top: none;
            flex-shrink: 0;
        }

        .input-form {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .input-wrapper {
            flex: 1;
        }

        .message-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            resize: vertical;
            min-height: 52px;
            max-height: 120px;
            transition: all 0.3s ease;
        }

        .message-input:focus {
            outline: none;
            border-color: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
        }

        .message-input::placeholder {
            color: #a0aec0;
        }

        .btn-send {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.4);
        }

        .btn-send::after {
            content: "→";
            font-size: 18px;
        }

        .closed-message {
            text-align: center;
            padding: 24px;
            background: rgba(113, 128, 150, 0.1);
            border-radius: 12px;
            color: #718096;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a0aec0;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-header {
                padding: 16px 20px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .chat-container {
                padding: 0 16px;
            }

            .message {
                max-width: 85%;
            }

            .conversation-meta {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="chat-header">
        <div class="header-content">
            <div class="conversation-info">
                <div class="conversation-avatar">
                    {{ substr($conversation->customer->name, 0, 1) }}
                </div>
                <div class="conversation-details">
                    <h1>{{ $conversation->customer->name }}</h1>
                    <div class="conversation-meta">
                        <span>{{ $conversation->customer->email }}</span>
                        <span class="badge badge-{{ $conversation->type }}">{{ ucfirst($conversation->type) }}</span>
                        <span
                            class="badge badge-{{ $conversation->status }}">{{ ucfirst($conversation->status) }}</span>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('support.dashboard') }}" class="btn-back">Dashboard</a>
                <form method="POST" action="{{ route('support.conversations.take', $conversation) }}"
                    style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-take">✓ Take</button>
                </form>
                <form method="POST" action="{{ route('support.conversations.close', $conversation) }}"
                    style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-close">✕ Close</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <!-- Ticket Link -->
    @if($conversation->ticket)
        <div class="ticket-link-container">
            <a href="{{ route('support.tickets.show', $conversation->ticket) }}" class="ticket-link">
                View Related Ticket #{{ $conversation->ticket->id }}
            </a>
        </div>
    @endif

    <!-- Chat Container -->
    <div class="chat-container">
        <!-- Messages Area -->
        <div class="messages-area" id="messagesArea">
            @if(count($messages) > 0)
                @foreach($messages as $m)
                    <div class="message {{ strtolower($m->sender->role) }}">
                        <div class="message-avatar">
                            @if($m->sender->role === 'customer')
                                👤
                            @elseif($m->sender->role === 'support')
                                🎧
                            @else
                                ⚙️
                            @endif
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-sender">{{ ucfirst($m->sender->role) }}</span>
                                <span class="message-time">{{ $m->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="message-bubble">
                                {{ $m->content }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <p>No messages yet</p>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="input-area">
            @if($conversation->status === 'open')
                <form method="POST" action="{{ route('support.conversations.send', $conversation) }}" class="input-form">
                    @csrf
                    <div class="input-wrapper">
                        <textarea name="content" class="message-input" placeholder="Type your message..." required
                            rows="1"></textarea>
                    </div>
                    <button type="submit" class="btn-send">Send</button>
                </form>
            @else
                <div class="closed-message">
                    This conversation has been closed
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-scroll to bottom
        const messagesArea = document.getElementById('messagesArea');
        if (messagesArea) {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        // Auto-expand textarea
        const textarea = document.querySelector('.message-input');
        if (textarea) {
            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }
    </script>
</body>

</html>
