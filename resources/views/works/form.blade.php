@if(count($user->projects) === 0)
    You haven't been assigned any projects.
@else
    <div class="form-group">
        <label for="projects" class="control-label">Project</label>
        <select class="selectpicker" data-tick-icon="check" id="project" name="project">
            @foreach($user->projects as $project)
                <option value='{{ $project->id }}'>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
@endif

<textarea class="form-control" placeholder="What did you exactly do?" rows="5" name="work_done"></textarea>

<div class="form-group label-static is-empty">
    <label for="rate" class="control-label">Hourly rate</label>
    <input type="number" class="form-control" name="rate" id="rate" placeholder="10.00" step="0.01"
           value="{{ number_format($user->rate, 2) }}">
</div>

<div class="form-group label-static is-empty">
    <label for="start" class="control-label">Start</label>
    <input type="datetime-local" class="form-control" id="start" name="start"
           value="{{ (new \Carbon\Carbon())->subHour()->format('Y-m-d\TH:00') }}">
</div>

<div class="form-group label-static is-empty">
    <label for="end" class="control-label">End</label>
    <input type="datetime-local" class="form-control" id="end" name="end"
           value="{{ (new \Carbon\Carbon())->format('Y-m-d\TH:00') }}">
</div>

<div>Money earned: <span id="amount">Fill in all values!</span></div>

@push('scripts')
    <script>
        const fields = {
            start: $("#start"),
            end: $("#end"),
            rate: $("#rate"),
        };

        const restrictFields = () => {
            fields.end.attr('min', fields.start.val());
            fields.start.attr('max', fields.end.val());
        };

        const handler = (event) => {
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