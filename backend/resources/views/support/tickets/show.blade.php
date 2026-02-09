<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->id }}</title>
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
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Header */
        .page-header {
            background: white;
            padding: 24px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 32px;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-id {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .ticket-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .ticket-id h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
        }

        .ticket-id span {
            font-size: 20px;
            color: #718096;
        }

        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
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

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
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
            font-size: 20px;
        }

        .alert-success::before {
            content: "✓";
        }

        .alert-error::before {
            content: "⚠";
        }

        /* Grid Layout */
        .ticket-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title::before {
            content: attr(data-icon);
            font-size: 22px;
        }

        /* Ticket Info */
        .ticket-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .ticket-description {
            background: #f7fafc;
            padding: 20px;
            border-radius: 12px;
            color: #2d3748;
            line-height: 1.7;
            margin-bottom: 24px;
            border-left: 4px solid #48bb78;
        }

        .info-grid {
            display: grid;
            gap: 16px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-label {
            font-size: 13px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 80px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
        }

        /* Customer Card */
        .customer-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }

        .customer-avatar {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: white;
            color: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            flex-shrink: 0;
        }

        .customer-info h3 {
            font-size: 18px;
            margin-bottom: 4px;
        }

        .customer-info p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-open {
            background: rgba(66, 153, 225, 0.15);
            color: #4299e1;
        }

        .badge-in_progress {
            background: rgba(237, 137, 54, 0.15);
            color: #ed8936;
        }

        .badge-resolved {
            background: rgba(72, 187, 120, 0.15);
            color: #38a169;
        }

        .badge-closed {
            background: rgba(113, 128, 150, 0.15);
            color: #718096;
        }

        .badge-low {
            background: rgba(72, 187, 120, 0.15);
            color: #38a169;
        }

        .badge-medium {
            background: rgba(237, 137, 54, 0.15);
            color: #ed8936;
        }

        .badge-high {
            background: rgba(245, 101, 101, 0.15);
            color: #f56565;
        }

        .badge-urgent {
            background: rgba(245, 87, 108, 0.15);
            color: #f5576c;
            animation: pulse 2s infinite;
        }

        /* Attachments */
        .attachments-list {
            list-style: none;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f7fafc;
            border-radius: 10px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .attachment-item:hover {
            background: #edf2f7;
            transform: translateX(4px);
        }

        .attachment-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .attachment-info {
            flex: 1;
        }

        .attachment-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .attachment-type {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
        }

        .attachment-link {
            background: #48bb78;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .attachment-link:hover {
            background: #38a169;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #718096;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        /* Status Form */
        .status-form {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            padding: 24px;
            border-radius: 12px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: "▼";
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #718096;
            font-size: 12px;
        }

        .form-select {
            width: 100%;
            padding: 14px 40px 14px 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            font-weight: 600;
        }

        .form-select:focus {
            outline: none;
            border-color: white;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        .btn-save {
            width: 100%;
            padding: 14px;
            background: white;
            color: #38a169;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Chat Link */
        .chat-link-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px;
            border-radius: 12px;
            text-align: center;
        }

        .chat-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: #667eea;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .chat-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .chat-link::before {
            content: "💬";
            font-size: 20px;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .ticket-grid {
                grid-template-columns: 1fr;
            }

            .page-header,
            .container {
                padding-left: 20px;
                padding-right: 20px;
            }

            .card {
                padding: 24px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="ticket-id">
                <div class="ticket-icon">🎫</div>
                <div>
                    <h1>Ticket <span>#{{ $ticket->id }}</span></h1>
                </div>
            </div>
            <a href="{{ route('support.dashboard') }}" class="btn-back">Dashboard</a>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <!-- Grid Layout -->
        <div class="ticket-grid">
            <!-- Main Content -->
            <div>
                <!-- Ticket Details Card -->
                <div class="card">
                    <h2 class="ticket-title">{{ $ticket->title }}</h2>

                    <div class="ticket-description">
                        {{ $ticket->description }}
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="badge badge-{{ $ticket->status }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Priority</span>
                            <span class="badge badge-{{ $ticket->priority }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Attachments Card -->
                <div class="card" style="margin-top: 24px;">
                    <div class="card-header">
                        <h3 class="card-title" data-icon="📎">Attachments</h3>
                        <span class="badge badge-open">{{ count($ticket->attachments) }}</span>
                    </div>

                    @if(count($ticket->attachments) > 0)
                        <ul class="attachments-list">
                            @foreach($ticket->attachments as $a)
                                <li class="attachment-item">
                                    <div class="attachment-icon">📄</div>
                                    <div class="attachment-info">
                                        <div class="attachment-name">
                                            {{ $a->original_name ?? basename($a->file_path) }}
                                        </div>
                                        <div class="attachment-type">{{ $a->type }}</div>
                                    </div>
                                    <a href="/{{ $a->file_path }}" target="_blank" class="attachment-link">
                                        Download
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📎</div>
                            <p>No attachments</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Customer Card -->
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div class="card-header" style="padding: 20px 24px; margin: 0; border: none;">
                        <h3 class="card-title" data-icon="👤">Customer</h3>
                    </div>
                    <div class="customer-card" style="border-radius: 0;">
                        <div class="customer-avatar">
                            {{ substr($ticket->customer->name, 0, 1) }}
                        </div>
                        <div class="customer-info">
                            <h3>{{ $ticket->customer->name }}</h3>
                            <p>{{ $ticket->customer->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Update Card -->
                <div class="card" style="margin-top: 24px; padding: 0; overflow: hidden;">
                    <div class="card-header" style="padding: 20px 24px; margin: 0; border: none;">
                        <h3 class="card-title" data-icon="⚙️">Update Status</h3>
                    </div>
                    <div class="status-form">
                        <form method="POST" action="{{ route('support.tickets.status', $ticket) }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Ticket Status</label>
                                <div class="select-wrapper">
                                    <select name="status" class="form-select">
                                        <option value="open" @selected($ticket->status === 'open')>Open</option>
                                        <option value="in_progress" @selected($ticket->status === 'in_progress')>In
                                            Progress</option>
                                        <option value="resolved" @selected($ticket->status === 'resolved')>Resolved
                                        </option>
                                        <option value="closed" @selected($ticket->status === 'closed')>Closed</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn-save">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Chat Link Card -->
                @if($ticket->conversation)
                    <div class="card" style="margin-top: 24px; padding: 0; overflow: hidden;">
                        <div class="chat-link-card">
                            <a href="{{ route('support.conversations.show', $ticket->conversation) }}" class="chat-link">
                                Open Ticket Chat
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
