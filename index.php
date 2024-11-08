<?php
require_once './src/controllers/EntidadesEducativas.php';

// Crear una instancia del controlador
$entidadesEducativas = new EntidadesEducativas(new Database());
$instituciones = $entidadesEducativas->getStadistcByDepStatus();
$institucionesPorCaracterAcademico = $entidadesEducativas->stadisticsByAcademicCharacter();
$institucionesPorSectorDepartamento = $entidadesEducativas->stadisticBySectorDept();
$institucionesPorActoAdmon = $entidadesEducativas->stadisticByActoAdmon();
$institucionesPorNormaCreacion = $entidadesEducativas->stadisticByNormaCreacion();

// Formatear los datos para pasarlos a JavaScript
$departamentos = [];
$institucionesActivas = [];
$institucionesInactivas = [];
$tiposCaracterAcademico = [];
$totalInstitucionesPorCaracter = [];
$actosAdministrativos = [];
$totalInstitucionesPorActo = [];
$sectores = [];
$institucionesPrivadas = [];
$institucionesPublicas = [];
$normasCreacion = [];
$totalInstitucionesPorNorma = [];

foreach ($instituciones as $institucion) {
    $departamentos[] = $institucion['nomb_depto'];
    if ($institucion['nomb_estado'] === 'Activa') {
        $institucionesActivas[] = $institucion['total_instituciones'];
        $institucionesInactivas[] = 0; // Para mantener el índice alineado
    } else {
        $institucionesInactivas[] = $institucion['total_instituciones'];
        $institucionesActivas[] = 0; // Para mantener el índice alineado
    }
}

// Formatear los datos para el gráfico de tipo de carácter académico
foreach ($institucionesPorCaracterAcademico as $caracter) {
    $tiposCaracterAcademico[] = $caracter['nomb_academ'];
    $totalInstitucionesPorCaracter[] = $caracter['total_inst'];
}

// Formatear los datos para el gráfico de instituciones por sector en cada departamento
foreach ($institucionesPorSectorDepartamento as $sector) {
    $sectores[] = $sector['nomb_depto'];
    if ($sector['nomb_sector'] == 'privado') {
        $institucionesPrivadas[] = $sector['total_inst'];
        $institucionesPublicas[] = 0;
    } else {
        $institucionesPublicas[] = $sector['total_inst'];
        $institucionesPrivadas[] = 0;
    }
}

// Formatear los datos para el gráfico de instituciones por acto administrativo
foreach ($institucionesPorActoAdmon as $acto) {
    $actosAdministrativos[] = $acto['nomb_admon'];
    $totalInstitucionesPorActo[] = $acto['total_inst'];
}

foreach ($institucionesPorNormaCreacion as $norma) {
    $normasCreacion[] = $norma['nomb_norma'];
    $totalInstitucionesPorNorma[] = $norma['total_inst'];
}
?>

