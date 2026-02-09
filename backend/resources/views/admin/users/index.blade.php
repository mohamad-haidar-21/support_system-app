@extends('admin.layout')
@section('content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Create User Section -->
    <div class="section-header">
        <div>
            <h2 class="section-title">Create New User</h2>
            <p class="section-subtitle">Add a new user to the system</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" class="user-form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="input-icon" data-icon="👤">
                        <input 
                            type="text" 
                            name="name" 
                            class="form-input" 
                            placeholder="Enter full name"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-icon" data-icon="📧">
                        <input 
                            type="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="user@example.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">User Role</label>
                    <div class="select-wrapper">
                        <select name="role" class="form-select" required>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                    </div>
                    @error('role')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-submit">
                    <button type="submit" class="btn btn-primary btn-create">
                        <span class="btn-icon">+</span>
                        Create User
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users List Section -->
    <div class="section-header">
        <div>
            <h2 class="section-title">All Users</h2>
            <p class="section-subtitle">Manage existing users</p>
        </div>
        <div class="user-count">
            <span class="count-number">{{ $users->total() }}</span>
            <span class="count-label">Total Users</span>
        </div>
    </div>

    <div class="table-card">
        @if($users->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <span class="user-id">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="user-name">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-role badge-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">
                                            <span class="status-dot"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <span class="status-dot"></span>
                                            Disabled
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <form method="POST" action="/admin/users/{{ $user->id }}/toggle" style="display:inline">
                                            @csrf
                                            <button type="submit" class="action-btn btn-toggle" title="{{ $user->is_active ? 'Disable' : 'Enable' }} user">
                                                @if($user->is_active)
                                                    <span class="btn-icon">⏸</span>
                                                @else
                                                    <span class="btn-icon">▶</span>
                                                @endif
                                                {{ $user->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" title="Delete user">
                                                <span class="btn-icon">🗑</span>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h3>No users found</h3>
                <p>Create your first user using the form above</p>
            </div>
        @endif
    </div>

    <style>
        /* Alert Styles */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 32px;
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

        .alert-icon {
            width: 24px;
            height: 24px;
            background: #48bb78;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .section-subtitle {
            font-size: 14px;
            color: #718096;
        }

        .user-count {
            text-align: center;
            padding: 16px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }

        .count-number {
            display: block;
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .count-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 48px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon::before {
            content: attr(data-icon);
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            padding: 12px 40px 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .error-text {
            color: #f5576c;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
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

        .btn-create {
            width: 100%;
            padding: 14px 24px;
            font-size: 16px;
        }

        .btn-icon {
            font-size: 18px;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        /* User Info */
        .user-id {
            font-weight: 700;
            color: #718096;
            font-size: 13px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 600;
            color: #2d3748;
        }

        .user-email {
            color: #718096;
            font-size: 14px;
        }

        /* Badges */
        .badge-role {
            font-size: 11px;
        }

        .badge-customer {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .badge-support {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .badge-success .status-dot {
            background: #48bb78;
            animation: pulse 2s infinite;
        }

        .badge-danger .status-dot {
            background: #f5576c;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 14px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-toggle {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .btn-toggle:hover {
            background: rgba(237, 137, 54, 0.2);
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
        }

        .btn-delete:hover {
            background: rgba(245, 87, 108, 0.2);
            transform: translateY(-2px);
        }

        .action-btn .btn-icon {
            font-size: 14px;
        }

        /* Pagination */
        .pagination-wrapper {
            padding: 24px 32px;
            border-top: 2px solid #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .user-count {
                width: 100%;
            }

            .form-card {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
            }
        }
    </style>
@endsection