// Script para exportar tablas a PDF usando jsPDF y AutoTable
// Requiere que jsPDF y AutoTable estén cargados antes de este script

function asignarEventosPDFReportes() {
    function exportTableToPDF(tableId, title) {
        if (!window.jspdf || !window.jspdf.jsPDF) {
            alert('jsPDF no está disponible. Intenta recargar la página.');
            return;
        }
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.getElementById(tableId);
        if (!table) return;
        // LOGO y texto superior
        const logoUrl = '/Proyecto/imagen/logo.jpg';
        const isDetalle = tableId === 'tabla-detalle-menores5' || tableId === 'tabla-detalle-6a14';
        const getRows = () => {
            // Agrupación por comunidad para los detalles
            const rows = [];
            let comunidadActual = '';
            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.classList.contains('encabezado-comunidad')) {
                    comunidadActual = tr.textContent.trim();
                    rows.push({ comunidad: comunidadActual, isHeader: true });
                } else {
                    const tds = tr.querySelectorAll('td');
                    const row = Array.from(tds).map(td => td.innerText);
                    rows.push({ comunidad: comunidadActual, isHeader: false, row });
                }
            });
            return rows;
        };
        const img = new Image();
        img.src = logoUrl;
        img.onload = function() {
            // Fondo superior
            doc.setFillColor(41, 128, 185); // azul principal
            doc.rect(0, 0, 210, 30, 'F');
            // Logo y título
            doc.addImage(img, 'JPEG', 160, 8, 35, 18);
            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(255,255,255);
            doc.text('Koutuushi Wapushua Reportes', 14, 18);
            doc.setFontSize(14);
            doc.setFont('helvetica', 'normal');
            doc.text(title.replace(/_/g, ' '), 14, 28);
            // Ajuste: usar autoTable para los detalles agrupando por comunidad
            if (isDetalle) {
                // Agrupar por comunidad y mostrar encabezado de comunidad como fila especial (no como columna)
                const head = [[
                    'ID Familia', 'Tipo Doc', 'N° Doc', 'Nombres', 'Apellidos', 'Fecha Nac.', 'Teléfono', 'Correo', 'Cuidador'
                ]];
                let body = [];
                let comunidadActual = '';
                table.querySelectorAll('tbody tr').forEach(tr => {
                    if (tr.classList.contains('encabezado-comunidad')) {
                        comunidadActual = tr.textContent.trim();
                        // Fila especial para comunidad (span de columnas)
                        body.push([{content: comunidadActual, colSpan: 9, styles: {fillColor: [41,128,185], textColor: 255, fontStyle: 'bold', halign: 'left'}}]);
                    } else {
                        const row = [];
                        tr.querySelectorAll('td').forEach(td => row.push(td.innerText));
                        body.push(row);
                    }
                });
                doc.autoTable({
                    head: head,
                    body: body,
                    startY: 37,
                    styles: { fontSize: 9, cellPadding: 1.5 },
                    headStyles: { fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [240, 240, 240] },
                    margin: { left: 14, right: 14 },
                    didParseCell: function(data) {
                        if (data.row.raw && data.row.raw[0] && data.row.raw[0].colSpan) {
                            data.cell.styles.fontStyle = 'bold';
                            data.cell.styles.fillColor = [41,128,185];
                            data.cell.styles.textColor = 255;
                            data.cell.styles.halign = 'left';
                        }
                    }
                });
            } else {
                // Para tablas normales usa autoTable
                // Extraer encabezados y filas de la tabla HTML
                const head = [];
                table.querySelectorAll('thead tr').forEach(tr => {
                    const row = [];
                    tr.querySelectorAll('th').forEach(th => row.push(th.innerText));
                    head.push(row);
                });
                const body = [];
                table.querySelectorAll('tbody tr').forEach(tr => {
                    const row = [];
                    tr.querySelectorAll('td').forEach(td => row.push(td.innerText));
                    body.push(row);
                });
                doc.autoTable({
                    head: head,
                    body: body,
                    startY: 37,
                    styles: { fontSize: 12, cellPadding: 3 },
                    headStyles: { fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [240, 240, 240] },
                    margin: { left: 14, right: 14 }
                });
            }
            doc.save(title + '.pdf');
        };
        img.onerror = function() {
            alert('No se pudo cargar el logo.');
        };
    }

    const btns = [
        { id: 'pdf-comunidades-unidad', table: 'tabla-comunidades-unidad', title: 'Comunidades_por_Unidad' },
        { id: 'pdf-familias-comunidad', table: 'tabla-familias-comunidad', title: 'Familias_por_Comunidad' },
        { id: 'pdf-familias-menores5', table: 'tabla-familias-menores5', title: 'Familias_menores_5' },
        { id: 'pdf-familias-6a14', table: 'tabla-familias-6a14', title: 'Familias_6_a_14' },
        { id: 'pdf-detalle-menores5', table: 'tabla-detalle-menores5', title: 'Detalle_Ninos_Menores_5' },
        { id: 'pdf-detalle-6a14', table: 'tabla-detalle-6a14', title: 'Detalle_Ninos_6_a_14' }
    ];
    btns.forEach(function(btn) {
        const el = document.getElementById(btn.id);
        if (el) {
            el.onclick = function() {
                exportTableToPDF(btn.table, btn.title);
            };
        }
    });
}

// Si el DOM ya tiene los botones (carga directa), asigna eventos al cargar
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', asignarEventosPDFReportes);
} else {
    asignarEventosPDFReportes();
}
// Permite llamar desde fuera tras carga dinámica
document.asignarEventosPDFReportes = asignarEventosPDFReportes;
