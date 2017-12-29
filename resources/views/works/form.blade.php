@php
    $option = $option ?? "";
@endphp
<input type="hidden" name="option" value="{{ $option }}">
<input type="hidden" name="work_unit" value="{{ $work->id }}">

@if(count($user->projects) === 0)
    You haven't been assigned to any projects.
@elseif($option !== "createEnd")
    <div class="form-group">
        <label for="projects" class="control-label"></label>
        <select class="selectpicker" data-tick-icon="check" id="project" name="project">
            @foreach($user->projects as $project)
                <option {{ $work->project !== null && $work->project->id === $project->id ? "selected" : "" }} value='{{ $project->id }}'>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
@endif

@if($option !== "createStart")
    <textarea class="form-control" placeholder="What did you exactly do?" rows="5"
              name="work_done">{{ $work->work_done }}</textarea>
@else
    <input type="hidden" name="work_done" value={{ $work->work_done }}"">
@endif

@if(Auth::user()->is_manager)
    <div class="form-group label-static is-empty">
        <label for="rate" class="control-label">Hourly rate</label>
        <input type="number" class="form-control" name="rate" id="rate" placeholder="10.00" step="0.01"
               value="{{ number_format($work->rate ?: $user->rate, 2) }}">
    </div>
@endif

@if($option !== "createStart" && $option !== "createEnd")
    <div class="form-group label-static is-empty">
        <label for="start" class="control-label">Start</label>
        <input type="datetime-local" class="form-control" id="start" name="start"
               value="{{ ($work->start ?: (new \Carbon\Carbon())->subHour())->format('Y-m-d\TH:i') }}">
    </div>

    <div class="form-group label-static is-empty">
        <label for="end" class="controlS-label">End</label>
        <input type="datetime-local" class="form-control" id="end" name="end"
               value="{{ ($work->start !== null ? $work->start->addMinutes($work->hours * 60) : new \Carbon\Carbon())->format('Y-m-d\TH:00') }}">
    </div>
@endif

@if($option !== "createStart" && $option !== "createEnd" && Auth::user()->is_manager)
    <div>Money earned: <span id="amount">Fill in all values!</span></div>

    @push('scripts')
        <script>
            const fields = {
                start: $("#start"),
                end: $("#end"),
                rate: $("#rate")
            };

            const restrictFields = function () {
                fields.end.attr('min', fields.start.val());
                fields.start.attr('max', fields.end.val());
            };

            const handler = function (event) {
                const rate = Number(fields.rate.val()),
                    start = moment(fields.start.val(), 'YYYY-MM-DD\\THH:mm'),
                    end = moment(fields.end.val(), 'YYYY-MM-DD\\THH:mm');

                restrictFields();

                // end - start is the difference in milliseconds
                // 60 * 1000 is the milliseconds in a minute
                // 60 is the minutes in an hour
                const hours = (end - start) / (60 * 1000) / 60;

                $("#amount").text(Math.round(hours * rate * 100) / 100);
            };

            for (const field in fields) {
                fields[field].on('input', handler);
            }

            restrictFields();
        </script>
    @endpush
@endif