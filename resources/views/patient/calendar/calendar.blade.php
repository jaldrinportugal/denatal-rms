<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/patient.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="header">
        <h4><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
    </div>

    <div class="container">
        <h2><i class="fa-solid fa-calendar-days"></i> {{ date('F Y') }}</h2> <!-- Displaying current month and year -->
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="calendar">
        <!-- Month name above weekdays -->
        <div class="header" style="grid-column: 1 / -1; text-align: center;">
            <h3>{{ date('F') }}</h3>
        </div>

        <!-- Days of the week headers starting from Saturday -->
        <div class="day-header">Saturday</div>
        <div class="day-header">Sunday</div>
        <div class="day-header">Monday</div>
        <div class="day-header">Tuesday</div>
        <div class="day-header">Wednesday</div>
        <div class="day-header">Thursday</div>
        <div class="day-header">Friday</div>

        <!-- Generating days for the current month starting from Saturday -->
        @php
            $firstDayOfMonth = date('w', strtotime(date('Y-m-01'))); // Get the weekday index (0 = Sunday)
            $daysInMonth = date('t'); // Get the number of days in the current month
        @endphp

        @for ($i = 1; $i <= $daysInMonth + $firstDayOfMonth; $i++)
            @if ($i > $firstDayOfMonth)
                @php
                    $dayOfMonth = $i - $firstDayOfMonth;
                    $currentDayOfWeek = ($i - 1) % 7; // Calculate current day of week index
                    $hasAppointments = $calendars->filter(function ($calendar) use ($dayOfMonth) {
                        return date('j', strtotime($calendar->date)) == $dayOfMonth;
                    })->isNotEmpty();
                @endphp

                <div class="day {{ $hasAppointments ? 'has-appointments' : '' }}" onclick="toggleAppointments(this)">
                    <div>{{ $dayOfMonth }}</div>
                    <div class="hourly-appointments">
                        @foreach (range(0, 23) as $hour)
                            <div class="hourly-slot">
                                <strong>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</strong>
                                @php $hasAppointment = false; @endphp
                                @foreach ($calendars as $calendar)
                                    @if (date('j', strtotime($calendar->date)) == $dayOfMonth && date('G', strtotime($calendar->time)) == $hour)
                                        <div class="appointment">
                                            <strong>{{ $calendar->time }}</strong><br>
                                            {{ $calendar->name }}
                                            <div class="appointment-buttons">
                                                <a href="{{ route('admin.updateCalendar', $calendar->id) }}" class="btn btn-light" title="Update"><i class="fa-solid fa-pen"></i></a>
                                                <form method="post" action="{{ route('admin.deleteCalendar', $calendar->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        @php $hasAppointment = true; @endphp
                                    @endif
                                @endforeach
                                @if (!$hasAppointment)
                                    <div>No appointments</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="day empty"></div> <!-- Empty cells before the first day of the month -->
            @endif
        @endfor
    </div>

    <script>
        function toggleAppointments(dayElement) {
            // Close all other open appointments
            document.querySelectorAll('.day.active').forEach(day => {
                if (day !== dayElement) {
                    day.classList.remove('active');
                }
            });

            // Toggle active class to show/hide hourly appointments
            dayElement.classList.toggle('active');
        }
    </script>

</body>
</html>

@section('title')
    Calendar
@endsection

</x-app-layout>