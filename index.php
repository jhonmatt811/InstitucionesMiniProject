<?php
require_once './src/controllers/EntidadesEducativas.php';
require_once './src/controllers/Departamentos.php';

$deptController = new Departamentos();
$departamentosName = $deptController->getAll();

$tipoEstadistica = $_POST['tipo_estadistica'] ?? null;
$departamentoSeleccionado = $_POST['departamento'] ?? null;
// Crear una instancia del controlador
$entidadesEducativas = new EntidadesEducativas(new Database());
$instituciones = $entidadesEducativas->getStadistcByDepStatus();
$institucionesPorCaracterAcademico = $entidadesEducativas->stadisticsByAcademicCharacter();
$institucionesPorSectorDepartamento = $entidadesEducativas->stadisticBySectorDept();
$institucionesPorActoAdmon = $entidadesEducativas->stadisticByActoAdmon();
$institucionesPorNormaCreacion = $entidadesEducativas->stadisticByNormaCreacion();

// Inicializar valores

// Formatear los datos para JavaScript
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

foreach ($institucionesPorCaracterAcademico as $caracter) {
    $tiposCaracterAcademico[] = $caracter['nomb_academ'];
    $totalInstitucionesPorCaracter[] = $caracter['total_inst'];
}

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

        <form method="POST" action="" class="flex flex-col gap-4 px-4 py-4 bg-white shadow-md rounded-md">
            <h2 class="text-xl font-semibold mb-2">Selecciona la Estadística a Consultar</h2>

            <div>
                <label for="tipo_estadistica" class="block text-black font-medium mb-1">Tipo de Estadística:</label>
                <select id="tipo_estadistica" name="tipo_estadistica" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="" disabled selected>-- Selecciona una busqueda --</option>
                    <option value="1" <?= $tipoEstadistica == "1" ? 'selected' : '' ?>>Instituciones Activas e Inactivas por Departamento</option>
                    <option value="2" <?= $tipoEstadistica == "2" ? 'selected' : '' ?>>Instituciones por Tipo de Carácter Académico</option>
                    <option value="3" <?= $tipoEstadistica == "3" ? 'selected' : '' ?>>Instituciones por Sector en Cada Departamento</option>
                    <option value="4" <?= $tipoEstadistica == "4" ? 'selected' : '' ?>>Instituciones por Acto Administrativo</option>
                    <option value="5" <?= $tipoEstadistica == "5" ? 'selected' : '' ?>>Instituciones por Norma de Creación</option>
                </select>
            </div>

            <div>
                <label for="dept_input" class="block text-black font-medium mb-1">Departamento:</label>
                <select id="dept_input" name="departamento" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="" disabled selected>-- Selecciona un departamento si es necesario--</option>
                    <option value="Todos">Todos</option>
                    <?php
                        foreach ($dpto as $departamentosName):
                    ?>
                        <option value="<?= $departamentosName['nomb_depto'] ?>" <?= $departamentoSeleccionado == $departamentosName['nomb_depto'] ? 'selected' : '' ?>><?= $departamentosName['nomb_depto'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="reset" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Cancelar</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Confirmar</button>
            </div>
        </form>

        <?php if ($tipoEstadistica == "1"): ?>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones Activas e Inactivas por Departamento</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorDepartamento" width="400" height="auto"></canvas>
        </div>
        <?php elseif ($tipoEstadistica == "2"): ?>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Tipo de Carácter Académico</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorCaracterAcademico" width="400" height="auto"></canvas>
        </div>
        <?php elseif ($tipoEstadistica == "3"): ?>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Sector en Cada Departamento</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorSector" width="400" height="auto"></canvas>
        </div>
        <?php elseif ($tipoEstadistica == "4"): ?>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Acto Administrativo</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorActoAdmon" width="400" height="auto"></canvas>
        </div>
        <?php elseif ($tipoEstadistica == "5"): ?>
        <h2 class="text-2xl font-bold px-4 mb-2">Instituciones por Norma de Creación</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <canvas id="institucionesPorNormaCreacion" width="400" height="auto"></canvas>
        </div>
        <?php endif; ?>
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
        const tipoEstadistica = "<?php echo $tipoEstadistica; ?>";
        const departamentoSelected = "<?php echo $departamentoSeleccionado; ?>";
        
        let labelsFiltered = [];
        let dataActivasFiltered = [];
        let dataInactivasFiltered = [];

        // Filtrar datos según el departamento seleccionado
        if (departamentoSelected === "Todos" || !departamentoSelected) {
            labelsFiltered = [...departamentos];
            dataActivasFiltered = [...institucionesActivas];
            dataInactivasFiltered = [...institucionesInactivas];
        } else {
            const index = departamentos.indexOf(departamentoSelected);
            if (index !== -1) {
                labelsFiltered = [departamentos[index]];
                dataActivasFiltered = [institucionesActivas[index]];
                dataInactivasFiltered = [institucionesInactivas[index]];
            }
        }

        console.log('here',labelsFiltered);
        // Configuración del gráfico de instituciones por departamento
        if(tipoEstadistica == '1'){            
        
            const ctxDepartamentos = document.getElementById('institucionesPorDepartamento').getContext('2d');
            const chartDepartamentos = new Chart(ctxDepartamentos, {
                type: 'bar',
                data: {
                    labels: labelsFiltered,
                    datasets: [
                        {
                            label: 'Instituciones Activas',
                            data: dataActivasFiltered,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Instituciones Inactivas',
                            data: dataInactivasFiltered,
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
        }
        else if(tipoEstadistica == '2'){

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
        }
        else if(tipoEstadistica == '3'){

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
        }
        else if(tipoEstadistica == '4'){
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
        }
        else if(tipoEstadistica == '5'){
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
        }
    </script>
</body>
</html>
