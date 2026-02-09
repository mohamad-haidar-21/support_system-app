<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>
    <link rel="icon" type="image/png" href="{{ asset('iconsupport.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 0;
        }

        /* Header */
        .admin-header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        /* Main Content */
        .admin-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .content-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 24px;
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 13px;
            opacity: 0.8;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
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

        tr:hover {
            background: #f7fafc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:last-child td:first-child {
            border-radius: 0 0 0 12px;
        }

        tr:last-child td:last-child {
            border-radius: 0 0 12px 0;
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 87, 108, 0.4);
        }

        .danger {
            color: #f5576c;
            font-weight: 600;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        .badge-warning {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .badge-danger {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
        }

        /* Section Title */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
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
            .admin-header {
                padding: 16px 20px;
                flex-direction: column;
                gap: 16px;
            }

            .admin-container {
                margin: 20px auto;
                padding: 0 20px;
            }

            .content-card {
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
    <div class="admin-header">
        <h1>
            <div class="admin-icon">A</div>
            Admin Panel
        </h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="admin-container">
        <div class="content-card">
            @yield('content')
        </div>
    </div>
</body>

</html>
