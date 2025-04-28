<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: DejaVu Sans, sans-serif; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .section { margin-bottom: 20px; }
                    .section-title {
                        background: #008caa;
                        color: white;
                        padding: 5px 10px;
                        margin-bottom: 10px;
                    }
                    .data-row {
                        display: flex;
                        margin-bottom: 5px;
                        border-bottom: 1px solid #eee;
                        padding: 5px 0;
                    }
                    .label {
                        font-weight: bold;
                        min-width: 200px;
                    }
                    .value { flex: 1; }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th { background: #f5f5f5; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Export des données du client</h1>
                    <h2>{{ $client->name_boite }}</h2>
                    <p>Date d'export : {{ now()->format('d/m/Y H:i') }}</p>
                </div>

                @foreach($data as $sectionTitle => $sectionData)
                    <div class="section">
                        <div class="section-title">{{ $sectionTitle }}</div>

                        @if($sectionTitle !== 'Services')
                            @foreach($sectionData as $label => $value)
                                <div class="data-row">
                                    <span class="label">{{ $label }}</span>
                                    <span class="value">{{ $value ?: '—' }}</span>
                                </div>
                            @endforeach
                        @else
                            @foreach($sectionData as $serviceKey => $serviceValue)
                                @if(is_array($serviceValue))
                                    <h4>{{ $serviceKey }}</h4>
                                    @if(!empty($serviceValue))
                                        <table>
                                            <thead>
                                                <tr>
                                                    @foreach(array_keys(reset($serviceValue)) as $header)
                                                        <th>{{ $header }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($serviceValue as $row)
                                                    <tr>
                                                        @foreach($row as $cell)
                                                            <td>{{ $cell }}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>Aucune donnée</p>
                                    @endif
                                @else
                                    <div class="data-row">
                                        <span class="label">{{ $serviceKey }}</span>
                                        <span class="value">{{ $serviceValue }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </body>
            </html>
