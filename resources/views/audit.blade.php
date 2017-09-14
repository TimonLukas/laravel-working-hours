<div class="card">
    <div class="card-header" data-background-color="green">
        <h4 class="title">Audit log</h4>
        <p class="category">Any and all changes done to this resource</p>
    </div>
    <div class="card-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Type</th>
                <th>Done by</th>
                <th>Done on</th>
                <th>Change</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Helpers\AuditHelper::prepareAudits($resource->audits) as $audit)
                <tr>
                    <td>{{ ucfirst($audit['type']) }}</td>
                    <td>{{ ($user = \App\User::find($audit['user_id'])) !== null ? $user->name : 'Deleted user' }}</td>
                    <td>{{ $audit['created_at']->format('Y-m-d h:i:s') }}</td>
                    <td>
                        <ul>
                            @foreach($audit['values'] as $key => $values)
                                <li>
                                    <b>{{ $key }}:</b>
                                    @if(isset($values['old']))
                                        "{{ $values['old'] }}" &rarr;
                                    @endif
                                    "{{ json_encode($values['new']) }}"
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>