<?php include './src/components/Header.php'; ?>
<body class="bg-gray-100">

    <?php include './src/components/navBar.php'; ?>
    <?php include './src/components/Menu.php'; ?>

    <section class="h-screen ml-[25vh] px-4 py-16">
        <h1 class="text-3xl font-bold px-4 mb-4">Reportes y Estadísticas de Instituciones</h1>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones Activas e Inactivas por Departamento</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorDepartamento" width="400" height="auto"></canvas>
        </div>
        
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Tipo de Carácter Académico,por Acto Administrativo y Norma Creacion</h2>
        <div class="flex flex-wrap gap-4 bg-white shadow-md rounded-lg items-center justify-center p-4 mb-4">
            <div style="max-width: 600px; flex: 1;">
                <canvas id="institucionesPorCaracterAcademico" width="200" height="200"></canvas>
            </div>
            <div style="max-width: 600px; flex: 1;">
                <canvas id="institucionesPorActoAdmon" width="200" height="200"></canvas>
            </div>
            <div style="max-width: 600px; flex: 1;">
                <canvas id="institucionesPorNormaCreacion" width="200" height="200"></canvas>
            </div>
        </div>

        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Sector en Cada Departamento</h2>
        <div class="bg-white shadow-md rounded-lg px-4 py-2">
            <canvas id="institucionesPorSector" width="400" height="auto"></canvas>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Pasar los datos de PHP a JavaScript
        const departamentos = <?php echo json_encode($departamentos); ?>;
        const institucionesActivas = <?php echo json_encode($institucionesActivas); ?>;
        const institucionesInactivas = <?php echo json_encode($institucionesInactivas); ?>;
        const tiposCaracterAcademico = <?php echo json_encode($tiposCaracterAcademico); ?>;
        const totalInstitucionesPorCaracter = <?php echo json_encode($totalInstitucionesPorCaracter); ?>;
        const actosAdministrativos = <?php echo json_encode($actosAdministrativos); ?>;
        const totalInstitucionesPorActo = <?php echo json_encode($totalInstitucionesPorActo); ?>;
        const sectores = <?php echo json_encode($sectores); ?>;
        const institucionesPrivadas = <?php echo json_encode($institucionesPrivadas); ?>;
        const institucionesPublicas = <?php echo json_encode($institucionesPublicas); ?>;
        const normasCreacion = <?php echo json_encode($normasCreacion); ?>;
        const totalInstitucionesPorNorma = <?php echo json_encode($totalInstitucionesPorNorma); ?>;

        // Configuración del gráfico de instituciones por departamento
        const ctxDepartamentos = document.getElementById('institucionesPorDepartamento').getContext('2d');
        const chartDepartamentos = new Chart(ctxDepartamentos, {
            type: 'bar',
            data: {
                labels: departamentos,
                datasets: [
                    {
                        label: 'Instituciones Activas',
                        data: institucionesActivas,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Instituciones Inactivas',
                        data: institucionesInactivas,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Configuración del gráfico de instituciones por carácter académico
        const ctxCaracterAcademico = document.getElementById('institucionesPorCaracterAcademico').getContext('2d');
        const chartCaracterAcademico = new Chart(ctxCaracterAcademico, {
            type: 'pie',
            data: {
                labels: tiposCaracterAcademico,
                datasets: [
                    {
                        label: 'Total de Instituciones',
                        data: totalInstitucionesPorCaracter,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)', // Azul
                            'rgba(255, 99, 132, 0.5)', // Rojo
                            'rgba(75, 192, 192, 0.5)', // Verde
                            'rgba(255, 206, 86, 0.5)', // Amarillo
                            'rgba(153, 102, 255, 0.5)', // Morado
                            'rgba(255, 159, 64, 0.5)', // Naranja
                            'rgba(201, 203, 207, 0.5)' // Gris
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                            }
                        }
                    }
                }
            }
        });

        // Configuración del gráfico de instituciones por sector en cada departamento
        const ctxSector = document.getElementById('institucionesPorSector').getContext('2d');
        const chartSector = new Chart(ctxSector, {
            type: 'bar',
            data: {
                labels: sectores,
                datasets: [
                    {
                        label: 'Total de Privadas',
                        data: institucionesPrivadas,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)', // Color morado
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total de Públicas',
                        data: institucionesPublicas,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)', // Color naranja
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Configuración del gráfico de instituciones por acto administrativo
        const ctxActoAdmon = document.getElementById('institucionesPorActoAdmon').getContext('2d');
        const chartActoAdmon = new Chart(ctxActoAdmon, {
            type: 'pie',
            data: {
                labels: actosAdministrativos,
                datasets: [
                    {
                        label: 'Total de Instituciones',
                        data: totalInstitucionesPorActo,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)', // Rojo
                            'rgba(54, 162, 235, 0.5)', // Azul
                            'rgba(255, 206, 86, 0.5)', // Amarillo
                            'rgba(75, 192, 192, 0.5)' // Verde
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                            }
                        }
                    }
                }
            }
        });

        // Configuración del gráfico de instituciones por norma de creación
        const ctxNormaCreacion = document.getElementById('institucionesPorNormaCreacion').getContext('2d');
        const chartNormaCreacion = new Chart(ctxNormaCreacion, {
            type: 'pie',
            data: {
                labels: normasCreacion,
                datasets: [
                    {
                        label: 'Total de Instituciones',
                        data: totalInstitucionesPorNorma,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)', // Azul
                            'rgba(255, 99, 132, 0.5)', // Rojo
                            'rgba(75, 192, 192, 0.5)', // Verde
                            'rgba(255, 206, 86, 0.5)', // Amarillo
                            'rgba(153, 102, 255, 0.5)', // Morado
                            'rgba(255, 159, 64, 0.5)', // Naranja
                            'rgba(201, 203, 207, 0.5)' // Gris
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw} instituciones`;
                            }
                        }
                    }
                }
            }
        });

    </script>
</body>
</html>
