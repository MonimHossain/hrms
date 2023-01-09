<input type="hidden" value="{{ $holiday_id }}" name="holiday_id" id="holidayid">
<div class="row">

    <table class="table">
        <thead>
            <th>Division</th>
            <th>Centers</th>
        </thead>
        <tbody>
            @foreach ($divisions as $division)
            <tr>
                <td>{{ $division->name }}</td>
                <td>
                    <div class="checkbox-list">
                        @foreach ($division->centers as $center)
                        @php
                            $check = $activeHoliday->centers->filter(function($item, $key) use ($center, $holiday_id, $activeHoliday){
                                return ($item->id == $center->id && $activeHoliday->id == $holiday_id);
                            });
                            // dump($check);
                        @endphp
                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                        <input type="checkbox" class="center-checkbox" {{ (($check->first()) && $check->first()->id == $center->id) ? 'checked="checked"' : '' }} value="{{ $center->id }}" name="center_id[]">
                        <span></span>{{ $center->center }}</label>
                        <input type="hidden" value="{{ $division->id }}" name="division_id[]">
                        @endforeach
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="col-xl-4">
        <div class="form-group">
            <div class="kt-form__actions" style="margin-top: 26px;">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
