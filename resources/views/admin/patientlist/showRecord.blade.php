<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <style>
            .header {
                background-color: #4b9cd3;
                box-shadow: 0 2px 4px rgba(0,0,0,0.4);
                color: white;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 1.5rem;
                font-weight: bold;
            }
            .btn-icon {
                display: inline-block;
                padding: 0.5rem;
                font-size: 1.2rem;
                color: #4b9cd3;
                margin-right: 0.5rem;
                text-decoration: none;
            }
            .btn-icon:hover {
                color: #333;
            }
            .btn-primary {
                display: inline-block;
                padding: 0.5rem 1rem;
                font-size: 1rem;
                color: white;
                background-color: #4b9cd3;
                border: none;
                border-radius: 0.25rem;
                text-decoration: none;
            }
            .btn-primary:hover {
                background-color: #357abd;
            }
            .grid-container {
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
                grid-template-rows: auto auto auto;
                gap: 1rem;
                padding: 1rem;
            }
            .grid-item {
                background-color: white;
                border-radius: 0.75rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 1rem;
            }
            .patient-name {
                grid-column: 1;
                grid-row: 1;
            }
            .patient-info {
                grid-column: 1;
                grid-row: 2 / span 2;
            }
            .upcoming-appointment {
                grid-column: 2 / span 2;
                grid-row: 1;
            }
            .records {
                grid-column: 2;
                grid-row: 2 / span 2;
            }
            .notes {
                grid-column: 3;
                grid-row: 2 / span 2;
            }
            .table-container {
                max-width: 100%;
                overflow-x: auto;
            }
            .table-container table {
                width: 100%;
                border-collapse: collapse;
            }
            .table-container th, .table-container td {
                padding: 0.75rem;
                text-align: left;
                border-bottom: 1px solid #ddd;
                white-space: nowrap;
            }
            .alert {
                padding: 1rem;
                margin-bottom: 1rem;
                border-radius: 0.25rem;
            }
            .alert-success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            .alert-error {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            .actions {
                display: flex;
                gap: 0.5rem;
            }
        </style>
    </head>
    <body class="min-h-screen bg-gray-200">
        <div class="header">
            <h4>Patient List <i class="fa-solid fa-arrow-right-long"></i> {{ $patientlist->name }}</h4>
        </div>

        <div class="grid-container">
            <div class="grid-item patient-name">
                <h2 class="text-xl font-bold">{{ $patientlist->name }}</h2>
            </div>

            <div class="grid-item patient-info">
                <table class="table-auto w-full">
                    <tr>
                        <th class="text-left">Gender:</th>
                        <td>{{ $patientlist->gender }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Age:</th>
                        <td>{{ $patientlist->age }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Phone No:</th>
                        <td>{{ $patientlist->phone }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Address:</th>
                        <td>{{ $patientlist->address }}</td>
                    </tr>
                </table>
            </div>

            <div class="grid-item upcoming-appointment">
                <h2 class="text-xl font-bold mb-4">Upcoming Appointment</h2>
                <!-- Add appointment content here -->
            </div>

            <div class="grid-item records">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-error">{{ $error }}</p>
                    @endforeach
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-container" id="recordsTableContainer">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-bold">List of Records</h2>
                        <a href="{{ route('admin.record.create', $patientlist->id) }}" class="btn-primary">Add Record</a>
                    </div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $record->file }}</td>
                                    <td class="actions">
                                        <a href="{{ route('downloadRecord', $record->id) }}" class="btn-icon" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a href="{{ route('updateRecord', [$patientlist->id, $record->id]) }}" class="btn-icon" title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form method="post" action="{{ route('deleteRecord', [$patientlist->id, $record->id]) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon" title="Delete" onclick="return confirm('Are you sure you want to delete this record?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid-item notes">
                <h2 class="text-xl font-bold mb-4">Notes</h2>
                <!-- Add notes content here -->
            </div>
        </div>
    </body>
    </html>

    @section('title')
        Record
    @endsection
</x-app-layout>