<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RevisionAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'punch_in_at' => 'required|before_or_equal:punch_out_at',
            'punch_out_at' => 'required',
            'break_times.*.start_break_at' => 'required|before_or_equal:punch_out_at|after_or_equal:punch_in_at',
            'break_times.*.end_break_at' => 'required|before_or_equal:punch_out_at',
            'new_break_time.start_break_at' => 'nullable|required_with:new_break_time.end_break_at|before_or_equal:punch_out_at|after_or_equal:punch_in_at',
            'new_break_time.end_break_at' => 'nullable|required_with:new_break_time.start_break_at|before_or_equal:punch_out_at',
            'remarks' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'punch_in_at.required' => '出勤時間は必須項目です',
            'punch_in_at.before_or_equal' => '出勤時間もしくは退勤時間が不適切な値です',
            'punch_out_at.required' => '退勤時間は必須項目です',
            'break_times.*.start_break_at.required' => '休憩開始時間を入力してください',
            'break_times.*.start_break_at.before_or_equal' => '休憩時間が不適切な値です',
            'break_times.*.start_break_at.after_or_equal' => '休憩時間が不適切な値です',
            'break_times.*.end_break_at.required' => '休憩終了時間を入力してください',
            'break_times.*.end_break_at.before_or_equal' => '休憩時間もしくは退勤時間が不適切な値です',
            'new_break_time.start_break_at.required_with' => '休憩開始時間も必要です',
            'new_break_time.start_break_at.before_or_equal' => '休憩時間が不適切な値です',
            'new_break_time.start_break_at.after_or_equal' => '休憩時間が不適切な値です',
            'new_break_time.end_break_at.required_with' => '休憩終了時間も必要です',
            'new_break_time.end_break_at.before_or_equal' => '休憩時間または退勤時間が不適切な値です',
            'remarks.required' => '備考を記入してください',
            'remarks.max' => '文字数が255文字を超えています',
        ];
    }
}
