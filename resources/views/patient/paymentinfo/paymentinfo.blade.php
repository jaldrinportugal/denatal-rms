<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/patient.paymentinfo.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="header">
        <h4><i class="fa-solid fa-money-bills"></i> Payment Info</h4>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Balance</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentinfo as $payment)
                <tr>
                    <td>{{ $payment->patient }}</td>
                    <td>{{ $payment->description }}</td>
                    <td><i class="fa-solid fa-peso-sign"></i>{{ $payment->amount }}</td>
                    <td><i class="fa-solid fa-peso-sign"></i>{{ $payment->balance }}</td>
                    <td>{{ $payment->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- pagination here -->
    @if ($paymentinfo->lastPage() > 1)
        <ul class="pagination">
            <!-- Previous Page Link -->
            @if ($paymentinfo->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paymentinfo->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                </li>
            @endif

            <!-- Pagination Elements -->
            @for ($i = 1; $i <= $paymentinfo->lastPage(); $i++)
                @if ($i == $paymentinfo->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paymentinfo->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            <!-- Next Page Link -->
            @if ($paymentinfo->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paymentinfo->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    @endif
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>