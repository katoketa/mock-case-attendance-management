{{-- $userと$showDataと$breakTimesと$canEditを親viewが持つか渡される必要がある --}}
@push('css')
<link rel="stylesheet" href="{{ asset('css/attendance_detail_table.css') }}">
@endpush
@if ($canEdit)
<input type="hidden" name="attendance_id" value="{{ $showData['id'] }}">
<input type="hidden" name="date" value="{{ $showData['punch_in_at']->format('Y-m-d ') }}">
@endif
<table class="detail-table">
    <tr class="detail-table__tr">
        <th class="detail-table__th">名前</th>
        <td class="detail-table__td">
            <span class="detail-table__td-username">{{ $user['name'] }}</span>
        </td>
    </tr>
    <tr class="detail-table__tr">
        <th class="detail-table__th">日付</th>
        <td class="detail-table__td">
            <div class="detail-table__td-flex">
                <span class="detail-table__td-span">{{ $showData['punch_in_at']->format('Y年') }}</span>
                <span class="detail-table__td-span"></span>
                <span class="detail-table__td-span">{{ $showData['punch_in_at']->format('m月d日') }}</span>
            </div>
        </td>
    </tr>
    <tr class="detail-table__tr">
        <th class="detail-table__th">出勤・退勤</th>
        <td class="detail-table__td">
            <div class="detail-table__td-flex">
                @if ($canEdit)
                <input type="time" name="punch_in_at" id="" class="detail-table__input-time" value="{{ $showData['punch_in_at']->format('H:i') }}">
                <span class="detail-table__td-span">〜</span>
                <input type="time" name="punch_out_at" id="" class="detail-table__input-time" value="{{ !empty($showData['punch_out_at']) ? $showData['punch_out_at']->format('H:i') : '' }}">
                <ul class="detail-table__error-ul">
                    @error('punch_in_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                    @error('punch_out_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                </ul>
                @else
                <span class="detail-table__td-span">{{ $showData['punch_in_at']->format('H:i') }}</span>
                <span class="detail-table__td-span">〜</span>
                <span class="detail-table__td-span">{{ $showData['punch_out_at']->format('H:i') }}</span>
                @endif
            </div>
        </td>
    </tr>
    {{-- foreach終了後にもループ変数$breaktime_iを追加の休憩用に使用するため、foreachの外側で宣言・初期化 --}}
    @php
    $breaktime_i = 0;
    @endphp
    @if (!empty($breakTimes))
    @foreach ($breakTimes as $breakTime)
    <tr class="detail-table__tr">
        @if ($breaktime_i === 0)
        <th class="detail-table__th">休憩</th>
        @else
        <th class="detail-table__th">休憩{{ $breaktime_i + 1 }}</th>
        @endif
        <td class="detail-table__td">
            <div class="detail-table__td-flex">
                @if ($canEdit)
                <input type="time" name="break_times[{{ $breaktime_i }}][start_break_at]" id="" class="detail-table__input-time" value="{{ $breakTime['start_break_at']->format('H:i') }}">
                <span class="detail-table__td-span">〜</span>
                <input type="time" name="break_times[{{ $breaktime_i }}][end_break_at]" id="" class="detail-table__input-time" value="{{ !empty($breakTime['end_break_at']) ? $breakTime['end_break_at']->format('H:i') : '' }}">
                <ul class="detail-table__error-ul">
                    @error('break_times.' . $breaktime_i . '.start_break_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                    @error('break_times.' . $breaktime_i . '.end_break_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                </ul>
                @else
                <span class="detail-table__td-span">{{ $breakTime['start_break_at']->format('H:i') }}</span>
                <span class="detail-table__td-span">〜</span>
                <span class="detail-table__td-span">{{ $breakTime['end_break_at']->format('H:i') }}</span>
                @endif
            </div>
        </td>
    </tr>
    @php
    $breaktime_i++;
    @endphp
    @endforeach
    @endif
    <tr class="detail-table__tr">
        @if ($breaktime_i === 0)
        <th class="detail-table__th">休憩</th>
        @else
        <th class="detail-table__th">休憩{{ $breaktime_i + 1 }}</th>
        @endif
        <td class="detail-table__td">
            <div class="detail-table__td-flex">
                @if ($canEdit)
                <input type="time" name="new_break_time[start_break_at]" id="" class="detail-table__input-time">
                <span class="detail-table__td-span">〜</span>
                <input type="time" name="new_break_time[end_break_at]" id="" class="detail-table__input-time">
                <ul class="detail-table__error-ul">
                    @error('new_break_time.start_break_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                    @error('new_break_time.end_break_at')
                    <li class="detail-table__error-li">{{ $message }}</li>
                    @enderror
                </ul>
                @endif
            </div>
        </td>
    </tr>
    <tr class="detail-table__tr">
        <th class="detail-table__th">備考</th>
        @if ($canEdit)
        <td class="detail-table__td">
            <textarea name="remarks" id="" class="detail-table__textarea">{{ $showData['remarks'] }}</textarea>
            <ul class="detail-table__error-ul">
                @error('remarks')
                <li class="detail-table__error-li">{{ $message }}</li>
                @enderror
            </ul>
        </td>
        @else
        <td class="detail-table__td">
            <div class="detail-table__td-remarks">{{ $showData['remarks'] }}</div>
        </td>
        @endif
    </tr>
</table>

@push('scripts')
<script>
    const toggleClassIfEmpty = (element, className) => {
        if (element.value === "") {
            element.classList.add(className);
        } else {
            element.classList.remove(className);
        }
    }
    const elements = document.getElementsByClassName('detail-table__input-time');
    for (const element of elements) {
        toggleClassIfEmpty(element, "detail-table__input-time--empty");
        element.addEventListener('blur', () => {
            toggleClassIfEmpty(element, "detail-table__input-time--empty");
        });
    }
</script>
@endpush