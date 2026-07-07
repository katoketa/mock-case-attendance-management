{{-- 必要なデータ：selectInterval('day'または'month') --}}
@push('css')
<link rel="stylesheet" href="{{ asset('css/attendance_date_changer.css') }}">
@endpush
<ul class="date-changer__ul">
    <li class="date-changer__li">
        @if ($selectInterval === 'month')
        <a href="{{ url()->current() . '?date=' . $selectDate->subMonth()->format('Y-m') }}" class="date-changer">
            <img src="{{ asset('image/arrow_back_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="←" class="date-changer__arrow-img">前月
        </a>
        @elseif ($selectInterval === 'day')
        <a href="{{ url()->current() . '?date=' . $selectDate->subDay()->format('Y-m-d') }}" class="date-changer">
            <img src="{{ asset('image/arrow_back_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="←" class="date-changer__arrow-img">前日
        </a>
        @endif
    </li>
    <li class="date-changer__li">
        <img src="{{ asset('image/calendar_month_24dp_4B4B4B.svg') }}" alt="🗓️" class="date-changer__calendar-img">
        @if ($selectInterval === 'month')
        <h2 class="date-changer__select-date">{{ $selectDate->format('Y/m') }}</h2>
        @elseif ($selectInterval === 'day')
        <h2 class="date-changer__select-date">{{ $selectDate->format('Y/m/d') }}</h2>
        @endif
    </li>
    <li class="date-changer__li">
        @if ($selectInterval === 'month')
        <a href="{{ url()->current() . '?date=' . $selectDate->addMonth()->format('Y-m') }}" class="date-changer">
            翌月<img src="{{ asset('image/arrow_forward_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="→" class="date-changer__arrow-img">
        </a>
        @elseif ($selectInterval === 'day')
        <a href="{{ url()->current() . '?date=' . $selectDate->addDay()->format('Y-m-d') }}" class="date-changer">
            翌日<img src="{{ asset('image/arrow_forward_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="→" class="date-changer__arrow-img">
        </a>
        @endif
    </li>
</ul>