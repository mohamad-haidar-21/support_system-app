<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Dashboard</title>
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
        }

        /* Header */
        .dashboard-header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .support-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
        }

        .logout-btn::before {
            content: "→";
            font-size: 18px;
            transform: rotate(180deg);
            display: inline-block;
        }

        /* Main Container */
        .dashboard-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 40px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card.live {
            border-color: #48bb78;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(56, 161, 105, 0.05) 100%);
        }

        .stat-card.tickets {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            font-size: 24px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1a202c;
            line-height: 1;
        }

        /* Section */
        .section {
            background: white;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: attr(data-icon);
            font-size: 24px;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead tr {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        th {
            color: white;
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th:first-child {
            border-radius: 12px 0 0 0;
        }

        th:last-child {
            border-radius: 0 12px 0 0;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            color: #2d3748;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f7fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:last-child td:first-child {
            border-radius: 0 0 0 12px;
        }

        tbody tr:last-child td:last-child {
            border-radius: 0 0 12px 0;
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

        .badge-unassigned {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .badge-taken {
            background: rgba(72, 187, 120, 0.1);
            color: #38a169;
        }

        .badge-open {
            background: rgba(66, 153, 225, 0.1);
            color: #4299e1;
        }

        .badge-pending {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .badge-closed {
            background: rgba(113, 128, 150, 0.1);
            color: #718096;
        }

        .badge-low {
            background: rgba(72, 187, 120, 0.1);
            color: #38a169;
        }

        .badge-medium {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .badge-high {
            background: rgba(245, 101, 101, 0.1);
            color: #f56565;
        }

        .badge-urgent {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Customer Info */
        .customer-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .customer-details {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }

        .customer-email {
            font-size: 12px;
            color: #718096;
        }

        /* Action Button */
        .btn-open {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-open:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        /* ID Badge */
        .id-badge {
            font-weight: 700;
            color: #718096;
            font-size: 13px;
        }

        /* Timestamp */
        .timestamp {
            font-size: 13px;
            color: #718096;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid #e2e8f0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 16px 20px;
                flex-direction: column;
                gap: 16px;
            }

            .dashboard-container {
                margin: 20px auto;
                padding: 0 20px;
            }

            .section {
                padding: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: scroll;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="dashboard-header">
        <h1>
            <div class="support-icon">S</div>
            Support Dashboard
        </h1>
        <form method="POST" action="{{ route('support.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Main Container -->
    <div class="dashboard-container">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card live">
                <div class="stat-header">
                    <span class="stat-title">Live Chats</span>
                    <span class="stat-icon">💬</span>
                </div>
                <div class="stat-value">{{ $liveChats->total() }}</div>
            </div>
            <div class="stat-card tickets">
                <div class="stat-header">
                    <span class="stat-title">Total Tickets</span>
                    <span class="stat-icon">🎫</span>
                </div>
                <div class="stat-value">{{ $tickets->total() }}</div>
            </div>
        </div>

        <!-- Live Chats Section -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title" data-icon="💬">Live Chats (Direct)</h2>
            </div>

            @if($liveChats->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liveChats as $c)
                                <tr>
                                    <td>
                                        <span class="id-badge">#{{ $c->id }}</span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="customer-avatar">
                                                {{ substr($c->customer->name, 0, 1) }}
                                            </div>
                                            <div class="customer-details">
                                                <span class="customer-name">{{ $c->customer->name }}</span>
                                                <span class="customer-email">{{ $c->customer->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($c->support_id)
                                            <span class="badge badge-taken">Taken</span>
                                        @else
                                            <span class="badge badge-unassigned">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="timestamp">{{ $c->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('support.conversations.show', $c) }}" class="btn-open">
                                            Open Chat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    {{ $liveChats->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <h3>No active chats</h3>
                    <p>All chats have been resolved</p>
                </div>
            @endif
        </div>

        <!-- Tickets Section -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title" data-icon="🎫">Support Tickets</h2>
            </div>

            @if($tickets->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $t)
                                <tr>
                                    <td>
                                        <span class="id-badge">#{{ $t->id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $t->title }}</strong>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="customer-avatar">
                                                {{ substr($t->customer->name, 0, 1) }}
                                            </div>
                                            <span class="customer-name">{{ $t->customer->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ strtolower($t->status) }}">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ strtolower($t->priority) }}">
                                            {{ ucfirst($t->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('support.tickets.show', $t) }}" class="btn-open">
                                            Open Ticket
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🎫</div>
                    <h3>No tickets found</h3>
                    <p>All tickets have been resolved</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
