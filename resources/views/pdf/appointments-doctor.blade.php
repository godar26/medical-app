<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1e293b; font-size: 12px; }
        h1 { color: #0d9488; font-size: 20px; margin-bottom: 5px; }
        .subtitle { color: #64748b; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #0d9488; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 8px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge { padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .pending   { background: #fef3c7; color: #92400e; }
        .accepted  { background: #d1fae5; color: #065f46; }
        .completed { background: #dbeafe; color: #1e40af; }
        .cancelled { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 20px; color: #94a3b8; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
    <h1>MediBook — Mes Rendez-vous</h1>
    <p class="subtitle">Exporté le {{ now()->format('d/m/Y à H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Motif</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $apt)
            <tr>
                <td>{{ $apt->id }}</td>
                <td>{{ $apt->patient->first_name }} {{ $apt->patient->last_name }}</td>
                <td>{{ $apt->appointment_date->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge {{ $apt->status }}">
                        {{ ['pending'=>'En attente','accepted'=>'Accepté','completed'=>'Terminé','cancelled'=>'Annulé'][$apt->status] }}
                    </span>
                </td>
                <td>{{ $apt->reason ?? '—' }}</td>
                <td>{{ $apt->notes ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">MediBook · {{ $appointments->count() }} rendez-vous au total</p>
</body>
</html>