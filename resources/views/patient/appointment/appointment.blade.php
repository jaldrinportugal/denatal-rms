<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="header">
        <h4><i class="fa-regular fa-calendar-check"></i> Appointment</h4>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
            
    @error('date')
        <div style="color:red">{{ $message }}</div>
    @enderror
    <form class="form" method="post" action="{{ route('patient.calendar.store') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group form-inline">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" style="width: 35%;" id="date" name="date" required>
        
            <label for="time" class="form-label time">Time</label>
            <input type="time" class="form-control" style="width: 25%;" id="time" name="time" required>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn btn-primary"><i class="fa-regular fa-calendar-check"></i> Appoint</button>  
        </div>
    </form>
</body>
</html>

@section('title')
    Appointment
@endsection

</x-app-layout>