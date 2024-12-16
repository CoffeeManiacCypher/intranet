@extends('layouts.module')

@vite(['resources/css/pacientes.css'])
@vite(['resources/js/tabla.js'])
@vite(['resources/js/pacientes.js'])


@section('title', 'Módulo de Giftcard')

@section('sidebar')
    <button class="sidebar-content" >
        Registro de Pacientes
    </button>
    <button class="sidebar-content" >
        Añadir Paciente
    </button>
    <button class="sidebar-content">Ver Fichas Médicas</button>
    <button class="sidebar-content">Analíticas</button>
@endsection

@section('content')

@endsection
<script>
    function exportTableToCSV() {
        const table = document.getElementById('paciente');
        const rows = table.querySelectorAll('tr');
        let csvContent = "";

        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const rowContent = Array.from(cells).map(cell => {
                const text = cell.innerText;
                return `"${text.replace(/"/g, '""')}"`;
            }).join(";");
            csvContent += rowContent + "\n";
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'empleos.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>