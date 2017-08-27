<?php

namespace App\Helpers;

class AuditHelper
{

    public static function prepareAudit(\OwenIt\Auditing\Models\Audit $audit)
    {
        $newAuditValues = [];

        foreach ($audit->getModified() as $key => $change) {
            if (isset($change['old']) && is_array($change['old'])) {
                $change['old'] = $change['old']['date'];
            }

            if (isset($change['new']) && is_array($change['new'])) {
                $change['new'] = $change['new']['date'];
            }

            if (isset($change['old']) && $change['old'] == $change['new']) {
                continue;
            }
            $newAuditValues[$key] = $change;
        }

        return [
            'user_id' => $audit->user_id,
            'type' => $audit->event,
            'created_at' => $audit->created_at,
            'values' => $newAuditValues,
        ];
    }

    public static function prepareAudits(\Illuminate\Support\Collection $audits)
    {
        return $audits->map(function ($audit) {
            return static::prepareAudit($audit);
        })->filter(function ($audit) {
            return count($audit['values']) > 0;
        })->reverse();
    }
}