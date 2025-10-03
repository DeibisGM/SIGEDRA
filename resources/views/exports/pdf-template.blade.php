<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de {{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        
        .info {
            margin-bottom: 20px;
            font-size: 9px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            font-size: 8px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .summary {
            background-color: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 9px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIGEDRA - Sistema de Gestión de Registro Académico</h1>
        <h2>Reporte de {{ $title }}</h2>
    </div>
    
    <div class="info">
        <p><strong>Fecha de generación:</strong> {{ $generatedAt }}</p>
        <p><strong>Total de registros:</strong> {{ $totalRecords }}</p>
    </div>
    
    <div class="summary">
        <strong>Resumen:</strong> Este reporte contiene la información detallada de {{ strtolower($title) }} del sistema SIGEDRA.
    </div>
    
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>SIGEDRA © {{ date('Y') }} - Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>