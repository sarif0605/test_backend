@extends('layouts.admin')

@section('content')
    <!-- Kalender Card -->
    <div class="card shadow mb-4 mt-5 pt-3">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h6 class="m-0 font-weight-bold text-white">Kalender</h6>
        </div>
        <div class="card-body">
            <!-- Navigasi Bulan -->
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-secondary" onclick="navigateMonth(-1)">&#60; Sebelumnya</button>
                <h3 class="text-center">{{ $date->format('F Y') }}</h3>
                <button class="btn btn-secondary" onclick="navigateMonth(1)">Berikutnya &#62;</button>
            </div>

            <!-- Tabel Kalender -->
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-light">
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startOfMonth = $date->copy()->startOfMonth();
                            $endOfMonth = $date->copy()->endOfMonth();
                            $startDay = $startOfMonth->dayOfWeek;
                            $daysInMonth = $endOfMonth->day;
                        @endphp
                        <tr>
                            @for($i = 0; $i < $startDay; $i++)
                                <td class="bg-light"></td>
                            @endfor
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $dayOfWeek = ($startDay + $day - 1) % 7;
                                    if ($dayOfWeek == 0 && $day > 1) echo '</tr><tr>';
                                @endphp
                                <td class="py-3">{{ $day }}</td>
                            @endfor
                            @for($i = $startDay + $daysInMonth; $i % 7 != 0; $i++)
                                <td class="bg-light"></td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function navigateMonth(offset) {
                const currentDate = new Date("{{ $date->toDateString() }}");
                currentDate.setMonth(currentDate.getMonth() + offset);
                window.location.href = '/calender?date=' + currentDate.toISOString().split('T')[0];
            }
        </script>
    @endpush
@endsection
