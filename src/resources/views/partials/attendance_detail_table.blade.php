{{-- $userと$showDataと$breakTimesと$canEditを親viewが持つか渡される必要がある --}}
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
                <input type="time" name="punch_in_at" id="" class="detail-table__input" value="{{ $showData['punch_in_at']->format('h:i') }}">
                <span class="detail-table__td-span"></span>
                <input type="time" name="punch_out_at" id="" class="detail-table__input" value="{{ $showData['punch_out_at']->format('h:i') }}">
                @else
                <span class="detail-table__td-span">{{ $showData['punch_in_at']->format('h:i') }}</span>
                <span class="detail-table__td-span">〜</span>
                <span class="detail-table__td-span">{{ $showData['punch_out_at']->format('h;i') }}</span>
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
                <input type="time" name="break_times[{{ $breaktime_i }}][start_break_at]" id="" class="detail-table__input" value="{{ $breakTime['start_break_at']->format('h:i') }}">
                <span class="detail-table__td-span">〜</span>
                <input type="time" name="break_times[{{ $breaktime_i }}][end_break_at]" id="" class="detail-table__input" value="{{ $breakTime['end_break_at']->format('h:i') }}">
                @else
                <span class="detail-table__td-span">{{ $breakTime['start_break_at']->format('h:i') }}</span>
                <span class="detail-table__td-span"></span>
                <span class="detail-table--td-span">{{ $breakTime['end_break_at']->format('h:i') }}</span>
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
                <input type="time" name="new_start_break_at" id="" class="detail-table__input" value="{{ $showData['new_start_break_at'] }}">
                <span class="detail-table__td-span">〜</span>
                <input type="time" name="new_end_break_at" id="" class="detail-table__input" value="{{ $showData['new_end_break_at'] }}">
                @else
                <td class="detail-table__td"></td>
                @endif
            </div>
        </td>
    </tr>
    <tr class="detail-table__tr">
        <th class="detail-table__th">備考</th>
        @if ($canEdit)
        <td class="detail-table__td">
            <textarea name="remarks" id="" class="detail-table__textarea">{{ $showData['remarks'] }}</textarea>
        </td>
        @else
        <td class="detail-table__td">
            <span class="detail-table__td-span">{{ $showData['remarks'] }}</span>
        </td>
        @endif
    </tr>
</table>

@section('script')
<script>
    const toggleClassIfEmpty = (element, className) => {
        if (element.value === "") {
            element.classList.add(className);
        } else {
            element.classList.remove(className);
        }
    }
    const elements = document.getElementsByClassName('detail-table__input');
    for (const element of elements) {
        toggleClassIfEmpty(element, "detail-table__input--empty");
        element.addEventListener('blur', () => {
            toggleClassIfEmpty(element, "detail-table__input--empty");
        });
    }
</script>
@endsection