<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<style>
    .day.active .hourly-appointments {
        display: block;
    }
    .has-appointments {
        background-color: #f1eaead3;
    }
</style>
<body class="min-h-screen bg-gray-200" style="margin: 0; padding: 0;">

    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="header py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center my-5 p-2.5">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-7 gap-px p-2.5">
        <!-- Month name above weekdays -->
        <div class="w-full text-center my-5 flex flex-col py-3.5 px-5 text-white mb-1 shadow-md text-2xl font-semibold" style="background-color: #4b9cd3; grid-column: 1 / -1; text-align: center;">
            <h2><i class="fa-solid fa-calendar-days"></i> {{ date('F Y') }}</h2>
        </div>

        <!-- Days of the week headers starting from Saturday -->
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Saturday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Sunday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Monday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Tuesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Wednesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Thursday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Friday</div>

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

                <div class="day bg-white min-h-[100px] flex flex-col items-center justify-center p-2.5 border border-gray-300 relative cursor-pointer {{ $hasAppointments ? 'has-appointments' : '' }}" onclick="toggleAppointments(this)">
                    <div>{{ $dayOfMonth }}</div>
                    <div class="hourly-appointments hidden absolute top-full left-0 w-full bg-white shadow-lg z-50 p-2.5 max-h-[200px] overflow-y-auto">
                        @foreach (range(0, 23) as $hour)
                            <div class="hourly-slot mb-1 p-1 border border-gray-300">
                                <strong>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</strong>
                                @php $hasAppointment = false; @endphp
                                @foreach ($calendars as $calendar)
                                    @if (date('j', strtotime($calendar->date)) == $dayOfMonth && date('G', strtotime($calendar->time)) == $hour)
                                        <div class="appointment bg-[#f1eaead3] p-[5px] mt-[5px] rounded text-center w-full box-border">
                                            <strong>{{ $calendar->time }}</strong><br>
                                            {{ $calendar->name }}
                                            <div class="appointment-buttons mt-1 flex justify-between">
                                                <a href="{{ route('admin.updateCalendar', $calendar->id) }}" class="py-1 px-2 rounded bg-white hover:bg-gray-300 text-gray-800 mr-[5px] inline-block" title="Update"><i class="fa-solid fa-pen"></i></a>
                                                <form method="post" action="{{ route('admin.deleteCalendar', $calendar->id) }}" class="mr-[5px] inline-block" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="py-1 px-2 rounded bg-white text-red-800 hover:bg-red-200" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa-solid fa-trash"></i></button>
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
                <div class="day empty" style="background-color: #fff; border: 1px solid #ddd;"></div> <!-- Empty cells before the first day of the month -->
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